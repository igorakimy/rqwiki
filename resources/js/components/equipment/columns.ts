import { h } from 'vue';
import { ColumnDef } from '@tanstack/vue-table';
import type { Equipment } from '@/types';
import { Button } from '@/components/ui/button';
import { Link } from '@inertiajs/vue3';
import DropdownAction from '@/components/DataTableDropdown.vue';
import { getColumnSortIcon } from '@/lib/utils';
import { Badge } from '@/components/ui/badge';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';

export const columns: ColumnDef<Equipment>[] = [
    {
        id: 'id',
        accessorKey: 'id'
    },
    {
        id: 'equipment_type',
        accessorKey: 'equipment_type',
    },
    {
        accessorKey: 'image',
        header: '',
        cell: ({row}) => {
            const image = row.getValue('image');
            return h(Link, {
                class: 'block w-fit',
                href: route('equipment.show', {id: row.getValue('id')})
            }, () => h('img', {
                class: 'min-h-[64px] min-w-[64px] h-[64px] w-[64px]',
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
            }, () => ['Название', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({row}) => {
            const name = row.getValue('name');
            return h(Link, {
                class: 'flex items-center gap-2 hover:underline',
                href: route('equipment.show', {id: row.getValue('id')})
            }, () => name)
        },
        enableColumnFilter: true,
    },
    {
        accessorKey: 'classes',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Классы', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const charClasses = row.original.classes;
            return h('div', {
                class: 'flex flex-row items-center space-x-2 ',
            }, charClasses.length > 0 ? charClasses.map(charClass => h(Link, {
                class: 'flex items-center gap-2 hover:underline',
                title: charClass.name,
                href: '#'
            }, () => h('img', {
                class: 'min-h-[22px] min-w-[22px] h-[22px] w-[22px]',
                src: charClass.image?.media[0].original_url
            }))) : 'Все классы')
        },
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
            const itemClass = row.original.item_class
            return h('div', {
                class: 'flex gap-1 items-center',
            }, [
                level,
                h(Badge, {variant: 'outline', class: 'px-1.5'}, () => itemClass)
            ])
        },
    },
    {
        accessorKey: 'defence',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Защита', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const defence = row.getValue('defence')
            return h('div', {
                class: '',
            }, defence ? defence : '—')
        },
    },
    {
        accessorKey: 'gender',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Пол', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const gender = row.getValue('gender')
            return h('div', {
                class: '',
            }, gender)
        },
    },
    {
        accessorKey: 'selling_price',
        header: ({ column }) => {
            return h(Button, {
                variant: 'ghost',
                onClick: () => column.toggleSorting(column.getIsSorted() === 'asc'),
            }, () => ['Цена', h(getColumnSortIcon(column.getIsSorted()), { class: 'ml-2 h-4 w-4' })])
        },
        cell: ({ row }) => {
            const sellingPrice = row.getValue('selling_price')
            return h('div', {
                class: '',
            }, sellingPrice)
        },
    },
    {
        accessorKey: 'bonuses',
        header: 'Бонус',
        cell: ({row}) => {
            const bonuses = row.getValue('bonuses');

            return h(ScrollArea, {class: 'w-130'}, () => [
                h('div', {class: 'flex gap-2.5 py-2'},
                    bonuses.reduce((acc, b, idx) => {
                        acc.push(
                            h('span', {
                                class: '',
                            }, `+${b.pivot.value}${b.pivot.value_type == 'процент' ? '%' : ''} ${b.name_formatted}${idx < bonuses.length - 1 ? ', ' : ''}`)
                        )
                        return acc
                    }, [])
                ),
                h(ScrollBar, {orientation: 'horizontal'}, null)
            ])
        },
    },
    {
        id: 'actions',
        cell: ({ row }) => {
            const equipment = row.original
            return h('div', { class: 'relative text-end' }, h(DropdownAction, {
                entity: equipment,
                routes: {
                    destroy: route('equipment.destroy', {id: row.getValue('id')}),
                    edit: route('equipment.edit', {id: row.getValue('id')}),
                }
            }))
        },
        enableSorting: false,
    },
]
