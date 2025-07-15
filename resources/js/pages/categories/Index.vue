<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, Category, DataTablePagination } from '@/types';
import DataTable from '@/components/DataTable.vue';
import { columns } from '@/components/categories/columns';
import type { DataTableRoutes } from '@/types';
import Heading from '@/components/Heading.vue';

interface Props {
    categories: Category[];
    pagination: DataTablePagination;
    filters: Array;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Категории',
        href: '/categories',
    },
];

const routes: DataTableRoutes = {
    index: route('categories.index'),
}

defineProps<Props>();

</script>

<template>
    <Head title="Категории" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading title="Категории" description="Список всех существующих категорий на вики" />

            <DataTable
                :data="categories"
                :columns="columns"
                :routes="routes"
                :pagination="pagination"
                :filters="filters"
            />
        </div>
    </AppLayout>
</template>
