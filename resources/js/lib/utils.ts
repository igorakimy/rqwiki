import { clsx, type ClassValue } from 'clsx';
import { twMerge } from 'tailwind-merge';
import { SortDirection, Updater } from '@tanstack/vue-table';
import { FunctionalComponent, Ref } from 'vue';
import { ChevronDown, ChevronUp, ChevronsUpDown } from 'lucide-vue-next';

export function cn(...inputs: ClassValue[]) {
    return twMerge(clsx(inputs));
}

export function valueUpdater<T extends Updater<any>>(updaterOrValue: T, ref: Ref) {
    ref.value = typeof updaterOrValue === 'function'
        ? updaterOrValue(ref.value)
        : updaterOrValue;
}

export function getColumnSortIcon(direction: boolean | SortDirection): FunctionalComponent {
    switch (direction) {
        case 'asc':
            return ChevronUp;
        case 'desc':
            return ChevronDown;
        default:
            return ChevronsUpDown;
    }
}
