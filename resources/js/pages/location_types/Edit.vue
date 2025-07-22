<script setup lang="ts">

import { Head, Link, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, LocationType } from '@/types';
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
import Heading from '@/components/Heading.vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { toast } from 'vue-sonner';
import { Textarea } from '@/components/ui/textarea';

interface Props {
    location_type: LocationType;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Изменение типа локации',
        href: `/location-types/edit/${props.location_type.id}`,
    },
];

const form = useForm({
    name: props.location_type.name,
    plural_name: props.location_type.plural_name,
    description: props.location_type.description
});

const submit = () => {
    form.put(route('location-types.update', props.location_type.id), {
        onSuccess: () => {
            toast.success('Успешно изменено');
        }
    });
}

</script>

<template>
    <Head title="Изменение типа локации" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading title="Изменение типа локации" />

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
                                <Link :href="route('location-types.index')">
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
