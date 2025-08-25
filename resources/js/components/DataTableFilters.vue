<script setup lang="ts">

import { ListFilterPlus } from 'lucide-vue-next';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Button } from '@/components/ui/button';
import { Table } from '@tanstack/vue-table';
import { DataTableFilter } from '@/types';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

interface DataTableFiltersProps {
    table: Table,
    filters: Array<DataTableFilter>
}

const props = defineProps<DataTableFiltersProps>();

const resetFilters = () => {
    props.table.resetColumnFilters();
    props.table.resetSorting();
}
</script>

<template>
    <Popover class="text-xs">
        <PopoverTrigger as-child>
            <Button variant="outline" class="cursor-pointer" title="Фильтры">
                <ListFilterPlus />
                Фильтры
            </Button>
        </PopoverTrigger>
        <PopoverContent class="min-w-110" side="right">
            <div class="grid gap-4">
                <div class="grid gap-2">
                    <div v-for="filter in filters" :key="filter.column" class="grid grid-cols-2 items-center gap-2">
                        <Label class="whitespace-nowrap" :for="filter.column">{{ filter.label }}</Label>
                        <Select>
                            <SelectTrigger :id="filter.column" class="w-full">
                                <SelectValue />
                            </SelectTrigger>
                            <SelectContent>
                                <SelectGroup>
                                    <SelectItem
                                        v-for="option in filter.options"
                                        :key="option.id"
                                        :value="option.id"
                                        @select="(e) => {
                                            const val = e.detail.value;
                                            const column = table.getColumn(filter.column);
                                            column?.setFilterValue(val)
                                        }"
                                    >
                                        {{ option.name }}
                                    </SelectItem>
                                </SelectGroup>
                            </SelectContent>
                        </Select>
                    </div>
                </div>
                <div class="space-y-2 flex justify-end text-destructive">
                    <p class="flex w-fit cursor-pointer select-none" @click="resetFilters">Сбросить фильтры</p>
                </div>
            </div>
        </PopoverContent>
    </Popover>
</template>
