<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, Category, DataTablePagination } from '@/types';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import DataTable from '@/components/categories/DataTable.vue';
import { columns } from '@/components/categories/columns';
import type { DataTableRoutes } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Категории',
        href: '/categories',
    },
];

const routes: DataTableRoutes = {
    index: route('categories.index'),
}

defineProps<{
    categories: Category[];
    pagination: DataTablePagination;
    filters: Array;
}>()

</script>

<template>
    <Head title="Категории" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Card class="rounded-xl">
                <CardHeader class="px-10 pt-2 pb-0 text-left">
                    <CardTitle class="text-xl">Категории</CardTitle>
                    <CardDescription>
                        Список всех существующих категорий на вики
                    </CardDescription>
                </CardHeader>
                <CardContent class="px-10 py-8">
<!--                    <slot />-->
                    <DataTable
                        :data="categories"
                        :columns="columns"
                        :routes="routes"
                        :pagination="pagination"
                        :filters="filters"
                    />
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
