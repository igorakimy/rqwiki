<script setup lang="ts">

import {
    Sheet,
    SheetClose,
    SheetContent,
    SheetDescription,
    SheetFooter, SheetHeader,
    SheetTitle,
    SheetTrigger
} from '@/components/ui/sheet';
import { Button } from '@/components/ui/button';
import { ScrollArea } from '@/components/ui/scroll-area';
import { Image } from '@/types';
import { computed, ref } from 'vue';
import { Tooltip, TooltipContent, TooltipTrigger, TooltipProvider } from '@/components/ui/tooltip';
import { Input } from '@/components/ui/input';

interface Props {
    images: Image[]
}

const props = defineProps<Props>();

const model = defineModel();

const filterValue = ref('');

const selectedId = ref(model.value);

const selectImage = (image: Image) => {
    selectedId.value = image.id
}

const confirmSelection = () => {
    model.value = selectedId.value
}

const filteredImages = computed(() => {
    return props.images.filter(image => image.name.toLowerCase().includes(filterValue.value.toLowerCase()));
})

const selectedImage = computed(() => {
    return props.images.find(img => img.id === selectedId.value)
});

</script>

<template>
    <Sheet>
        <SheetTrigger as-child>
            <Button variant="outline" class="justify-start">
                {{ selectedImage ? 'Изменить изображение' : 'Выбрать изображение' }}
            </Button>
        </SheetTrigger>
        <SheetContent side="bottom">
            <SheetHeader>
                <SheetTitle>Галерея изображений</SheetTitle>
                <SheetDescription>
                    <Input class="w-[400px]" placeholder="Поиск..." v-model="filterValue"/>
                </SheetDescription>
            </SheetHeader>
            <ScrollArea class="h-[400px]">
                <div class="grid grid-cols-6 gap-4">
                    <TooltipProvider>

                    </TooltipProvider>
                    <div class="flex justify-center" v-for="image in filteredImages" :key="image.id">
                        <Tooltip>
                            <TooltipTrigger as-child>
                                <img
                                    :class="`h-[160px] cursor-pointer rounded-md border-foreground hover:border-2 ${selectedId === image.id ? 'border-2' : 'border-0'}`"
                                    :src="image.media[0].original_url"
                                    :alt="image.name"
                                    @click="selectImage(image)"
                                >
                            </TooltipTrigger>
                            <TooltipContent>
                                <p>{{ image.name }}</p>
                            </TooltipContent>
                        </Tooltip>
                    </div>
                </div>
            </ScrollArea>
            <SheetFooter>
                <SheetClose as-child>
                    <Button @click="confirmSelection">
                        Подтвердить выбор
                    </Button>
                </SheetClose>
            </SheetFooter>
        </SheetContent>
    </Sheet>
</template>
