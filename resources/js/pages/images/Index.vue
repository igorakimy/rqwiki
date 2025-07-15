<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/card';
import type { BreadcrumbItem, Image, DataTablePagination, DataTableRoutes } from '@/types';
import DataTable from '@/components/DataTable.vue';
import { columns } from '@/components/images/columns';


interface Props {
    images: Image[];
    pagination: DataTablePagination;
    filters: Array;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Изображения',
        href: '/images',
    },
];

const routes: DataTableRoutes = {
    index: route('images.index'),
    create: route('images.create')
}

defineProps<Props>();
</script>

<template>
    <Head title="Изображения" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Card class="rounded-xl">
                <CardHeader class="px-10 pt-2 pb-0 text-left">
                    <CardTitle class="text-xl">Изображения</CardTitle>
                    <CardDescription>
                        Галерея всех изображений, используемых на вики
                    </CardDescription>
                </CardHeader>
                <CardContent class="px-10">
                    <DataTable
                        :data="images"
                        :columns="columns"
                        :column-visibility="{id: false}"
                        :pagination="pagination"
                        :filters="filters"
                        :routes="routes"
                    />
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
