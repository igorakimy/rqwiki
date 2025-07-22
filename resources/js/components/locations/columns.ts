import { h } from 'vue';
import { ColumnDef } from '@tanstack/vue-table';
import type { Location } from '@/types';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';
import DropdownAction from '@/components/DataTableDropdown.vue';
import { getColumnSortIcon } from '@/lib/utils';

export const columns: ColumnDef<Location>[] = [
    {
        id: 'id',
        accessorKey: 'id'
    },
    {
        accessorKey: 'image',
        header: '',
        cell: ({row}) => {
            const image = row.getValue('image');
            return h(Link, {
                class: '',
                href: route('locations.show', {id: row.getValue('id')})
            }, () => h('img', {
                class: 'h-[100px]',
                src: image.media[0].original_url
            }))
        },
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
            return h(Link, {
                class: 'text-left font-medium',
                href: route('locations.show', {id: row.getValue('id')})
            }, () => name)
        },
        enableColumnFilter: true,
    },
    {
        accessorKey: 'location_types',
        header: 'Тип локации',
        cell: ({ row }) => {
            const locationTypes = row.getValue('location_types')
            return h('div', {
                class: 'text-left font-medium'
            }, locationTypes.map(type => type.name).join(', '))
        },
        enableSorting: false
    },
    {
        id: 'actions',
        cell: ({ row }) => {
            const location = row.original
            return h('div', { class: 'relative text-end' }, h(DropdownAction, {
                entity: location,
                routes: {
                    destroy: route('locations.destroy', {id: row.getValue('id')}),
                    edit: route('locations.edit', {id: row.getValue('id')}),
                }
            }))
        },
        enableSorting: false,
    },
]
