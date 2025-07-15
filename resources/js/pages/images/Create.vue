<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, MediaCollection } from '@/types';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
import Heading from '@/components/Heading.vue';
import { Select, SelectValue, SelectTrigger, SelectItem, SelectContent, SelectGroup } from '@/components/ui/select';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Добавление изображения',
        href: '/images/create',
    },
];

interface Props {
    media_collections: MediaCollection[]
}

defineProps<Props>();

const form = useForm({
    name: '',
    file: '',
    media_collection: ''
})

const onFileUpload = (e) => {
    form.file = e.target.files[0];
}

const submit = () => {
    form.post(route('images.store'), {
        onSuccess: () => {
            toast.success('Успешно добавлено');
        }
    });
}

</script>

<template>
    <Head title="Добавление изображения" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading title="Добавление изображения" />

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
                                <Label for="file">Файл</Label>
                                <Input
                                    id="file"
                                    @change="onFileUpload($event)"
                                    type="file"
                                    class="mt-1 block w-full"
                                />
                                <InputError :message="form.errors.file" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="media_collection">Коллекция</Label>
                                <Select v-model="form.media_collection">
                                    <SelectTrigger class="w-full mt-1">
                                        <SelectValue  placeholder="Выберите коллекцию" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem v-for="collection in media_collections" :value="collection.name" :key="collection.name">
                                                {{ collection.translated_name }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>
                                <InputError :message="form.errors.media_collection" />
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
