<script setup lang="ts">

import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Quest } from '@/types';
import Heading from '@/components/Heading.vue';
import { Tooltip, TooltipProvider, TooltipTrigger, TooltipContent } from '@/components/ui/tooltip';
import { Button } from '@/components/ui/button';

interface Props {
    quest: Quest;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        "title": `Квест: ${props.quest.name}`,
        "href": route('quests.show', props.quest.id)
    }
];
</script>

<template>
    <Head :title="`${quest.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading :title="`Квест — ${quest.name}`" />

            <div class="grid gap-3">
                <div>
                    <div class="flex flex-row items-center gap-2" v-if="quest.npc_from">
                        <span class="text-muted-foreground">Выдаёт:</span>
                        <div class="flex flex-row gap-1 items-center">
                            <Link :href="route('npcs.show', quest.npc_from.id)">
                                <img class="w-[32px] h-[32px]" :src="quest.npc_from.image.media[0].original_url" :alt="quest.npc_from.name">
                            </Link>
                            <Link class="hover:underline" :href="route('npcs.show', quest.npc_from.id)">{{ quest.npc_from.name }}</Link>
                        </div>
                    </div>

                    <div class="flex flex-row items-center gap-2" v-if="quest.npc_to">
                        <span class="text-muted-foreground">Принимает:</span>
                        <div class="flex flex-row gap-1 items-center">
                            <Link :href="route('npcs.show', quest.npc_to.id)">
                                <img class="w-[32px] h-[32px]" :src="quest.npc_to.image.media[0].original_url" :alt="quest.npc_to.name">
                            </Link>
                            <Link class="hover:underline" :href="route('npcs.show', quest.npc_to.id)">{{ quest.npc_to.name }}</Link>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2">
                    <span class="font-bold">Необходимый уровень:</span>
                    <span>{{ quest.required_level }}</span>
                </div>

                <div class="flex gap-2">
                    <span class="font-bold">Тип квеста:</span>
                    <span>{{ quest.quest_type.name }}</span>
                </div>

                <div class="flex flex-col gap-1 w-1/2" v-if="quest.quest_chain">
                    <span>Цепочка заданий (<Link class="text-sidebar-ring hover:underline" :href="route('quests.show', quest.id)">{{ quest.quest_chain.name }}</Link>):</span>
                    <div>
                        <span v-if="quest.prev_quests.length > 0">
                            <span v-for="(prev_quest, index) in quest.prev_quests" :key="prev_quest.id">
                                <Link class="text-sidebar-ring hover:underline" :href="route('quests.show', prev_quest.id)">
                                    {{ prev_quest.name }}
                                </Link>
                                <span v-if="index != quest.prev_quests.length - 1">, </span>
                            </span>
                            <span class="px-2">→</span>
                        </span>

                        <span>{{ quest.name }}</span>

                        <span v-if="quest.next_quests.length > 0">
                            <span class="px-2">→</span>
                            <span v-for="(next_quest, index) in quest.next_quests" :key="next_quest.id">
                                <Link class="text-sidebar-ring hover:underline" :href="route('quests.show', next_quest.id)">
                                    {{ next_quest.name }}
                                </Link>
                                <span v-if="index != quest.next_quests.length - 1">, </span>
                            </span>
                        </span>
                    </div>

                </div>

                <div class="flex flex-col gap-2">
                    <div class="font-bold">Условия:</div>
                    <div class="w-1/2">
                        <p>{{ quest.condition }}</p>
                        <p class="text-muted-foreground">{{ quest.condition_description }}</p>
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <div class="font-bold">Вознаграждение:</div>
                    <div class="flex flex-row gap-2">
                        <span>Золото:</span>
                        <TooltipProvider>
                            <Tooltip :delay-duration="0">
                                <TooltipTrigger>
                                    <span class="hover:underline">{{ quest.gold }}</span>
                                </TooltipTrigger>
                                <TooltipContent>
                                    <p>На 65-ом уровне: {{ quest.gold + Math.round((quest.gold / 100) * 30) }}</p>
                                </TooltipContent>
                            </Tooltip>
                        </TooltipProvider>
                    </div>
                    <div class="flex flex-row gap-2">
                        <span>Опыт:</span>
                        <TooltipProvider>
                            <Tooltip :delay-duration="0">
                                <TooltipTrigger>
                                    <span class="hover:underline">{{ quest.experience }}</span>
                                </TooltipTrigger>
                                <TooltipContent>
                                    <p>На 65-ом уровне: {{ quest.experience + Math.round((quest.experience / 100) * 50) }}</p>
                                </TooltipContent>
                            </Tooltip>
                        </TooltipProvider>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <Link :href="route('quests.edit', quest.id)">
                        <Button>Изменить</Button>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
