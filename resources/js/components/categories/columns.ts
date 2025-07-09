import { h } from 'vue';
import { ColumnDef } from '@tanstack/vue-table';
import type { Category } from '@/types';
import DropdownAction from '@/components/categories/DataTableDropdown.vue'

export const columns: ColumnDef<Category>[] = [
    {
        accessorKey: 'name',
        header: () => h('div', { class: 'text-left' }, 'Название'),
        cell: ({ row }) => {
            const name = row.getValue('name')
            return h('div', { class: 'text-left font-medium' }, name)
        },
    },
    {
        accessorKey: 'pages',
        header: () => h('div', { class: 'text-center' }, 'Кол-во'),
        cell: () => {
            return h('div', { class: 'text-center font-medium' }, Math.round(Math.random() * 100))
        },
    },
    {
        id: 'actions',
        enableHiding: false,
        cell: ({ row }) => {
            const category = row.original
            return h('div', { class: 'relative text-end' }, h(DropdownAction, {
                category,
            }))
        },
    },
]
