<script setup lang="ts">

import { columns } from '@/components/location_types/columns';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import DataTable from '@/components/DataTable.vue';
import type { BreadcrumbItem, DataTablePagination, DataTableRoutes, LocationType } from '@/types';

interface Props {
    location_types: LocationType[];
    pagination: DataTablePagination;
    filters: Array;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Типы локаций',
        href: '/location-types',
    },
];

const routes: DataTableRoutes = {
    index: route('location-types.index'),
    create: route('location-types.create')
}

defineProps<Props>();

</script>

<template>
    <Head title="Типы локаций" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Card class="rounded-xl">
                <CardHeader class="px-10 pt-2 pb-0 text-left">
                    <CardTitle class="text-xl">Типы локаций</CardTitle>
                </CardHeader>
                <CardContent class="px-10">
                    <DataTable
                        :data="location_types"
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
