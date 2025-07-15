<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, Image, MediaCollection } from '@/types';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
import Heading from '@/components/Heading.vue';
import { Select, SelectValue, SelectTrigger, SelectItem, SelectContent, SelectGroup } from '@/components/ui/select';
import { toast } from 'vue-sonner';
import { Link } from '@inertiajs/vue3';

interface Props {
    image: Image
    media_collections: MediaCollection[]
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Изменение изображения',
        href: `/images/edit/${props.image.id}`,
    },
];

const form = useForm({
    _method: 'put',
    name: props.image.name,
    file: '',
    media_collection: props.media_collections.filter((c) => {
        return c.name === props.image.media[0].collection_name
    })[0].name
})

const onFileUpload = (e) => {
    form.file = e.target.files[0];
}

const submit = () => {
    form.post(route('images.update', props.image.id), {
        onSuccess: () => {
            toast.success('Успешно изменено');
        }
    });
}

</script>

<template>
    <Head title="Изменение изображения" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading title="Изменение изображения" />

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
                                <Label>Текущий файл</Label>

                                <img class="h-[150px]" :src="props.image.media[0].original_url" :alt="props.image.name">
                            </div>

                            <div class="grid gap-2">
                                <Label for="file">Новый файл</Label>
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
                                <Select id="media_collection" v-model="form.media_collection" :value="form.media_collection">
                                    <SelectTrigger class="w-full mt-1">
                                        <SelectValue placeholder="Выберите коллекцию" />
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
                                <Link :href="route('images.index')">
                                    <Button variant="outline">Отмена</Button>
                                </Link>
                                <Button :disabled="form.processing">Сохранить</Button>
                            </div>
                        </section>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
