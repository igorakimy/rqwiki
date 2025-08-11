<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, DataTablePagination, DataTableRoutes, Location } from '@/types';
import DataTable from '@/components/DataTable.vue';
import { columns } from '@/components/locations/columns';
import Heading from '@/components/Heading.vue';


interface Props {
    locations: Location[];
    pagination: DataTablePagination;
    filters: Array;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Локации',
        href: '/locations',
    },
];

const routes: DataTableRoutes = {
    index: route('locations.index'),
    create: route('locations.create')
}

defineProps<Props>();
</script>

<template>
    <Head title="Локации" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading title="Локации" description="Список всех локаций в игре" />

            <DataTable
                :data="locations"
                :columns="columns"
                :column-visibility="{id: false}"
                :pagination="pagination"
                :filters="filters"
                :routes="routes"
            />
        </div>
    </AppLayout>
</template>
