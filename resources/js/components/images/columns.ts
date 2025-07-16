import { h } from 'vue';
import { ColumnDef } from '@tanstack/vue-table';
import type { Image } from '@/types';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';
import DropdownAction from '@/components/DataTableDropdown.vue';
import { getColumnSortIcon } from '@/lib/utils';

export const columns: ColumnDef<Image>[] = [
    {
        id: 'id',
        accessorKey: 'id'
    },
    {
        accessorKey: 'media',
        header: 'Изображение',
        cell: ({row}) => {
            const media = row.getValue('media')[0];
            return h(Link, {
                class: '',
                href: route('images.edit', {id: row.getValue('id')})
            }, () => h('img', {
                class: 'h-[80px]',
                src: media.original_url
            }))
        },
    },
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
                href: route('images.edit', {id: row.getValue('id')})
            }, () => name)
        },
        enableColumnFilter: true,
    },
    {
        id: 'actions',
        cell: ({ row }) => {
            const image = row.original
            return h('div', { class: 'relative text-end' }, h(DropdownAction, {
                entity: image,
                routes: {
                    destroy: route('images.destroy', {id: row.getValue('id')}),
                    edit: route('images.edit', {id: row.getValue('id')}),
                }
            }))
        },
        enableSorting: false,
    },
]
