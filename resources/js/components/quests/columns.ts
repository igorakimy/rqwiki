import { h } from 'vue';
import { ColumnDef } from '@tanstack/vue-table';
import type { Quest } from '@/types';
import { Button } from '@/components/ui/button';
import DropdownAction from '@/components/DataTableDropdown.vue';
import { getColumnSortIcon } from '@/lib/utils';
import { Link } from '@inertiajs/vue3';

export const columns: ColumnDef<Quest>[] = [
    {
        id: 'id',
        accessorKey: 'id'
    },
    {
        accessorKey: 'name',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Квест', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const name = row.getValue('name')
            return h(Link, {
                class: 'text-left font-medium hover:underline',
                href: route('quests.show', {id: row.getValue('id')})
            }, () => name)
        },
        enableColumnFilter: true,
    },
    {
        accessorKey: 'required_level',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Уровень', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const level = row.getValue('required_level')
            return h('div', {
                class: 'text-left font-medium',
            }, level)
        },
    },
    {
        accessorKey: 'gold',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Золото', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const gold = row.getValue('gold')
            return h('div', {
                class: 'text-left font-medium',
            }, gold)
        },
    },
    {
        accessorKey: 'experience',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Опыт', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const experience = row.getValue('experience')
            return h('div', {
                class: 'text-left font-medium',
            }, experience)
        },
    },
    {
        id: 'actions',
        cell: ({ row }) => {
            const quest = row.original
            return h('div', { class: 'relative text-end' }, h(DropdownAction, {
                entity: quest,
                routes: {
                    destroy: route('quests.destroy', {id: row.getValue('id')}),
                    edit: route('quests.edit', {id: row.getValue('id')}),
                }
            }))
        },
        enableSorting: false,
    },
]
