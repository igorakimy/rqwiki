<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, Category, Image, LocationType } from '@/types';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
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
import { ScrollArea } from '@/components/ui/scroll-area';

interface Props {
    images: Image[];
    location_types: LocationType[];
    categories: Category[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Добавление локации',
        href: '/locations/create',
    },
];

const form = useForm({
    name: '',
    image_id: 0,
    description: '',
    location_types: [],
    categories: [],
})

const submit = () => {
    form.post(route('locations.store'), {
        onSuccess: () => {
            toast.success('Успешно добавлено');
        }
    });
}

const selectedImage = computed(() => {
    return props.images.find(img => img.id === form.image_id)
});

</script>

<template>
    <Head title="Добавление локации" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading title="Добавление локации" />

            <form @submit.prevent="submit">
                <div class="flex flex-col space-y-8 md:space-y-0 lg:flex-row lg:space-y-0 lg:space-x-12">
                    <div class="flex-1 md:max-w-2xl">
                        <section class="max-w-xl space-y-6">
                            <div class="grid gap-2">
                                <Label for="name">Наименование</Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    autocomplete="off"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="Наименование"
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
                                <Label for="location_types">Тип локации</Label>

                                <Select id="location_types" v-model="form.location_types" multiple>
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Выберите типы локации" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem
                                                v-for="location_type in location_types"
                                                :key="location_type.id"
                                                :value="location_type.id"
                                            >
                                                {{ location_type.name }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>

                                <InputError :message="form.errors.location_types" />
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

                                    <ComboboxList class="w-full" align="start" avoid-collisions >
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

                            <div class="grid w-full gap-2">
                                <Label for="description">Описание</Label>
                                <Textarea
                                    id="description"
                                    v-model="form.description"
                                    placeholder="Описание локации"
                                />
                                <InputError :message="form.errors.description" />
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
