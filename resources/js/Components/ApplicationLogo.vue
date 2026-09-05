<script setup>
// Logo da marca Fontoura Desenvolvimento (dragão em PNG).
// Coloque a arte em: public/img/fontoura-dragao.png
//
// Use a prop `variant` para escolher entre apenas o dragão ("mark")
// ou o lockup completo com o texto ("full").
defineProps({
    variant: {
        type: String,
        default: 'mark', // 'mark' | 'full'
    },
})

// Caminho absoluto a partir da raiz do domínio. Os arquivos de `public/` são
// servidos a partir da raiz (tanto local quanto na Hostinger), então o caminho
// absoluto funciona independentemente da rota atual e do <base href>.
const logoSrc = '/img/fontoura-dragao.png'
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
