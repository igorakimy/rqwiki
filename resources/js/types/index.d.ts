import type { LucideIcon } from 'lucide-vue-next';
import type { Config } from 'ziggy-js';

export interface Auth {
    user: User;
}

export interface BreadcrumbItem {
    title: string;
    href: string;
}

export interface NavItem {
    title: string;
    href: string;
    icon?: LucideIcon;
    isActive?: boolean;
}

export type AppPageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    name: string;
    quote: { message: string; author: string };
    auth: Auth;
    ziggy: Config & { location: string };
    sidebarOpen: boolean;
};

export interface User {
    id: number;
    name: string;
    email: string;
    avatar?: string;
    email_verified_at: string | null;
    created_at: string;
    updated_at: string;
}

export type BreadcrumbItemType = BreadcrumbItem;

export interface Category {
    id: number;
    name: string;
}

export interface DataTablePagination {
    current_page: number;
    per_page: number;
    total: number;
    last_page: number;
}

export interface DataTableFilter {
    id: string,
    value: string,
}

export interface DataTableRoute {
    url: string;
    id: string;
}

export interface DataTableRoutes {
    index?: string;
    create?: string;
    show?: DataTableRoute;
    edit?: DataTableRoute;
    destroy?: DataTableRoute;
}

export interface Media {
    id: number;
    name: string;
    file_name: string;
    size: number;
    generated_conversions: Array,
    original_url: string;
    collection_name: string;
}

export interface Image {
    id: number;
    name: string;
    description?: string;
    media?: Media[];
}

interface MediaCollection {
    name: string;
    formatted_name: string;
}
