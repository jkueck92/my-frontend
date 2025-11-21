<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { ChevronLeft } from 'lucide-vue-next'

interface Props {
    title: string;
    description?: string;
    showBackButton?: boolean;
}

defineProps<Props>();

const goBack = () => {
    window.history.back();
};
</script>

<template>
    <!--
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <Button v-if="showBackButton" variant="link" @click="goBack">
                <ChevronLeft />
            </Button>
            <div class="space-y-0.5">
                <h2 class="text-xl font-semibold tracking-tight">{{ title }}</h2>
                <p v-if="description" class="text-sm text-muted-foreground">
                    {{ description }}
                </p>
            </div>
        </div>
        <slot />
    </div>
    -->
    <div class="flex items-center justify-between mb-8">
        <div class="space-y-0.5">
            <h2 class="text-xl font-semibold tracking-tight">{{ title }}</h2>
            <p v-if="description" class="text-sm text-muted-foreground">
                {{ description }}
            </p>
        </div>
        <slot />
    </div>
</template>
