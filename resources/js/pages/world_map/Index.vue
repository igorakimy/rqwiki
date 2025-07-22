<script setup lang="ts">

import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import { Card, CardHeader, CardContent, CardTitle } from '@/components/ui/card';
import { BreadcrumbItem, WorldMap } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        "title": "Карта мира",
        "href": "/world-map"
    }
];

interface Props {
    world_map: WorldMap
}

defineProps<Props>();

const goToLocation = (id: number) => {
    router.get(route('locations.show', id));
}

</script>

<template>
    <Head title="Карта мира" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Card class="rounded-xl">
                <CardHeader class="px-10 pt-2 pb-0 text-left">
                    <CardTitle class="text-xl">Карта мира</CardTitle>
                </CardHeader>
                <CardContent class="px-10">
                    <ScrollArea class="whitespace-nowrap">
                        <div class="overflow-x-auto">
                            <img
                                class="min-w-[902px] h-[902px] rounded-md"
                                :src="world_map.image.media[0].original_url"
                                alt="Карта мира"
                                usemap="#world-map"
                            >
                            <map name="world-map">
                                <area
                                    class="cursor-pointer"
                                    v-for="location in world_map.locations"
                                    :key="location.id"
                                    shape="poly"
                                    :coords="location.pivot.coords"
                                    @click="goToLocation(location.id)"
                                    :title="location.name"
                                    :alt="location.name"
                                >
                            </map>
                        </div>

                        <ScrollBar orientation="horizontal" />
                    </ScrollArea>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
