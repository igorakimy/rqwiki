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

export interface WorldMap {
    name: string;
    image: Image
}

export interface LocationType {
    id: number;
    name: string;
    plural_name: string;
    description?: string;
}

export interface Location {
    id?: number;
    name: string;
    description?: string;
    image: Image;
    location_types: LocationType[];
    categories: Category[];
}

export interface Race {
    id?: number;
    name: string;
    image: Image;
}

export interface Element {
    id?: number;
    name: string;
    image: Image;
}

export interface Monster {
    id?: number;
    name: string;
    level: number;
    health_points: number;
    element_strength: number;
    is_aggressive: boolean;
    is_elite: boolean;
    is_boss: boolean;
    pick_up_loot: boolean;
    shield: number;
    defence: string;
    experience: number;
    xp_per_hp: number;
    combat_mode: string;
    quest_only: boolean;
    race: Race;
    element: Element;
    image: Image;
    big_image?: Image|null;
    locations: Location[];
    categories: Category[];
}

export interface NpcGroup {
    id?: number;
    name: string;
    plural_name: string;
    description: string;
}

export interface NPC {
    id?: number;
    name: string;
    image: Image;
    npc_groups: NpcGroup[];
    locations: Location[];
    categories: Category[];
}

export interface QuestType {
    id?: number;
    name: string;
}

export interface QuestChain {
    id?: number;
    name: string;
}

export interface Quest {
    id?: number;
    name: string;
    parent?: Quest | null;
    required_level: number;
    gold: number;
    experience: number;
    condition: string;
    condition_description?: string;
    explanation?: string;
    quest_type: QuestType;
    quest_chain?: QuestChain | null;
    npc_from: NPC | null;
    npc_to: NPC | null;
    prev_quests: Quest[];
    next_quests: Quest[];
}
