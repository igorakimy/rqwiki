<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, DataTablePagination, DataTableRoutes, Monster } from '@/types';
import DataTable from '@/components/DataTable.vue';
import { columns } from '@/components/monsters/columns';
import Heading from '@/components/Heading.vue';


interface Props {
    monsters: Monster[];
    pagination: DataTablePagination;
    filters: Array;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Монстры',
        href: '/monsters',
    },
];

const routes: DataTableRoutes = {
    index: route('monsters.index'),
    create: route('monsters.create'),
}

defineProps<Props>();
</script>

<template>
    <Head title="Монстры" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading title="Монстры" />

            <div class="grid gap-2 text-muted-foreground text-sm">
                <p>В игре встречаются следующие типы монстров:</p>
                <p>
                    <span class="font-semibold">Нейтральные</span> - не атакуют персонажа, пока тот не атакует монстра.
                </p>
                <p>
                    <span class="font-semibold">Агрессивные</span> - атакует персонажа, как только увидит его.
                </p>
                <p>
                    <span class="font-semibold">Помощники</span> - атакует персонажа, если тот атакует такого же монстра.
                </p>
                <p>
                    <span class="font-semibold">Лутеры</span> - подбирает выпавшие предметы.
                </p>
            </div>

            <DataTable
                :data="monsters"
                :columns="columns"
                :column-visibility="{id: false}"
                :pagination="pagination"
                :filters="filters"
                :routes="routes"
            />
        </div>
    </AppLayout>
</template>
