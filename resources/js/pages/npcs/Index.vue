<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, DataTablePagination, DataTableRoutes, NPC, NpcGroup } from '@/types';
import DataTable from '@/components/DataTable.vue';
import { columns } from '@/components/npcs/columns';
import Heading from '@/components/Heading.vue';

interface Props {
    npcs: NPC[];
    npc_groups: NpcGroup[];
    pagination: DataTablePagination;
    filters: Array;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'НПС',
        href: '/npcs',
    },
];

const routes: DataTableRoutes = {
    index: route('npcs.index'),
    create: route('npcs.create'),
}

defineProps<Props>();
</script>

<template>
    <Head title="НПС" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading
                title="НПС"
                description="НПС (от английского NPC - Non-player character) - это неигровые персонажи, выдающие и принимающие задания у игроков, торгующие с игроками, ведущие с игроками диалоги или взаимодействующие с игроками каким-либо другим образом."
            />

            <div class="grid gap-2 text-sm text-muted-foreground">
                <p>НПС условно могут быть разделены на следующие группы:</p>
                <ul>
                    <li v-for="group in npc_groups" :key="group.id">
                        - {{ group.plural_name }}
                    </li>
                </ul>
            </div>

            <DataTable
                :data="npcs"
                :columns="columns"
                :column-visibility="{id: false}"
                :pagination="pagination"
                :filters="filters"
                :routes="routes"
            />
        </div>
    </AppLayout>
</template>
