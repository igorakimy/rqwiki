import { h } from 'vue';
import { ColumnDef } from '@tanstack/vue-table';
import type { NPC } from '@/types';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';
import DropdownAction from '@/components/DataTableDropdown.vue';
import { getColumnSortIcon } from '@/lib/utils';

export const columns: ColumnDef<NPC>[] = [
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
            }, () => ['Имя', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({row}) => {
            const image = row.original.image;
            const name = row.getValue('name');
            return h(Link, {
                class: 'flex items-center gap-2 hover:underline',
                href: route('npcs.show', {id: row.getValue('id')})
            }, () => [h('img', {
                class: 'h-[36px] w-[36px]',
                src: image.media[0].original_url
            }), h('p', {
                class: '',
            }, name)])
        },
        enableColumnFilter: true,
    },
    {
        accessorKey: 'locations',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Местоположение', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const locations = row.original.locations
            return h('div', {},
                locations.reduce((acc, location, idx) => {
                    acc.push(
                        h(Link, {
                            class: 'hover:underline',
                            href: route('locations.show', {id: location.id})
                        }, () => location.name)
                    )
                    if (idx < locations.length - 1) {
                        acc.push(', ')
                    }
                    return acc
                }, [])
            )
        },
    },
    {
        accessorKey: 'npc_groups',
        header: "Группа",
        cell: ({ row }) => {
            const groups = row.original.npc_groups
            return h('div', {},
                groups.reduce((acc, group, idx) => {
                    acc.push(h('span', {}, group.plural_name))
                    if (idx < groups.length - 1) {
                        acc.push(', ')
                    }
                    return acc
                }, [])
            )
        },
    },
    {
        id: 'actions',
        cell: ({ row }) => {
            const npc = row.original
            return h('div', { class: 'relative text-end' }, h(DropdownAction, {
                entity: npc,
                routes: {
                    destroy: route('npcs.destroy', {id: row.getValue('id')}),
                    edit: route('npcs.edit', {id: row.getValue('id')}),
                }
            }))
        },
        enableSorting: false,
    },
]
