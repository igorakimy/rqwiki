<script setup lang="ts">
import { MoreHorizontal } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Pencil, Trash } from 'lucide-vue-next';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuSeparator,
    DropdownMenuTrigger
} from '@/components/ui/dropdown-menu';
import { DataTableRoutes } from '@/types';
import { router } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import {
    AlertDialog, AlertDialogAction, AlertDialogCancel, AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter, AlertDialogHeader, AlertDialogTitle,
    AlertDialogTrigger
} from '@/components/ui/alert-dialog';

const props = defineProps<{
    entity: { id: number },
    routes: DataTableRoutes
}>()

const destroy = (id: number) => {
    router.delete(props.routes.destroy, id);
    toast.success('Удалено');
}

const edit = (id: number) => {
    router.get(props.routes.edit, id);
}

</script>

<template>
    <AlertDialog>
        <DropdownMenu>
            <DropdownMenuTrigger as-child>
                <Button variant="ghost" class="w-8 h-8 p-0" v-if="routes.edit || routes.destroy">
                    <span class="sr-only">Меню</span>
                    <MoreHorizontal class="w-4 h-4" />
                </Button>
            </DropdownMenuTrigger>
            <DropdownMenuContent align="end">
                <DropdownMenuItem @click="edit" v-if="routes.edit">
                    <Pencil />
                    Изменить
                </DropdownMenuItem>
                <DropdownMenuSeparator v-if="routes.destroy" />
                <AlertDialogTrigger class="w-full" v-if="routes.destroy">
                    <DropdownMenuItem>
                        <Trash />
                        Удалить
                    </DropdownMenuItem>
                </AlertDialogTrigger>
            </DropdownMenuContent>
        </DropdownMenu>
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>Вы абсолютно уверены, что хотите удалить?</AlertDialogTitle>
                <AlertDialogDescription>
                    Это действие не может быть отменено.
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel>Отмена</AlertDialogCancel>
                <AlertDialogAction
                    @click="destroy"
                    class="bg-destructive dark:bg-destructive/60 hover:bg-destructive focus-visible:ring-destructive text-white"
                >Удалить</AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
