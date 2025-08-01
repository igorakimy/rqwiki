<script setup lang="ts">
import { type BreadcrumbItem, Category, Image, Location, NPC, NpcGroup } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import ImagePicker from '@/components/ImagePicker.vue';
import { ChevronDownIcon, SearchIcon, CheckIcon } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { ScrollArea } from '@/components/ui/scroll-area';
import {
    Combobox,
    ComboboxAnchor,
    ComboboxEmpty,
    ComboboxGroup,
    ComboboxInput,
    ComboboxItem,
    ComboboxList,
    ComboboxTrigger,
    ComboboxItemIndicator,
} from '@/components/ui/combobox';
import { cn } from '@/lib/utils';
import { toast } from 'vue-sonner';
import { computed } from 'vue';

interface Props {
    npc: NPC;
    npc_groups: NpcGroup[];
    images: Image[];
    locations: Location[];
    categories: Category[];
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Редактирование НПС',
        href: '/npcs/edit',
    },
];

const props = defineProps<Props>();

const form = useForm({
    _method: 'put',
    name: props.npc.name,
    image_id: props.npc.image.id,
    npc_groups: props.npc.npc_groups,
    locations: props.npc.locations,
    categories: props.npc.categories,
});

const submit = () => {
    form.post(route('npcs.update', props.npc.id), {
        onSuccess: () => {
            toast.success('Успешно изменено');
        }
    });
}

const selectedImage = computed(() => {
    return props.images.find(img => img.id === form.image_id)
});

</script>

<template>
    <Head title="Редактирование НПС" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading title="Редактирование НПС" />

            <form @submit.prevent="submit">
                <div class="flex flex-col space-y-8 md:space-y-0 lg:flex-row lg:space-y-0 lg:space-x-12">
                    <div class="flex-1 md:max-w-2xl">
                        <section class="max-w-xl space-y-6">
                            <div class="grid gap-2">
                                <Label for="name">Имя</Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    autocomplete="off"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="Имя нпс"
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

                            <div class="grid gap-2">
                                <Label for="locations">Группы НПС</Label>
                                <Combobox id="locations" v-model="form.npc_groups" by="name" multiple class="w-full">
                                    <ComboboxAnchor as-child>
                                        <ComboboxTrigger as-child>
                                            <Button variant="outline" class="justify-between w-full">
                                                {{ form.npc_groups.length > 0 ? form.npc_groups.map((c) => c.name).join(', ') : 'Выберите группы нпс' }}
                                                <ChevronDownIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                            </Button>
                                        </ComboboxTrigger>
                                    </ComboboxAnchor>
                                    <ComboboxList class="w-full" align="start" avoid-collisions>
                                        <div class="relative w-full max-w-sm items-center">
                                            <ComboboxInput class="focus-visible:ring-0 border-0 rounded-none h-10" placeholder="Поиск групп нпс..." />
                                            <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
                                                <SearchIcon class="size-4 text-muted-foreground" />
                                            </span>
                                        </div>
                                        <ComboboxEmpty>
                                            Групп не найдено
                                        </ComboboxEmpty>
                                        <ComboboxGroup>
                                            <ScrollArea class="h-[194px]">
                                                <ComboboxItem
                                                    v-for="npc_group in npc_groups"
                                                    :key="npc_group.name"
                                                    :value="npc_group"
                                                >
                                                    {{ npc_group.name }}
                                                    <ComboboxItemIndicator>
                                                        <CheckIcon :class="cn('ml-auto h-4 w-4')" />
                                                    </ComboboxItemIndicator>
                                                </ComboboxItem>
                                            </ScrollArea>
                                        </ComboboxGroup>
                                    </ComboboxList>
                                </Combobox>
                                <InputError :message="form.errors.npc_groups" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="locations">Местонахождение</Label>
                                <Combobox id="locations" v-model="form.locations" by="name" multiple class="w-full">
                                    <ComboboxAnchor as-child>
                                        <ComboboxTrigger as-child>
                                            <Button variant="outline" class="justify-between w-full">
                                                {{ form.locations.length > 0 ? form.locations.map((c) => c.name).join(', ') : 'Выберите местонахождение' }}
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
                                <InputError :message="form.errors.locations" />
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
