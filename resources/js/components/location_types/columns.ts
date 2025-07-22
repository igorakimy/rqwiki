import { h } from 'vue';
import { ColumnDef } from '@tanstack/vue-table';
import type { LocationType } from '@/types';
import { Button } from '@/components/ui/button';
import DropdownAction from '@/components/DataTableDropdown.vue';
import { getColumnSortIcon } from '@/lib/utils';

export const columns: ColumnDef<LocationType>[] = [
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
            }, () => ['Наименование', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const name = row.getValue('name')
            return h('div', {
                class: 'text-left font-medium',
                href: route('location-types.edit', {id: row.getValue('id')})
            }, name)
        },
        enableColumnFilter: true,
    },
    {
        id: 'actions',
        cell: ({ row }) => {
            const locationType = row.original
            return h('div', { class: 'relative text-end' }, h(DropdownAction, {
                entity: locationType,
                routes: {
                    destroy: route('location-types.destroy', {id: row.getValue('id')}),
                    edit: route('location-types.edit', {id: row.getValue('id')}),
                }
            }))
        },
        enableSorting: false,
    },
]
