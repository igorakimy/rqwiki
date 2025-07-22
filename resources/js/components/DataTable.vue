<script setup lang="ts" generic="TData, TValue">
import type { ColumnDef, ColumnFiltersState, PaginationState, SortingState } from '@tanstack/vue-table';
import {
    FlexRender,
    getCoreRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    getFilteredRowModel,
    useVueTable
} from '@tanstack/vue-table';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { ChevronLeftIcon, ChevronRightIcon, ChevronsLeftIcon, ChevronsRightIcon, FilterXIcon } from 'lucide-vue-next';
import type { DataTablePagination, DataTableRoutes } from '@/types';

const props = defineProps<{
    columns: ColumnDef<TData, TValue>[];
    data: TData[];
    routes: DataTableRoutes;
    pagination?: DataTablePagination;
    filters?: Array;
    columnVisibility?: object;
}>()

const pageSizes = [10, 50, 100];

const pagination = ref<PaginationState>({
    pageIndex: props.pagination.current_page - 1,
    pageSize: props.pagination.per_page,
})

const sorting = ref<SortingState>([]);

const columnFilters = ref<ColumnFiltersState>(props.filters ?? []);

const columnVisibility = ref(props.columnVisibility || {});

const currentPage = computed (() => props.pagination.current_page - 1);
const pageCount = computed(() => props.pagination.last_page);

const table = useVueTable({
    get data() { return props.data },
    get columns() { return props.columns },
    state: {
        get sorting() { return sorting.value },
        get pagination() { return pagination.value },
        set pagination(value) { pagination.value = value },
        get columnFilters() { return columnFilters.value },
        get columnVisibility() { return columnVisibility.value },
    },
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    manualPagination: true,
    manualSorting: true,
    manualFiltering: true,
    onPaginationChange: changePagination,
    onSortingChange: changeSorting,
    onColumnFiltersChange: changeFilters,
})

function changePagination(updater) {
    pagination.value = typeof updater === 'function'
        ? updater(pagination.value)
        : updater;

    let filters = {};

    if (columnFilters.value) {
        filters = columnFilters.value.reduce((acc, filter) => {
            acc[filter.id] = filter.value
            return acc
        }, {})
    }

    router.get(props.routes?.index || route(route().current()), {
        page: pagination.value.pageIndex + 1,
        per_page: pagination.value.pageSize,
        sort_field: sorting.value[0]?.id,
        sort_direction: sorting.value.length == 0 ? undefined : (sorting.value[0]?.desc ? "desc" : "asc"),
        ...filters
    }, {
        preserveState: true,
        preserveScroll: true,
    })
}

function changeSorting(updaterOrValue) {
    sorting.value = typeof updaterOrValue === 'function'
            ? updaterOrValue(sorting.value)
            : updaterOrValue;

    let filters = {};
    if (columnFilters.value) {
        filters = columnFilters.value.reduce((acc, filter) => {
            acc[filter.id] = filter.value
            return acc
        }, {})
    }

    router.get(
        props.routes?.index || route(route().current()),
        {
            page: pagination.value.pageIndex + 1,
            per_page: pagination.value.pageSize,
            sort_field: sorting.value[0]?.id,
            sort_direction: sorting.value.length == 0 ? undefined : (sorting.value[0]?.desc ? "desc" : "asc"),
            ...filters
        },
        {
            preserveState: true,
            preserveScroll: true
        }
    );
}

function changeFilters(updaterOrValue) {
    columnFilters.value = typeof updaterOrValue === 'function'
        ? updaterOrValue(columnFilters.value)
        : updaterOrValue;

    let filters = {};

    if (columnFilters.value) {
        filters = columnFilters.value.reduce((acc, filter) => {
            acc[filter.id] = filter.value
            return acc
        }, {})
    }

    pagination.value.pageIndex = 0;

    router.get(props.routes?.index || route(route().current()), {
        page: pagination.value.pageIndex + 1,
        per_page: pagination.value.pageSize,
        sort_field: sorting.value[0]?.id,
        sort_direction: sorting.value.length == 0 ? undefined : (sorting.value[0]?.desc ? "desc" : "asc"),
        ...filters
    }, {
        preserveState: true,
        preserveScroll: true,
    })
}

function getPages(current, total, delta = 2) {
    const pages = []
    const left = Math.max(1, current + 1 - delta)
    const right = Math.min(total, current + 1 + delta)

    if (left > 1) pages.push(1)
    if (left > 2) pages.push('...')

    for (let i = left; i <= right; i++) {
        pages.push(i)
    }

    if (right < total - 1) pages.push('...')
    if (right < total) pages.push(total)

    return pages
}

const resetFilters = () => {
    columnFilters.value = [];
    sorting.value = [];
    table.resetColumnFilters();
    table.resetSorting();
}

const pagesToShow = computed(() => getPages(currentPage.value, pageCount.value));

</script>

<template>
    <div class="flex justify-between py-4">
        <div class="flex flex-row gap-2">
            <Input class="min-w-md" placeholder="Поиск..."
                   :model-value="table.getColumn('name')?.getFilterValue() as string"
                   @update:model-value="table.getColumn('name')?.setFilterValue($event)" />
            <Button variant="outline" class="cursor-pointer" title="Сбросить фильтры" @click="resetFilters">
                <FilterXIcon />
            </Button>
        </div>

        <Link v-if="routes.create" :href="props.routes.create || route(route().current())" >
            <Button variant="default">Добавить</Button>
        </Link>
    </div>
    <div class="border rounded-md">
        <Table>
            <TableHeader>
                <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
                    <TableHead v-for="header in headerGroup.headers" :key="header.id">
                        <FlexRender
                            v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                            :props="header.getContext()"
                        />
                    </TableHead>
                </TableRow>
            </TableHeader>
            <TableBody>
                <template v-if="table.getRowModel().rows?.length">
                    <TableRow
                        v-for="row in table.getRowModel().rows" :key="row.id"
                        :data-state="row.getIsSelected() ? 'selected' : undefined"
                    >
                        <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                            <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                        </TableCell>
                    </TableRow>
                </template>
                <template v-else>
                    <TableRow>
                        <TableCell :colspan="columns.length" class="h-24 text-center">
                            Нет данных
                        </TableCell>
                    </TableRow>
                </template>
            </TableBody>
        </Table>
    </div>

    <div class="flex items-center justify-end space-x-2 py-4">
        <div class="flex items-center space-x-2">
            <p class="text-sm font-medium">Записей на странице</p>
            <Select :model-value="table.getState().pagination.pageSize" @update:model-value="(value) => table.setPageSize(Number(value))">
                <SelectTrigger class="h-8 w-[80px]">
                    <SelectValue :placeholder="table.getState().pagination.pageSize.toString()" />
                </SelectTrigger>
                <SelectContent side="top">
                    <SelectItem v-for="pageSize in pageSizes" :key="pageSize" :value="pageSize">
                        {{ pageSize }}
                    </SelectItem>
                </SelectContent>
            </Select>
        </div>
        <div class="space-x-2">
            <div class="flex items-center space-x-2">
                <Button variant="outline" class="hidden h-8 w-8 p-0 lg:flex" :disabled="!table.getCanPreviousPage()" @click="() => table.setPageIndex(0)">
                    <ChevronsLeftIcon class="h-4 w-4" />
                </Button>
                <Button variant="outline" class="h-8 w-8 p-0" :disabled="!table.getCanPreviousPage()" @click="() => table.previousPage()">
                    <ChevronLeftIcon class="h-4 w-4" />
                </Button>
                <template v-for="page in pagesToShow" :key="page">
                    <Button
                        v-if="page !== '...'"
                        variant="outline"
                        class="h-8 w-8 p-0"
                        :class="{ '!bg-foreground !text-background': page === currentPage + 1 }"
                        :disabled="page === currentPage + 1"
                        @click="() => table.setPageIndex(page - 1)"
                    >
                        {{ page }}
                    </Button>
                    <span v-else class="px-2 text-muted-foreground select-none">...</span>
                </template>
                <Button variant="outline" class="h-8 w-8 p-0" :disabled="!table.getCanNextPage()" @click="() => table.nextPage()">
                    <ChevronRightIcon class="h-4 w-4" />
                </Button>
                <Button variant="outline" class="hidden h-8 w-8 p-0 lg:flex" :disabled="!table.getCanNextPage()" @click="() => table.setPageIndex(table.getPageCount() - 1)">
                    <ChevronsRightIcon class="h-4 w-4" />
                </Button>
            </div>
        </div>
    </div>
</template>
