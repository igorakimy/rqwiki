<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Image, Location } from '@/types';
import Heading from '@/components/Heading.vue';

interface Props {
    location: Location;
    bg_image: Image
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        "title": `Локация: ${props.location.name}`,
        "href": route('locations.show', props.location.id)
    }
];
</script>

<template>
    <Head :title="`Локация ${location.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading :title="location.name" />

            <div>
                <div class="mb-4">
                    <span class="font-semibold">Тип: </span>
                    <template v-for="(location_type, index) in location.location_types" :key="index">
                        <template v-if="index > 0">,</template>
                        <span class="text-foreground">{{ location_type.name }}</span>
                    </template>
                </div>

                <ScrollArea class="whitespace-nowrap">
                    <div class="relative overflow-hidden w-[800px] h-[640px] rounded-md">
                        <img class="absolute left-0 top-0" :src="bg_image.media[0].original_url" alt="Фон локации">

                        <img
                            class="w-[800px] absolute left-0 top-[-85px]"
                            :src="location.image.media[0].original_url"
                            :alt="location.name"
                        >
                    </div>

                    <ScrollBar orientation="horizontal" />
                </ScrollArea>

                <p class="mt-4">{{ location.description }}</p>
            </div>
        </div>
    </AppLayout>
</template>
