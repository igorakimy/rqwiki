<script setup lang="ts">
import { useDraggable } from '@vue-dnd-kit/core';
import { computed } from 'vue';
import { GripVertical } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';

const props = defineProps({
    source: Array,
    index: Number,
});

const { elementRef, handleDragStart, isDragging, isOvered } = useDraggable({
    data: computed(() => ({
        index: props.index,
        source: props.source,
    })),
});
</script>

<template>
    <div
        ref="elementRef"
        class="draggable-item flex w-full rounded-md border border-neutral-200 dark:border-neutral-800 bg-transparent p-2 gap-1"
        :class="{ 'is-dragging': isDragging, 'is-overed': isOvered }"
    >
        <Button @click.prevent @pointerdown="handleDragStart" variant="ghost" size="icon">
            <GripVertical class="w-4 h-4" />
        </Button>
        <slot />
    </div>
</template>
