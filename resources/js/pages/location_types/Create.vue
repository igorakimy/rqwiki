<script setup lang="ts">

import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Textarea } from '@/components/ui/textarea';
import InputError from '@/components/InputError.vue';
import Heading from '@/components/Heading.vue';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Добавление типа локации',
        href: '/location-types/create',
    },
];

const form = useForm({
    name: '',
    plural_name: '',
    description: ''
})

const submit = () => {
    form.post(route('location-types.store'), {
        onSuccess: () => {
            toast.success('Успешно добавлено');
        }
    });
}

</script>

<template>
    <Head title="Добавление типа локации" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading title="Добавление типа локации" />

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
                                <Label for="plural_name">Наименование(в множественном числе)</Label>
                                <Input
                                    id="plural_name"
                                    v-model="form.plural_name"
                                    autocomplete="off"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="Наименование(в множественном числе)"
                                />
                                <InputError :message="form.errors.plural_name" />
                            </div>

                            <div class="grid w-full gap-2">
                                <Label for="description">Описание</Label>
                                <Textarea
                                    id="description"
                                    v-model="form.description"
                                    placeholder="Описание типа локации"
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
