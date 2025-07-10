<script setup lang="ts" generic="TData, TValue">
import type { ColumnDef, PaginationState, SortingState, Updater } from '@tanstack/vue-table';
import {
    FlexRender,
    getCoreRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    useVueTable
} from '@tanstack/vue-table';
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';

import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Button } from '@/components/ui/button';
import { computed, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { ChevronLeftIcon, ChevronRightIcon, ChevronsLeftIcon, ChevronsRightIcon } from 'lucide-vue-next';
import type { DataTablePagination } from '@/types';
// import { valueUpdater } from '@/lib/utils';

const props = defineProps<{
    columns: ColumnDef<TData, TValue>[];
    data: TData[];
    route: string;
    pagination: DataTablePagination;
}>()

const pageSizes = [10, 50, 100];

const pagination = ref<PaginationState>({
    pageIndex: props.pagination.current_page - 1,
    pageSize: props.pagination.per_page,
})

const sorting = ref<SortingState>([]);

const currentPage = computed(() => table.getState().pagination.pageIndex);
const perPage = computed(() => table.getState().pagination.pageSize);
const pageCount = computed(() => table.getPageCount());

const table = useVueTable({
    get data() { return props.data },
    get columns() { return props.columns },
    state: {
        get sorting() { return sorting.value },
        get pagination() { return pagination.value },
    },
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    pageCount: props.pagination.last_page,
    manualPagination: true,
    manualSorting: true,
    onPaginationChange: changePagination,
    onSortingChange: changeSorting,
})

function changePagination(updater) {
    if (typeof updater === 'function') {
        setPagination(updater({
            pageIndex: pagination.value.pageIndex,
            pageSize: pagination.value.pageSize,
        }))
    } else {
        setPagination(updater)
    }
    router.get(props.route, {
        page: pagination.value.pageIndex + 1,
        per_page: pagination.value.pageSize,
        sort_field: sorting.value[0]?.id,
        sort_direction: sorting.value.length == 0 ? undefined : (sorting.value[0]?.desc ? "desc" : "asc"),
    }, {
        preserveState: false,
        preserveScroll: true,
    })
}

function changeSorting<T extends Updater<any>>(updaterOrValue: T) {
    sorting.value = typeof updaterOrValue === 'function'
            ? updaterOrValue(sorting.value)
            : updaterOrValue;

    router.get(
        props.route,
        {
            page: pagination.value.pageIndex + 1,
            per_page: pagination.value.pageSize,
            sort_field: sorting.value[0]?.id,
            sort_direction: sorting.value.length == 0 ? undefined : (sorting.value[0]?.desc ? "desc" : "asc"),
        },
        {
            preserveState: true,
            preserveScroll: true
        }
    );
}

function setPagination({pageIndex,pageSize}: PaginationState): PaginationState {
    pagination.value.pageIndex = pageIndex
    pagination.value.pageSize = pageSize
    return { pageIndex, pageSize }
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

const pagesToShow = computed(() => getPages(currentPage.value, pageCount.value));

const start = computed(() => props.pagination.total === 0 ? 0 : currentPage.value * perPage.value + 1)

const end = computed(() => {
    const possibleEnd = (currentPage.value + 1) * perPage.value
    return possibleEnd > props.pagination.total ? props.pagination.total : possibleEnd
})

</script>

<template>
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
        <div class="flex-1 text-sm text-muted-foreground">
            {{ start }} - {{ end }} записи показаны
        </div>
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
<!--                <Pagination v-slot="{ page }" :items-per-page="pagination.pageSize" :total="table.getTotalSize()" :default-page="1">-->
<!--                    <PaginationContent v-slot="{ items }">-->
<!--                        <PaginationPrevious />-->

<!--                        <template v-for="(item, index) in items" :key="index">-->
<!--                            <PaginationItem-->
<!--                                v-if="item.type === 'page'"-->
<!--                                :value="item.value"-->
<!--                                :is-active="item.value === page"-->
<!--                            >-->
<!--                                {{ item.value }}-->
<!--                            </PaginationItem>-->
<!--                        </template>-->

<!--                        <PaginationEllipsis :index="4" />-->

<!--                        <PaginationNext />-->
<!--                    </PaginationContent>-->
<!--                </Pagination>-->
            </div>
        </div>
    </div>
</template>
