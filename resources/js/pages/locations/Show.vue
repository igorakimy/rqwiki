<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Image, Location } from '@/types';

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
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <Card class="rounded-xl">
                <CardHeader class="px-10 pt-2 pb-0 text-left">
                    <CardTitle class="text-xl">{{ location.name }}</CardTitle>
                </CardHeader>
                <CardContent class="px-10">
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
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
