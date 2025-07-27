<script setup lang="ts">

import { Head } from '@inertiajs/vue3';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Monster } from '@/types';
import { Table, TableBody, TableRow, TableCell } from '@/components/ui/table';
import { Badge } from '@/components/ui/badge';
import { Accordion, AccordionItem, AccordionContent, AccordionTrigger } from '@/components/ui/accordion';
import { Link } from '@inertiajs/vue3';

interface Props {
    monster: Monster;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        "title": `Монстр: ${props.monster.name}`,
        "href": route('monsters.show', props.monster.id)
    }
];
</script>

<template>
    <Head :title="`Монстр ${monster.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex flex-col">
            <div class="flex h-full flex-1 flex-row gap-4 rounded-xl p-4">
                <Card class="rounded-xl w-2/12">
                    <CardHeader class="text-left">
                        <CardTitle class="text-xl">{{ monster.name }}</CardTitle>
                    </CardHeader>
                    <CardContent class="px-6">
                        <div class="max-w-2xl rounded-xl shadow-lg">
                            <div class="flex flex-col gap-6">
                                <div class="flex-shrink-0 flex items-center justify-center">
                                    <img
                                        :src="monster.image.media[0].original_url"
                                        :alt="monster.name"
                                        class="w-50 object-cover rounded-lg border"
                                    />
                                </div>
                                <div class="flex-1">
                                    <div class="text-foreground mb-4 text-left">
                                        <span class="font-medium">Уровень:</span> <span class="text-foreground font-semibold text-2xl">{{ monster.level }}</span>
                                    </div>

                                    <h1 class="text-3xl font-bold mb-2 flex items-center gap-2">
                                        <Badge v-if="monster.is_boss" variant="destructive">Босс</Badge>
                                        <Badge v-if="monster.is_elite" variant="destructive">Элита</Badge>
                                        <Badge v-if="monster.is_quest" variant="outline">Квестовый</Badge>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <Card class="w-7/12">
                    <CardContent>
                        <Table>
                            <TableBody>
                                <TableRow>
                                    <TableCell>Жизни</TableCell>
                                    <TableCell>{{ monster.health_points }} <span v-if="monster.shield">(Морозная эгида: {{ monster.shield }})</span></TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>Раса</TableCell>
                                    <TableCell>
                                        <Badge variant="outline">
                                            <img class="w-[20px]" :src="monster.race.image.media[0].original_url" :alt="monster.race.name">
                                            {{ monster.race.name }}
                                        </Badge>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>Элемент</TableCell>
                                    <TableCell>
                                        <Badge variant="secondary" :title="monster.element.name">
                                            <div class="flex flex-row gap-0.5">
                                                <img v-for="n in monster.element_strength" :key="n" class="w-[20px]" :src="monster.element.image.media[0].original_url" :alt="monster.element.name">
                                            </div>
<!--                                            <span>{{ monster.element.name }}</span>-->
                                        </Badge>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>Защита</TableCell>
                                    <TableCell>{{ monster.defence }}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>Опыт</TableCell>
                                    <TableCell>{{ monster.experience }}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>Опыт за единицу жизни</TableCell>
                                    <TableCell>{{ monster.xp_per_hp }}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>Режим боя</TableCell>
                                    <TableCell>{{ monster.combat_mode }}</TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>Агрессивен</TableCell>
                                    <TableCell>
                                        <Badge :variant="monster.is_aggressive ? 'destructive' : 'outline'">
                                            {{ monster.is_aggressive ? 'Да' : 'Нет' }}
                                        </Badge>
                                    </TableCell>
                                </TableRow>
                                <TableRow>
                                    <TableCell>Подбирает лут</TableCell>
                                    <TableCell>
                                        <Badge :variant="monster.pick_up_loot ? 'secondary' : 'outline'">
                                            {{ monster.pick_up_loot ? 'Да' : 'Нет' }}
                                        </Badge>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                    </CardContent>
                </Card>

                <Card class="w-3/12 flex justify-center text-center">
                    <CardContent>
                        <img v-if="monster.image" :src="monster.image.media[0].original_url" :alt="monster.name">
                        <p v-else>Изображение отсутствует</p>
                    </CardContent>
                </Card>
            </div>

            <div class="flex flex-row gap-4 rounded-xl p-4 pt-0">
                <Card class="w-full">
                    <CardContent>
                        <Accordion type="single" collapsible default-value="locations">
                            <AccordionItem value="locations">
                                <AccordionTrigger class="hover:no-underline">Места обитания</AccordionTrigger>
                                <AccordionContent class="grid gap-2">
                                    <Link
                                        :href="route('locations.show', location.id)"
                                        v-for="location in monster.locations"
                                        :key="location.id"
                                        class="hover:underline"
                                    >
                                        <p>{{ location.name }}</p>
                                    </Link>

                                    <div v-if="monster.locations.length === 0">Все локации</div>
                                </AccordionContent>
                            </AccordionItem>
                        </Accordion>
                    </CardContent>
                </Card>
            </div>
        </div>

    </AppLayout>
</template>
