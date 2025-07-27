import { h } from 'vue';
import { ColumnDef } from '@tanstack/vue-table';
import type { Monster } from '@/types';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';
import DropdownAction from '@/components/DataTableDropdown.vue';
import { getColumnSortIcon } from '@/lib/utils';

export const columns: ColumnDef<Monster>[] = [
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
            }, () => ['Название', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({row}) => {
            const image = row.original.image;
            const name = row.getValue('name');
            return h(Link, {
                class: 'flex items-center gap-2 hover:underline',
                href: route('monsters.show', {id: row.getValue('id')})
            }, () => [h('img', {
                class: 'h-[32px]',
                src: image.media[0].original_url
            }), h('p', {
                class: '',
            }, name)])
        },
        enableColumnFilter: true,
    },
    {
        accessorKey: 'level',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Уровень', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const level = row.getValue('level')
            return h('div', {
                class: 'text-left font-medium',
            }, level)
        },
    },
    {
        accessorKey: 'race',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Раса', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const race = row.getValue('race')
            return h('div', {
                class: 'flex gap-1',
            }, [h('img', {
                class: 'h-[20px]',
                src: race.image.media[0].original_url
            }), h('p', {
                class: '',
            }, race.name)])
        },
    },
    {
        accessorKey: 'element',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Элемент', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const element = row.getValue('element')
            const element_strength = row.original.element_strength
            return h('div', {
                class: 'flex gap-0.3',
            }, Array(element_strength).fill(h('img', {
                class: 'h-[20px] w-[20px]',
                src: element.image.media[0].original_url
            })))
        },
    },
    {
        accessorKey: 'health_points',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Жизни', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const health_points = row.getValue('health_points')
            return h('div', {
                class: 'text-left font-medium',
            }, health_points)
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
        accessorKey: 'xp_per_hp',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Опыт/Жизни', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const xp_per_hp = row.getValue('xp_per_hp')
            return h('div', {
                class: 'text-left font-medium',
            }, xp_per_hp)
        },
    },
    {
        accessorKey: 'locations',
        header: 'Обитает',
        cell: ({ row }) => {
            const locations = row.original.locations
            return h('div', {
                class: 'flex flex-row items-center space-x-2',
            }, locations.map(location => h(Link, {
                class: 'flex items-center gap-2 hover:underline',
                href: route('locations.show', {id: location.id})
            }, () => location.name)))
        },
        enableSorting: false,
    },
    {
        id: 'actions',
        cell: ({ row }) => {
            const monster = row.original
            return h('div', { class: 'relative text-end' }, h(DropdownAction, {
                entity: monster,
                routes: {
                    destroy: route('monsters.destroy', {id: row.getValue('id')}),
                    edit: route('monsters.edit', {id: row.getValue('id')}),
                }
            }))
        },
        enableSorting: false,
    },
]
