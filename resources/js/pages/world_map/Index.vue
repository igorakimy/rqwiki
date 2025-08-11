<script setup lang="ts">

import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import { BreadcrumbItem, WorldMap } from '@/types';
import Heading from '@/components/Heading.vue';

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
        <div class="px-4 py-6">
            <Heading title="Карта мира" />

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
        </div>
    </AppLayout>
</template>
