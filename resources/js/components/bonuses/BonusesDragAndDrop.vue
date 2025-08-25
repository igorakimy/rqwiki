<script lang="ts" setup>
import { computed } from 'vue';
import BonusesDraggable from '@/components/bonuses/BonusesDraggable.vue';
import { DnDOperations, useDroppable } from '@vue-dnd-kit/core';
import { Button } from '@/components/ui/button';
import { X, SlidersHorizontal } from 'lucide-vue-next';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import {
    NumberField,
    NumberFieldContent,
    NumberFieldDecrement,
    NumberFieldIncrement,
    NumberFieldInput
} from '@/components/ui/number-field';
import { Label } from '@/components/ui/label';
import { Switch } from '@/components/ui/switch';
import { Textarea } from '@/components/ui/textarea';
import { Bonus } from '@/types';
import InputError from '@/components/InputError.vue';

interface Props {
    bonuses: Bonus[];
    errors?: object;
}

const items = defineModel();

defineProps<Props>();

const { elementRef } = useDroppable({
    data: computed(() => ({
        source: items,
    })),
    events: {
        onDrop: (store) => {
            DnDOperations.applyTransfer(store);
        },
    },
});

const addItem = () => {
    items.value.push({
        id: Date.now(),
        bonus_id: 0,
        value: 1,
        value_type: 'фактическое',
        use_alt_name: false,
        duration: 0,
        special_property: '',
    });
};

const removeItem = (index: number) => {
    items.value.splice(index, 1);
};

</script>

<template>
    <div class="flex flex-row items-center gap-2">
        <Button class="flex justify-start w-fit" variant="outline" @click.prevent="addItem">Добавить бонус</Button>
        <InputError :message="errors.bonuses" />
    </div>

    <div class="list flex flex-col items-center gap-1.5 relative" ref="elementRef">
        <TransitionGroup name="list">
            <BonusesDraggable
                v-for="(item, index) in items"
                :key="item.id"
                :source="items"
                :index="index"
            >
                <div class="item flex w-full justify-between gap-1">
                    <Select v-model="item.bonus_id">
                        <SelectTrigger class="w-full" title="Бонус" :aria-invalid="!!errors[`bonuses.${index}.bonus_id`]">
                            <SelectValue placeholder="Выберите бонус" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem
                                    v-for="bonus in bonuses"
                                    :key="bonus.id"
                                    :value="bonus.id"
                                >
                                    {{ bonus.name }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>

                    <NumberField
                        title="Значение"
                        invert-wheel-change
                        class="gap-2 min-w-30"
                        id="level"
                        v-model="item.value"
                        :default-value="1"
                        :min="1"
                        :aria-invalid="!!errors[`bonuses.${index}.value`]"
                    >
                        <NumberFieldContent>
                            <NumberFieldDecrement />
                            <NumberFieldInput />
                            <NumberFieldIncrement />
                        </NumberFieldContent>
                    </NumberField>

                    <Select v-model="item.value_type">
                        <SelectTrigger :aria-invalid="!!errors[`bonuses.${index}.value_type`]" class="w-28" title="Тип значения">
                            <SelectValue placeholder="Тип" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem value="фактическое">Целое</SelectItem>
                                <SelectItem value="процент">%</SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>

                    <Popover>
                        <PopoverTrigger as-child>
                            <Button variant="outline" size="icon" @click.prevent>
                                <SlidersHorizontal class="w-4 h-4" />
                            </Button>
                        </PopoverTrigger>
                        <PopoverContent class="w-80">
                            <div class="grid gap-4">
                                <div class="space-y-2">
                                    <h4 class="font-medium leading-none">
                                        Особенности
                                    </h4>
                                    <p class="text-sm text-muted-foreground">
                                        Дополнительные особенности бонуса
                                    </p>
                                </div>
                                <div class="grid gap-2">
                                    <div class="flex items-center space-x-2">
                                        <Switch id="use_alt_name" v-model="item.use_alt_name" />
                                        <Label for="use_alt_name">Использовать альтернативное название</Label>
                                    </div>

                                    <div class="flex gap-4">
                                        <Label for="duration">Время действия (сек.)</Label>
                                        <NumberField
                                            invert-wheel-change
                                            v-model="item.duration"
                                            id="duration"
                                            :default-value="0"
                                            :min="0"
                                        >
                                            <NumberFieldContent>
                                                <NumberFieldDecrement />
                                                <NumberFieldInput/>
                                                <NumberFieldIncrement />
                                            </NumberFieldContent>
                                        </NumberField>
                                    </div>
                                    <div class="grid w-full gap-2">
                                        <Label for="special-property">Особое свойство</Label>
                                        <Textarea
                                            id="special-property"
                                            v-model="item.special_property"
                                            placeholder="Описание свойства"
                                        />
                                    </div>
                                </div>
                            </div>
                        </PopoverContent>
                    </Popover>

                    <Button variant="ghost" size="icon" @click.prevent="removeItem(index)">
                        <X class="w-4 h-4" />
                    </Button>
                </div>
            </BonusesDraggable>
        </TransitionGroup>
    </div>
</template>

<style scoped>
</style>
