<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem, DataTablePagination, DataTableRoutes, Quest, QuestChain } from '@/types';
import DataTable from '@/components/DataTable.vue';
import { columns } from '@/components/quests/columns';
import Heading from '@/components/Heading.vue';
import { Link } from '@inertiajs/vue3';
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';

interface Props {
    quests: Quest[];
    quest_chains: QuestChain[][];
    pagination: DataTablePagination;
    filters: Array;
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Квесты',
        href: '/quests',
    },
];

const routes: DataTableRoutes = {
    index: route('quests.index'),
    create: route('quests.create'),
}

defineProps<Props>();
</script>

<template>
    <Head title="Квесты" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading
                title="Квесты"
            />

            <div class="grid gap-2 text-sm">
                <Accordion type="single" collapsible default-value="quest_chains">
                    <AccordionItem value="quest_chains">
                        <AccordionTrigger class="hover:no-underline text-1xl text-muted-foreground cursor-pointer">Цепочки квестов</AccordionTrigger>
                        <AccordionContent class="grid gap-2 grid-cols-3">
                                <div class="" v-for="quest_chain_chunk in quest_chains" :key="quest_chain_chunk">
                                    <div v-for="quest_chain in quest_chain_chunk" :key="quest_chain.id">
                                        <Link
                                            :href="route('quests.show', quest_chain.id)"
                                            class="hover:underline"
                                        >
                                            <p>{{ quest_chain.name }}</p>
                                        </Link>
                                    </div>
                                </div>
                        </AccordionContent>
                    </AccordionItem>
                </Accordion>
            </div>

            <DataTable
                :data="quests"
                :columns="columns"
                :column-visibility="{id: false}"
                :pagination="pagination"
                :filters="filters"
                :routes="routes"
            />
        </div>
    </AppLayout>
</template>
