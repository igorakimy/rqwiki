<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { Bonus, BreadcrumbItem, Category, CharacterClass, Equipment, EquipmentType, Image } from '@/types';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
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
import BonusesDragAndDropMenu from '@/components/bonuses/BonusesDragAndDrop.vue';

interface Props {
    equipment: Equipment;
    images: Image[];
    categories: Category[];
    genders: string[];
    item_classes: string[];
    equipment_types: EquipmentType[];
    character_classes: CharacterClass[];
    bonuses: Bonus[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Редактирование экипировки',
        href: '/equipment/edit',
    },
];

const form = useForm({
    _method: 'put',
    name: props.equipment.name,
    item_class: props.equipment.item_class,
    required_level: props.equipment.required_level,
    max_slots_amount: props.equipment.max_slots_amount,
    defence: props.equipment.defence,
    gender: props.equipment.gender,
    selling_price: props.equipment.selling_price,
    equipment_type_id: props.equipment.equipment_type.id,
    image_id: props.equipment.image.id,
    categories: props.equipment.categories,
    character_classes: props.equipment.classes.map(c => c.id),
    bonuses: props.equipment.bonuses.map(bonus => {
        return {
            'id': bonus.id,
            'bonus_id': bonus.pivot.bonus_id,
            'value': bonus.pivot.value,
            'value_type': bonus.pivot.value_type,
            'use_alt_name': bonus.pivot.use_alt_name,
            'duration': bonus.pivot.duration,
            'special_property': bonus.pivot.special_property,
        }
    }),
})

const submit = () => {
    form.post(route('equipment.update', props.equipment.id), {
        onSuccess: () => {
            toast.success('Успешно изменено');
        },
    });
}

const selectedImage = computed(() => {
    return props.images.find(img => img.id === form.image_id)
});

</script>

<template>
    <Head title="Редактирование экипировки" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading title="Редактирование экипировки" />

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
                                    v-model="form.required_level"
                                    :default-value="1"
                                    :min="1"
                                    :max="70"
                                >
                                    <Label for="level">Требуемый уровень</Label>
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                                <InputError :message="form.errors.required_level" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="equipment-type">Тип экипировки</Label>
                                <Select id="equipment-type" v-model="form.equipment_type_id">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Выберите тип экипировки" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem
                                                v-for="equipment_type in equipment_types"
                                                :key="equipment_type.id"
                                                :value="equipment_type.id"
                                            >
                                                {{ equipment_type.name }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <InputError :message="form.errors.equipment_type_id" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="character-classes">Класс предмета</Label>
                                <Select id="character-classes" v-model="form.item_class">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Выберите класс предмета" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem
                                                v-for="item_class in item_classes"
                                                :key="item_class"
                                                :value="item_class"
                                            >
                                                {{ item_class }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <InputError :message="form.errors.item_class" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="character-classes">Классы персонажей</Label>
                                <Select id="character-classes" v-model="form.character_classes" multiple>
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Выберите классы" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem
                                                v-for="character_class in character_classes"
                                                :key="character_class.id"
                                                :value="character_class.id"
                                            >
                                                {{ character_class.name }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <InputError :message="form.errors.character_classes" />
                            </div>

                            <div class="gap-2">
                                <NumberField
                                    invert-wheel-change
                                    id="max-slots-amount"
                                    v-model="form.max_slots_amount"
                                    :default-value="1"
                                    :min="0"
                                    :max="3"
                                >
                                    <Label for="max-slots-amount">Максимальное кол-во слотов под карту</Label>
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                                <InputError :message="form.errors.max_slots_amount" />
                            </div>

                            <div class="gap-2">
                                <NumberField
                                    invert-wheel-change
                                    id="defence"
                                    v-model="form.defence"
                                    :default-value="0"
                                    :min="0"
                                >
                                    <Label for="defence">Защита</Label>
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                                <InputError :message="form.errors.defence" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="gender">Пол</Label>
                                <Select v-model="form.gender">
                                    <SelectTrigger id="combat_mode" class="w-full">
                                        <SelectValue placeholder="Выберите пол" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem
                                                v-for="gender in genders"
                                                :key="gender"
                                                :value="gender"
                                            >
                                                {{ gender }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <InputError :message="form.errors.gender" />
                            </div>

                            <div class="gap-2">
                                <NumberField
                                    invert-wheel-change
                                    id="selling-price"
                                    v-model="form.selling_price"
                                    :default-value="0"
                                    :min="0"
                                >
                                    <Label for="defence">Цена продажи</Label>
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                                <InputError :message="form.errors.selling_price" />
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

                            <div class="grid gap-2">
                                <Label>Бонусы</Label>
                                <BonusesDragAndDropMenu
                                    v-model="form.bonuses"
                                    :bonuses="bonuses"
                                    :errors="form.errors"
                                />
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
