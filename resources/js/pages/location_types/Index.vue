<script setup lang="ts">

import { columns } from '@/components/location_types/columns';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import DataTable from '@/components/DataTable.vue';
import type { BreadcrumbItem, DataTablePagination, DataTableRoutes, LocationType } from '@/types';
import Heading from '@/components/Heading.vue';

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
        <div class="px-4 py-6">
            <Heading title="Типы локаций" />

            <DataTable
                :data="location_types"
                :columns="columns"
                :column-visibility="{id: false}"
                :pagination="pagination"
                :filters="filters"
                :routes="routes"
            />
        </div>
    </AppLayout>
</template>
