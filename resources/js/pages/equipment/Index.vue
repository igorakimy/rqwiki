<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, DataTablePagination, DataTableRoutes, Equipment } from '@/types';
import DataTable from '@/components/DataTable.vue';
import { columns } from '@/components/equipment/columns';
import Heading from '@/components/Heading.vue';


interface Props {
    equipment: Equipment[];
    pagination: DataTablePagination;
    filters: Array;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Экипировка',
        href: '/equipment',
    },
];

const routes: DataTableRoutes = {
    index: route('equipment.index'),
    create: route('equipment.create'),
}

defineProps<Props>();
</script>

<template>
    <Head title="Экипировка" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading title="Экипировка" />

            <DataTable
                :data="equipment"
                :columns="columns"
                :column-visibility="{id: false, equipment_type: false}"
                :pagination="pagination"
                :filters="filters"
                :routes="routes"
                :show-filters="true"
            />
        </div>
    </AppLayout>
</template>
