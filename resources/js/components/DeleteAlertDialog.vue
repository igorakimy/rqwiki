<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogTrigger,
    AlertDialogContent,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogCancel,
    AlertDialogAction
} from '@/components/ui/alert-dialog';

interface Props {
    title: string;
    open: boolean;
    action: any;
    description?: string;
    cancelText?: string;
    actionText?: string;
}

withDefaults(defineProps<Props>(), {
    cancelText: 'Отмена',
    actionText: 'Продолжить',
});

</script>

<template>
    <AlertDialog>
        <AlertDialogTrigger as-child>
            <slot/>
        </AlertDialogTrigger>
        <AlertDialogContent>
            <AlertDialogHeader>
                <AlertDialogTitle>{{ title }}</AlertDialogTitle>
                <AlertDialogDescription v-if="description">
                    {{ description }}
                </AlertDialogDescription>
            </AlertDialogHeader>
            <AlertDialogFooter>
                <AlertDialogCancel>{{ cancelText }}</AlertDialogCancel>
                <AlertDialogAction>{{ actionText }}</AlertDialogAction>
            </AlertDialogFooter>
        </AlertDialogContent>
    </AlertDialog>
</template>
