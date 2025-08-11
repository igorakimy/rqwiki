<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, Image, DataTablePagination, DataTableRoutes } from '@/types';
import DataTable from '@/components/DataTable.vue';
import { columns } from '@/components/images/columns';
import Heading from '@/components/Heading.vue';


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
        <div class="px-4 py-6">
            <Heading title="Изображения" description="Галерея всех изображений, используемых на вики" />

            <DataTable
                :data="images"
                :columns="columns"
                :column-visibility="{id: false}"
                :pagination="pagination"
                :filters="filters"
                :routes="routes"
            />
        </div>
    </AppLayout>
</template>
