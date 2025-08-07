<script setup lang="ts">
import { type BreadcrumbItem, NPC, Quest, QuestChain, QuestType } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import Heading from '@/components/Heading.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import { ChevronDownIcon, SearchIcon, CheckIcon } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { ScrollArea } from '@/components/ui/scroll-area';
import {
    Combobox,
    ComboboxAnchor,
    ComboboxEmpty,
    ComboboxGroup,
    ComboboxInput,
    ComboboxItem,
    ComboboxList,
    ComboboxTrigger,
    ComboboxItemIndicator,
} from '@/components/ui/combobox';
import { cn } from '@/lib/utils';
import { toast } from 'vue-sonner';
import {
    NumberField,
    NumberFieldContent,
    NumberFieldDecrement,
    NumberFieldIncrement,
    NumberFieldInput
} from '@/components/ui/number-field';
import { Textarea } from '@/components/ui/textarea';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

interface Props {
    quest: Quest;
    npcs: NPC[];
    quest_chains: QuestChain[];
    quest_types: QuestType[];
    prev_quests: Quest[];
}

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Изменение квеста',
        href: '/quests/edit',
    },
];

const props = defineProps<Props>();

const form = useForm({
    name: props.quest.name,
    required_level: props.quest.required_level,
    gold: props.quest.gold,
    experience: props.quest.experience,
    condition: props.quest.condition,
    condition_description: props.quest.condition_description,
    explanation: props.quest.explanation,
    quest_type_id: props.quest.quest_type.id,
    quest_chain_id: props.quest.quest_chain?.id,
    npc_from: props.quest.npc_from,
    npc_to: props.quest.npc_to,
    prev_quests: props.quest.prev_quests,
});

const submit = () => {
    form.put(route('quests.update', props.quest.id), {
        onSuccess: () => {
            toast.success('Успешно изменен');
        }
    });
}

</script>

<template>
    <Head title="Редактирование квеста" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="px-4 py-6">
            <Heading title="Редактирование квеста" />

            <form @submit.prevent="submit">
                <div class="flex flex-col space-y-8 md:space-y-0 lg:flex-row lg:space-y-0 lg:space-x-12">
                    <div class="flex-1 md:max-w-2xl">
                        <section class="max-w-xl space-y-6">
                            <div class="grid gap-2">
                                <Label for="name">Название</Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    autocomplete="off"
                                    type="text"
                                    class="mt-1 block w-full"
                                    placeholder="Название квеста"
                                />
                                <InputError :message="form.errors.name" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="quest-type">Тип квеста</Label>

                                <Select id="quest-type" v-model="form.quest_type_id">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Выберите тип квеста" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem
                                                v-for="quest_type in quest_types"
                                                :key="quest_type.id"
                                                :value="quest_type.id"
                                            >
                                                {{ quest_type.name }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>

                                <InputError :message="form.errors.quest_type_id" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="quest-chain">Квестовая цепочка</Label>

                                <Select id="quest-chain" v-model="form.quest_chain_id">
                                    <SelectTrigger class="w-full">
                                        <SelectValue placeholder="Выберите квестовую цепочку" />
                                    </SelectTrigger>
                                    <SelectContent>
                                        <SelectGroup>
                                            <SelectItem
                                                v-for="quest_chain in quest_chains"
                                                :key="quest_chain.id"
                                                :value="quest_chain.id"
                                            >
                                                {{ quest_chain.name }}
                                            </SelectItem>
                                        </SelectGroup>
                                    </SelectContent>
                                </Select>

                                <InputError :message="form.errors.quest_type_id" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="prev-quests">Предыдущие квесты</Label>
                                <Combobox id="prev-quests" v-model="form.prev_quests" by="name" multiple class="w-full">
                                    <ComboboxAnchor as-child>
                                        <ComboboxTrigger as-child>
                                            <Button variant="outline" class="justify-between w-full">
                                                <span class="font-normal text-muted-foreground">
                                                     {{ form.prev_quests.length > 0 ? form.prev_quests.map((c) => c.name).join(', ') : 'Выберите предыдущие квесты цепочки' }}
                                                </span>
                                                <ChevronDownIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                            </Button>
                                        </ComboboxTrigger>
                                    </ComboboxAnchor>
                                    <ComboboxList class="w-full" align="start" avoid-collisions>
                                        <div class="relative w-full max-w-sm items-center">
                                            <ComboboxInput class="focus-visible:ring-0 border-0 rounded-none h-10" placeholder="Поиск квестов..." />
                                            <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
                                                <SearchIcon class="size-4 text-muted-foreground" />
                                            </span>
                                        </div>
                                        <ComboboxEmpty>
                                            Квестов не найдено
                                        </ComboboxEmpty>
                                        <ComboboxGroup>
                                            <ScrollArea class="h-[194px]">
                                                <ComboboxItem
                                                    v-for="prev_quest in prev_quests"
                                                    :key="prev_quest.name"
                                                    :value="prev_quest"
                                                >
                                                    {{ prev_quest.name }}
                                                    <ComboboxItemIndicator>
                                                        <CheckIcon :class="cn('ml-auto h-4 w-4')" />
                                                    </ComboboxItemIndicator>
                                                </ComboboxItem>
                                            </ScrollArea>
                                        </ComboboxGroup>
                                    </ComboboxList>
                                </Combobox>
                                <InputError :message="form.errors.prev_quests" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="npc-from">НПС, который выдает квест</Label>
                                <Combobox id="npc-from" v-model="form.npc_from" :default-value="null" by="name" class="w-full">
                                    <ComboboxAnchor as-child>
                                        <ComboboxTrigger as-child>
                                            <Button variant="outline" class="justify-between w-full">
                                                <span class="text-muted-foreground font-normal">{{ form.npc_from ? form.npc_from?.name : 'Выберите нпс' }}</span>
                                                <ChevronDownIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                            </Button>
                                        </ComboboxTrigger>
                                    </ComboboxAnchor>
                                    <ComboboxList class="w-full" align="start" avoid-collisions>
                                        <div class="relative w-full max-w-sm items-center">
                                            <ComboboxInput class="focus-visible:ring-0 border-0 rounded-none h-10" placeholder="Поиск нпс..." />
                                            <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
                                                <SearchIcon class="size-4 text-muted-foreground" />
                                            </span>
                                        </div>
                                        <ComboboxEmpty>
                                            НПС не найдено
                                        </ComboboxEmpty>
                                        <ComboboxGroup>
                                            <ScrollArea class="h-[194px]">
                                                <ComboboxItem class="text-muted-foreground" :value="null">
                                                    Нет
                                                    <ComboboxItemIndicator>
                                                        <CheckIcon :class="cn('ml-auto h-4 w-4')" />
                                                    </ComboboxItemIndicator>
                                                </ComboboxItem>

                                                <ComboboxItem
                                                    v-for="npc in npcs"
                                                    :key="npc.name"
                                                    :value="npc"
                                                >
                                                    {{ npc.name }}
                                                    <ComboboxItemIndicator>
                                                        <CheckIcon :class="cn('ml-auto h-4 w-4')" />
                                                    </ComboboxItemIndicator>
                                                </ComboboxItem>
                                            </ScrollArea>
                                        </ComboboxGroup>
                                    </ComboboxList>
                                </Combobox>
                                <InputError :message="form.errors.npc_from" />
                            </div>

                            <div class="grid gap-2">
                                <Label for="npc-from">НПС, который принимает квест</Label>
                                <Combobox id="npc-from" v-model="form.npc_to" :default-value="null" by="name" class="w-full">
                                    <ComboboxAnchor as-child>
                                        <ComboboxTrigger as-child>
                                            <Button variant="outline" class="justify-between w-full">
                                                <span class="text-muted-foreground font-normal">
                                                    {{ form.npc_to ? form.npc_to?.name : 'Выберите нпс' }}
                                                </span>
                                                <ChevronDownIcon class="ml-2 h-4 w-4 shrink-0 opacity-50" />
                                            </Button>
                                        </ComboboxTrigger>
                                    </ComboboxAnchor>
                                    <ComboboxList class="w-full" align="start" avoid-collisions>
                                        <div class="relative w-full max-w-sm items-center">
                                            <ComboboxInput class="focus-visible:ring-0 border-0 rounded-none h-10" placeholder="Поиск нпс..." />
                                            <span class="absolute start-0 inset-y-0 flex items-center justify-center px-3">
                                                <SearchIcon class="size-4 text-muted-foreground" />
                                            </span>
                                        </div>
                                        <ComboboxEmpty>
                                            НПС не найдено
                                        </ComboboxEmpty>
                                        <ComboboxGroup>
                                            <ScrollArea class="h-[194px]">
                                                <ComboboxItem class="text-muted-foreground" :value="null">
                                                    Нет
                                                    <ComboboxItemIndicator>
                                                        <CheckIcon :class="cn('ml-auto h-4 w-4')" />
                                                    </ComboboxItemIndicator>
                                                </ComboboxItem>

                                                <ComboboxItem
                                                    v-for="npc in npcs"
                                                    :key="npc.name"
                                                    :value="npc"
                                                >
                                                    {{ npc.name }}
                                                    <ComboboxItemIndicator>
                                                        <CheckIcon :class="cn('ml-auto h-4 w-4')" />
                                                    </ComboboxItemIndicator>
                                                </ComboboxItem>
                                            </ScrollArea>
                                        </ComboboxGroup>
                                    </ComboboxList>
                                </Combobox>
                                <InputError :message="form.errors.npc_to" />
                            </div>

                            <div class="gap-2">
                                <NumberField
                                    invert-wheel-change
                                    id="required-level"
                                    v-model="form.required_level"
                                    :default-value="1"
                                    :min="1"
                                    :max="70"
                                >
                                    <Label for="required-level">Требуемый уровень</Label>
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                                <InputError :message="form.errors.required_level" />
                            </div>

                            <div class="gap-2">
                                <NumberField
                                    invert-wheel-change
                                    id="gold"
                                    v-model="form.gold"
                                    :default-value="1"
                                    :min="0"
                                >
                                    <Label for="gold">Золото</Label>
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                                <InputError :message="form.errors.gold" />
                            </div>

                            <div class="gap-2">
                                <NumberField
                                    invert-wheel-change
                                    id="experience"
                                    v-model="form.experience"
                                    :default-value="1"
                                    :min="0"
                                >
                                    <Label for="experience">Опыт</Label>
                                    <NumberFieldContent>
                                        <NumberFieldDecrement />
                                        <NumberFieldInput />
                                        <NumberFieldIncrement />
                                    </NumberFieldContent>
                                </NumberField>
                                <InputError :message="form.errors.experience" />
                            </div>

                            <div class="grid w-full gap-2">
                                <Label for="condition">Условие</Label>
                                <Textarea
                                    id="condition"
                                    v-model="form.condition"
                                    placeholder="Условие выполнения квеста"
                                />
                                <InputError :message="form.errors.condition" />
                            </div>

                            <div class="grid w-full gap-2">
                                <Label for="condition-description">Описание условия</Label>
                                <Textarea
                                    id="condition-description"
                                    v-model="form.condition_description"
                                    placeholder="Описание условия выполнения квеста"
                                />
                                <InputError :message="form.errors.condition_description" />
                            </div>

                            <div class="grid w-full gap-2">
                                <Label for="explanation">Пояснение к условию</Label>
                                <Textarea
                                    id="explanation"
                                    v-model="form.explanation"
                                    placeholder="Пояснение к условию"
                                />
                                <InputError :message="form.errors.explanation" />
                            </div>

                            <div class="flex items-center gap-4">
                                <Button :disabled="form.processing">Сохранить</Button>
                            </div>
                        </section>
                    </div>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
