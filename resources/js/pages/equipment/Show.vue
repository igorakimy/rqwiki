<script setup lang="ts">

import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Equipment } from '@/types';
import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';

interface Props {
    equipment: Equipment;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        'title': `Экипировка: ${props.equipment.name}`,
        'href': route('equipment.show', props.equipment.id)
    }
];
</script>

<template>
    <Head :title="`Экипировка ${equipment.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="min-h-screen bg-background transition-colors duration-300 px-4 py-8 flex flex-col w-1/2">
            <div class="flex flex-row items-center gap-4 mb-4">
                <img
                    v-if="equipment.image"
                    :src="equipment.image.media[0].original_url"
                    :alt="equipment.name"
                    class="w-[64px] h-[64px] border border-muted rounded bg-muted"
                />
                <div>
                    <h1 class="text-2xl font-bold leading-tight mb-1 text-primary">
                        {{ equipment.name }}
                    </h1>
                    <div class="text-muted-foreground text-sm font-semibold mb-1">
                        {{ equipment.equipment_type.name }}
                    </div>
                </div>
            </div>

            <div>
                <div class="flex flex-col gap-2">

                    <div class="flex flex-row gap-2 items-center">
                        <div class="font-medium text-sm text-muted-foreground">Необходимый уровень:</div>
                        <div class="font-bold">{{ equipment.required_level }}</div>
                    </div>
                    <div class="flex flex-row gap-2 items-center">
                        <div class="font-medium text-sm text-muted-foreground">Класс предмета:</div>
                        <div>
                            <Badge variant="outline">{{ equipment.item_class }}</Badge>
                        </div>
                    </div>
                    <div class="flex flex-row gap-2 items-center">
                        <div class="font-medium text-sm text-muted-foreground">Пол:</div>
                        <div class="font-bold">{{ equipment.gender }}</div>
                    </div>
                    <div class="flex flex-row gap-2 items-center">
                        <div class="font-medium text-sm text-muted-foreground">Классы:</div>
                        <div class="flex flex-row gap-1">
                            <div v-if="equipment.classes.length > 0" class="flex flex-row gap-1">
                                <Badge v-for="cc in equipment.classes" :key="cc.id" variant="outline" class="mb-1 flex flex-row gap-1">
                                <span>
                                    <img class="w-[20px] h-[20px]" :src="cc.image.media[0].original_url" :alt="cc.name">
                                </span>
                                    <span>{{ cc.name }}</span>
                                </Badge>
                            </div>
                            <div v-else>Все классы</div>
                        </div>
                    </div>

                    <div class="flex flex-row gap-2 items-center">
                        <div class="font-medium text-sm text-muted-foreground">Защита:</div>
                        <div class="font-bold">{{ equipment.defence }}</div>
                    </div>

                    <div class="flex flex-row gap-2">
                        <div class="font-medium text-sm text-muted-foreground">Цена продажи:</div>
                        <div class="font-bold">{{ equipment.selling_price }}&nbsp;<span
                            class="inline-block align-middle"></span></div>
                    </div>
                </div>
                <div v-if="equipment.bonuses && equipment.bonuses.length" class="mt-2 p-2.5 w-fit rounded bg-neutral-700 text-white">
                    <ul class="list-none">
                        <li v-for="b in equipment.bonuses" :key="b" class="flex flex-row">
                            <div>+{{ b.pivot.value }} {{ b.name_formatted }}</div>
                        </li>
                    </ul>
                </div>
                <div class="my-4 text-base text-foreground/90">
                    <span v-if="equipment.description">{{ equipment.description }}</span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <Link :href="route('equipment.edit', equipment.id)">
                    <Button>Изменить</Button>
                </Link>
            </div>
        </div>
    </AppLayout>
</template>
