<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, Category, Element, Image, Location, Race } from '@/types';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Switch } from '@/components/ui/switch';
import InputError from '@/components/InputError.vue';
import Heading from '@/components/Heading.vue';
import { toast } from 'vue-sonner';
import ImagePicker from '@/components/ImagePicker.vue';
import { Select, SelectTrigger, SelectGroup, SelectContent, SelectItem, SelectValue } from '@/components/ui/select';
import { computed } from 'vue';
import { cn } from '@/lib/utils';
import { CheckIcon, ChevronDownIcon, SearchIcon } from 'lucide-vue-next';
import {
    Combobox,
    ComboboxAnchor,
    ComboboxEmpty,
    ComboboxGroup, ComboboxInput,
    ComboboxItem, ComboboxItemIndicator,
    ComboboxList,
    ComboboxTrigger
} from '@/components/ui/combobox';
import { NumberField, NumberFieldContent, NumberFieldDecrement, NumberFieldIncrement, NumberFieldInput } from '@/components/ui/number-field';
import { ScrollArea } from '@/components/ui/scroll-area';

interface Props {
    images: Image[];
    races: Race[];
    elements: Element[];
    combat_modes: Array;
    defence_types: Array;
    categories: Category[];
    locations: Location[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Добавление монстра',
        href: '/monsters/create',
    },
];

const form = useForm({
    name: '',
    level: 0,
    health_points: 1,
    element_strength: 1,
    is_aggressive: false,
    is_elite: false,
    is_boss: false,
    pick_up_loot: false,
    shield: 0,
    defence: '',
    experience: 0,
    xp_per_hp: 0.00,
    combat_mode: '',
    quest_only: false,
    race_id: 0,
    element_id: 0,
    image_id: 0,
    big_image_id: 0,
    categories: [],
    locations: [],
})

const submit = () => {
    form.post(route('monsters.store'), {
        onSuccess: () => {
            toast.success('Успешно добавлено');
        }
    });
}

const selectedImage = computed(() => {
    return props.images.find(img => img.id === form.image_id)
});

const selectedElement = computed(() => {
    return props.elements.find(el => el.id === form.element_id)
});

const selectedRace = computed(() => {
    return props.races.find(race => race.id === form.race_id)
});

</script>

<template>
    <Head title="Добавление монстра" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading title="Добавление монстра" />

            <form @submit.prevent="submit">
                <div class="flex flex-col space-y-8 md:space-y-0 lg:flex-row lg:space-y-0 lg:space-x-12">
                    <div class="flex-1 md:max-w-2xl">
                        <section class="max-w-xl space-y-6">
                            <div class="grid gap-2">
                                <Label for="name">Название</Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    autocomplete="off"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="Название"
                                />
                                <InputError :message="form.errors.name" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="image">Изображение</Label>
                                <div v-if="selectedImage">
                                    <img
                                        class="w-[150px]"
                                        :src="selectedImage.media[0].original_url"
                                        :alt="selectedImage.name"
                                    />
                                </div>
                                <ImagePicker
                                    :images="images"
                                    v-model="form.image_id"
                                />
                                <InputError :message="form.errors.image_id" />
                            </div>

                            <div class="gap-2">
                                <NumberField
                                    invert-wheel-change
                                    id="level"
                                    v-model="form.level"
                                    :default-value="1"
                                    :min="1"
                                    :max="70"
                                >
                                    <Label for="level">Уровень</Label>
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                            </div>

                            <div class="gap-2">
                                <NumberField
                                    invert-wheel-change
                                    id="health_points"
                                    v-model="form.health_points"
                                    :default-value="1"
                                    :min="1"
                                >
                                    <Label for="health_points">Жизни</Label>
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                            </div>

                            <div class="gap-2">
                                <NumberField
                                    invert-wheel-change
                                    id="experience"
                                    v-model="form.experience"
                                    :default-value="0"
                                    :min="0"
                                    step="100"
                                >
                                    <Label for="experience">Получаемый опыт</Label>
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                            </div>

                            <div class="gap-2">
                                <NumberField
                                    invert-wheel-change
                                    id="xp_per_hp"
                                    v-model="form.xp_per_hp"
                                    :default-value="0.00"
                                    :min="0.00"
                                    :format-options="{
                                      minimumFractionDigits: 2,
                                    }"
                                    :step="0.01"
                                >
                                    <Label for="xp_per_hp">Опыт / Жизни</Label>
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                            </div>

                            <div class="grid gap-2">
                                <Label for="race">Раса</Label>
                                <Select v-model="form.race_id">
                                    <SelectTrigger id="race" class="w-full">
                                        <div class="flex items-center gap-2">
                                            <img
                                                v-if="selectedRace"
                                                :src="selectedRace.image.media[0].original_url"
                                                class="w-5 h-5 rounded"
                                                :alt="selectedRace.name"
                                            />
                                            <span class="select-none">{{ selectedRace ? selectedRace.name : 'Выберите расу монстра' }}</span>
                                        </div>
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem
                                                v-for="race in races"
                                                :key="race.id"
                                                :value="race.id"
                                            >
                                                <img class="h-[20px]" :src="race.image.media[0].original_url" :alt="race.name">
                                                {{ race.name }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <InputError :message="form.errors.race_id" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="element">Элемент</Label>
                                <Select v-model="form.element_id">
                                    <SelectTrigger id="element" class="w-full">
                                        <div class="flex items-center gap-2">
                                            <img
                                                v-if="selectedElement"
                                                :src="selectedElement.image.media[0].original_url"
                                                class="w-5 h-5 rounded"
                                                :alt="selectedElement.name"
                                            />
                                            <span class="select-none">{{ selectedElement ? selectedElement.name : 'Выберите элемент' }}</span>
                                        </div>
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem
                                                v-for="element in elements"
                                                :key="element.id"
                                                :value="element.id"
                                            >
                                                <img class="h-[20px]" :src="element.image.media[0].original_url" :alt="element.name">
                                                {{ element.name }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <InputError :message="form.errors.element_id" />
                            </div>

                            <div class="gap-2">
                                <NumberField
                                    invert-wheel-change
                                    id="element_strength"
                                    v-model="form.element_strength"
                                    :default-value="1"
                                    :min="1"
                                    :max="3"
                                >
                                    <Label for="element_strength">Сила элемента</Label>
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                            </div>

                            <div class="grid gap-2">
                                <Label for="combat_mode">Режим боя</Label>
                                <Select v-model="form.combat_mode">
                                    <SelectTrigger id="combat_mode" class="w-full">
                                        <SelectValue placeholder="Выберите режим боя" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem
                                                v-for="combat_mode in combat_modes"
                                                :key="combat_mode"
                                                :value="combat_mode"
                                            >
                                                {{ combat_mode }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <InputError :message="form.errors.combat_mode" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="defence">Защита</Label>
                                <Select v-model="form.defence">
                                    <SelectTrigger id="defence" class="w-full">
                                        <SelectValue placeholder="Выберите тип защиты" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem
                                                v-for="defence_type in defence_types"
                                                :key="defence_type"
                                                :value="defence_type"
                                            >
                                                {{ defence_type }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <InputError :message="form.errors.defence" />
                            </div>

                            <div class="gap-2">
                                <NumberField
                                    invert-wheel-change
                                    id="shield"
                                    v-model="form.shield"
                                    :default-value="0"
                                    :min="0"
                                    step="100"
                                >
                                    <Label for="shield">Щит (морозная эгида)</Label>
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                            </div>

                            <div class="grid gap-3">
                                <div class="flex items-center gap-2 text-sm leading-none font-medium select-none">
                                    Особенности
                                </div>

                                <div class="flex items-center space-x-2">
                                    <Switch v-model="form.is_aggressive" id="is_aggressive" />
                                    <Label for="is_aggressive">Агрессивный</Label>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <Switch v-model="form.is_elite" id="is_elite" />
                                    <Label for="is_elite">Элита</Label>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <Switch v-model="form.is_boss" id="is_boss" />
                                    <Label for="is_boss">Босс</Label>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <Switch v-model="form.quest_only" id="guest_only" />
                                    <Label for="guest_only">Квестовый</Label>
                                </div>

                                <div class="flex items-center space-x-2">
                                    <Switch v-model="form.pick_up_loot" id="pick_up_loot" />
                                    <Label for="pick_up_loot">Подбирает лут</Label>
                                </div>
                            </div>

                            <div class="grid gap-2">
                                <Label for="locations">Обитает в</Label>
                                <Combobox id="locations" v-model="form.locations" by="name" multiple class="w-full">
                                    <ComboboxAnchor as-child>
                                        <ComboboxTrigger as-child>
                                            <Button variant="outline" class="justify-between w-full">
                                                {{ form.locations.length > 0 ? form.locations.map((c) => c.name).join(', ') : 'Выберите локации обитания' }}
                                                <ChevronDownIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                            </Button>
                                        </ComboboxTrigger>
                                    </ComboboxAnchor>
                                    <ComboboxList class="w-full" align="start" avoid-collisions>
                                        <div class="relative w-full max-w-sm items-center">
                                            <ComboboxInput class="focus-visible:ring-0 border-0 rounded-none h-10" placeholder="Поиск локаций..." />
                                            <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
                                                <SearchIcon class="size-4 text-muted-foreground" />
                                            </span>
                                        </div>
                                        <ComboboxEmpty>
                                            Локаций не найдено
                                        </ComboboxEmpty>
                                        <ComboboxGroup>
                                            <ScrollArea class="h-[194px]">
                                                <ComboboxItem
                                                    v-for="location in locations"
                                                    :key="location.name"
                                                    :value="location"
                                                >
                                                    {{ location.name }}
                                                    <ComboboxItemIndicator>
                                                        <CheckIcon :class="cn('ml-auto h-4 w-4')" />
                                                    </ComboboxItemIndicator>
                                                </ComboboxItem>
                                            </ScrollArea>
                                        </ComboboxGroup>
                                    </ComboboxList>
                                </Combobox>
                                <InputError :message="form.errors.categories" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="categories">Категории</Label>
                                <Combobox id="categories" v-model="form.categories" by="name" multiple class="w-full">
                                    <ComboboxAnchor as-child>
                                        <ComboboxTrigger as-child>
                                            <Button variant="outline" class="justify-between w-full">
                                                {{ form.categories.length > 0 ? form.categories.map((c) => c.name).join(', ') : 'Выберите категории' }}
                                                <ChevronDownIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                            </Button>
                                        </ComboboxTrigger>
                                    </ComboboxAnchor>
                                    <ComboboxList class="w-full" align="start" avoid-collisions>
                                        <div class="relative w-full max-w-sm items-center">
                                            <ComboboxInput class="focus-visible:ring-0 border-0 rounded-none h-10" placeholder="Поиск категорий..." />
                                            <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
                                                <SearchIcon class="size-4 text-muted-foreground" />
                                            </span>
                                        </div>
                                        <ComboboxEmpty>
                                            Категорий не найдено
                                        </ComboboxEmpty>
                                        <ComboboxGroup>
                                            <ScrollArea class="h-[194px]">
                                                <ComboboxItem
                                                    v-for="category in categories"
                                                    :key="category.name"
                                                    :value="category"
                                                >
                                                    {{ category.name }}
                                                    <ComboboxItemIndicator>
                                                        <CheckIcon :class="cn('ml-auto h-4 w-4')" />
                                                    </ComboboxItemIndicator>
                                                </ComboboxItem>
                                            </ScrollArea>
                                        </ComboboxGroup>
                                    </ComboboxList>
                                </Combobox>
                                <InputError :message="form.errors.categories" />
                            </div>

                            <div class="flex items-center gap-4">
                                <Button :disabled="form.processing">Сохранить</Button>
                            </div>
                        </section>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
