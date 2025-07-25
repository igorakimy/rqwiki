import { h } from 'vue';
import { ColumnDef } from '@tanstack/vue-table';
import type { Category } from '@/types';
import DropdownAction from '@/components/DataTableDropdown.vue'
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';
import { getColumnSortIcon } from '@/lib/utils';

export const columns: ColumnDef<Category>[] = [
    {
        accessorKey: 'name',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Название', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const name = row.getValue('name')
            return h(Link, {
                class: 'text-left font-medium',
                href: route('categories.show', {id: row.getValue('id')})
            }, () => name)
        },
        enableColumnFilter: true,
    },
    {
        accessorKey: 'id',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                class: 'justify-end',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Кол-во', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            return h('div', { class: 'text-left font-medium' }, row.getValue('id'))
        },
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const category = row.original
            return h('div', { class: 'relative text-end' }, h(DropdownAction, {
                entity: category,
                routes: {}
            }))
        },
        enableSorting: false,
    },
]
