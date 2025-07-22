<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/card';
import type { BreadcrumbItem, DataTablePagination, DataTableRoutes, Location } from '@/types';
import DataTable from '@/components/DataTable.vue';
import { columns } from '@/components/locations/columns';


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
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Card class="rounded-xl">
                <CardHeader class="px-10 pt-2 pb-0 text-left">
                    <CardTitle class="text-xl">Локации</CardTitle>
                    <CardDescription>
                        Список всех локаций в игре
                    </CardDescription>
                </CardHeader>
                <CardContent class="px-10">
                    <DataTable
                        :data="locations"
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
