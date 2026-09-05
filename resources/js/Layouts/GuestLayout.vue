<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-brand-dark-50 pt-6 sm:justify-center sm:pt-0"
    >
        <div>
            <Link href="/" class="flex flex-col items-center gap-3">
                <ApplicationLogo class="h-20 w-20" />
                <span class="flex flex-col items-center leading-none">
                    <span class="text-lg font-extrabold tracking-wide text-brand-dark-900">FONTOURA</span>
                    <span class="text-[0.6rem] font-semibold tracking-[0.35em] text-brand-orange-600">DESENVOLVIMENTO</span>
                </span>
            </Link>
        </div>

        <div
            class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
