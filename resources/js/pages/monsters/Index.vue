<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/card';
import type { BreadcrumbItem, DataTablePagination, DataTableRoutes, Monster } from '@/types';
import DataTable from '@/components/DataTable.vue';
import { columns } from '@/components/monsters/columns';


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
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Card class="rounded-xl">
                <CardHeader class="px-10 pt-2 pb-0 text-left">
                    <CardTitle class="text-xl">Монстры</CardTitle>
                    <CardDescription>
                        <p class="mb-3">В игре встречаются следующие типы монстров:</p>
                        <div class="grid gap-2">
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
                                <span class="font-semibold">Лутеры</span> - подбирает выпавшие предметы
                            </p>
                        </div>

                    </CardDescription>
                </CardHeader>
                <CardContent class="px-10">
                    <DataTable
                        :data="monsters"
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
