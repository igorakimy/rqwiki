<script setup lang="ts">

import { Head, Link } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, NPC } from '@/types';
import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';
import Heading from '@/components/Heading.vue';
import { columns } from '@/components/categories/columns';

interface Props {
    npc: NPC;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        "title": `НПС: ${props.npc.name}`,
        "href": route('npcs.show', props.npc.id)
    }
];
</script>

<template>
    <Head :title="`${npc.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading :title="npc.name" />

            <div class="rounded-md">
                <img
                    class="w-[92px] h-[92px]"
                    :src="npc.image.media[0].original_url"
                    :alt="npc.name"
                >
            </div>

            <Accordion type="single" default-value="locations">
                <AccordionItem value="locations">
                    <AccordionTrigger class="hover:no-underline text-1xl text-muted-foreground">Находится в:</AccordionTrigger>
                    <AccordionContent class="grid gap-2">
                        <Link
                            v-for="location in npc.locations"
                            :href="route('locations.show', location.id)"
                            :key="location.id"
                            class="hover:underline"
                        >
                            <p>{{ location.name }}</p>
                        </Link>

                        <div v-if="npc.locations.length === 0">Все локации</div>
                    </AccordionContent>
                </AccordionItem>
            </Accordion>
        </div>
    </AppLayout>
</template>
