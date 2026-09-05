<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'

defineProps({
    variant: {
        type: String,
        default: 'mark', // 'mark' | 'full'
    },
})

// Build an absolute URL for the logo using the asset base shared from the
// backend, so it resolves correctly on any route (and in a subfolder deploy).
const logoSrc = computed(() => {
    const base = usePage().props.assetUrl ?? ''
    return `${base}/img/fontoura-dragao.png`
})
</script>

<template>
    <!-- Lockup completo: dragão + texto -->
    <div v-if="variant === 'full'" class="inline-flex items-center gap-3">
        <img
            :src="logoSrc"
            alt="Fontoura Desenvolvimento"
            class="h-full w-auto object-contain"
        />
        <span class="flex flex-col leading-none">
            <span class="text-lg font-extrabold tracking-wide text-brand-dark-900">
                FONTOURA
            </span>
            <span class="text-[0.6rem] font-semibold tracking-[0.35em] text-brand-orange-600">
                DESENVOLVIMENTO
            </span>
        </span>
    </div>

    <!-- Apenas o dragão -->
    <img
        v-else
        :src="logoSrc"
        alt="Fontoura Desenvolvimento"
        class="object-contain"
    />
</template>
