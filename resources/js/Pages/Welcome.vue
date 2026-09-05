<script setup>
import { Head, Link } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
})

const whatsappLink =
    'https://wa.me/5519998845678?text=Ol%C3%A1,%20gostaria%20de%20um%20or%C3%A7amento%20de%20desenvolvimento'

const servicos = [
    {
        titulo: 'Aplicações Web sob medida',
        descricao:
            'Sistemas robustos com Laravel e Vue, do MVP à plataforma completa, focados em performance e escalabilidade.',
    },
    {
        titulo: 'APIs e integrações',
        descricao:
            'APIs REST bem documentadas, integrações com gateways de pagamento, ERPs e serviços de terceiros.',
    },
    {
        titulo: 'Modernização de sistemas',
        descricao:
            'Migração e refatoração de sistemas legados para stacks modernas, mantendo o negócio rodando sem sustos.',
    },
    {
        titulo: 'Consultoria e sustentação',
        descricao:
            'Acompanhamento técnico contínuo, revisão de arquitetura e suporte para o seu time crescer com segurança.',
    },
]

const diferenciais = [
    'Código limpo e testável, pensado para durar',
    'Comunicação direta, sem enrolação técnica',
    'Entregas incrementais com feedback constante',
    'Foco no resultado do negócio, não só no código',
]
</script>

<template>
    <Head title="Desenvolvimento de Software" />

    <div class="min-h-screen bg-white text-brand-dark-800">
        <!-- HEADER -->
        <header class="sticky top-0 z-30 border-b border-brand-dark-100 bg-white/90 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-6 py-4">
                <ApplicationLogo variant="full" class="h-10" />

                <nav class="hidden items-center gap-8 md:flex">
                    <a href="#servicos" class="text-sm font-medium text-brand-dark-600 transition hover:text-brand-orange-600">Serviços</a>
                    <a href="#sobre" class="text-sm font-medium text-brand-dark-600 transition hover:text-brand-orange-600">Sobre</a>
                    <a href="#contato" class="text-sm font-medium text-brand-dark-600 transition hover:text-brand-orange-600">Contato</a>
                </nav>

                <div v-if="canLogin" class="flex items-center gap-3">
                    <Link
                        :href="route('login')"
                        class="text-sm font-semibold text-brand-dark-700 transition hover:text-brand-orange-600"
                    >
                        Entrar
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-lg bg-brand-orange-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-brand-orange-700"
                    >
                        Criar conta
                    </Link>
                </div>
            </div>
        </header>

        <!-- HERO -->
        <section class="relative overflow-hidden bg-brand-dark-900 text-white">
            <div class="pointer-events-none absolute -right-24 -top-24 h-96 w-96 rounded-full bg-brand-orange-600/30 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-brand-orange-500/20 blur-3xl"></div>

            <div class="relative mx-auto grid max-w-6xl gap-12 px-6 py-24 md:grid-cols-[3fr_2fr] md:items-center">
                <div>
                    <p class="inline-flex items-center rounded-full bg-white/10 px-4 py-2 text-sm font-medium text-brand-orange-300">
                        Software sob medida para o seu negócio
                    </p>

                    <h1 class="mt-6 text-4xl font-extrabold leading-tight md:text-5xl">
                        Transformamos ideias em
                        <span class="bg-gradient-to-r from-brand-orange-500 to-brand-orange-600 bg-clip-text text-transparent">
                            produtos digitais
                        </span>
                        que geram resultado.
                    </h1>

                    <p class="mt-6 max-w-xl text-lg text-brand-dark-100">
                        A Fontoura Desenvolvimento cria aplicações web modernas, escaláveis e
                        confiáveis. Da concepção à sustentação, cuidamos da tecnologia para
                        você focar no que importa.
                    </p>

                    <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                        <a
                            :href="whatsappLink"
                            target="_blank"
                            class="inline-flex justify-center rounded-xl bg-brand-orange-600 px-8 py-4 font-semibold text-white shadow-lg transition hover:bg-brand-orange-700"
                        >
                            Solicitar orçamento
                        </a>
                        <a
                            href="#servicos"
                            class="inline-flex justify-center rounded-xl border border-white/20 px-8 py-4 font-semibold text-white transition hover:bg-white/10"
                        >
                            Ver serviços
                        </a>
                    </div>
                </div>

                <div class="flex justify-center md:justify-end">
                    <div class="relative">
                        <div class="absolute inset-0 -m-6 rounded-full bg-brand-orange-500/20 blur-2xl"></div>
                        <ApplicationLogo class="relative h-56 w-56 drop-shadow-2xl md:h-72 md:w-72" />
                    </div>
                </div>
            </div>
        </section>

        <!-- SERVIÇOS -->
        <section id="servicos" class="bg-white py-24">
            <div class="mx-auto max-w-6xl px-6">
                <div class="mx-auto mb-14 max-w-2xl text-center">
                    <h2 class="text-3xl font-bold text-brand-dark-900">O que fazemos</h2>
                    <p class="mt-4 text-brand-dark-500">
                        Soluções completas de desenvolvimento, sempre com foco em qualidade e no
                        objetivo do seu negócio.
                    </p>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div
                        v-for="servico in servicos"
                        :key="servico.titulo"
                        class="group rounded-2xl border border-brand-dark-100 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:border-brand-orange-200 hover:shadow-md"
                    >
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-brand-orange-500 to-brand-orange-600 text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-semibold text-brand-dark-900">{{ servico.titulo }}</h3>
                        <p class="text-brand-dark-500">{{ servico.descricao }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SOBRE / DIFERENCIAIS -->
        <section id="sobre" class="bg-brand-dark-50 py-24">
            <div class="mx-auto grid max-w-6xl gap-12 px-6 md:grid-cols-2 md:items-center">
                <div>
                    <h2 class="text-3xl font-bold text-brand-dark-900">Sobre a Fontoura</h2>
                    <p class="mt-6 leading-relaxed text-brand-dark-600">
                        Somos uma empresa de desenvolvimento de software focada em entregar
                        soluções sólidas e sustentáveis. Trabalhamos lado a lado com nossos
                        clientes, entendendo o problema antes de escrever a primeira linha de
                        código.
                    </p>
                    <p class="mt-4 leading-relaxed text-brand-dark-600">
                        Nosso stack principal é Laravel e Vue, com Inertia e Tailwind, o que nos
                        permite construir produtos rápidos, seguros e fáceis de evoluir.
                    </p>
                </div>

                <ul class="grid gap-4">
                    <li
                        v-for="item in diferenciais"
                        :key="item"
                        class="flex items-start gap-3 rounded-xl border border-brand-dark-100 bg-white p-5 shadow-sm"
                    >
                        <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-brand-orange-600 text-white">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                        <span class="text-brand-dark-700">{{ item }}</span>
                    </li>
                </ul>
            </div>
        </section>

        <!-- CONTATO -->
        <section id="contato" class="bg-gradient-to-br from-brand-orange-500 to-brand-orange-600 py-24 text-white">
            <div class="mx-auto max-w-3xl px-6 text-center">
                <h2 class="text-3xl font-bold">Vamos construir algo juntos?</h2>
                <p class="mx-auto mt-4 max-w-xl text-lg text-white/90">
                    Conte pra gente sobre seu projeto. Respondemos rápido e sem compromisso.
                </p>
                <div class="mt-8 flex justify-center">
                    <a
                        :href="whatsappLink"
                        target="_blank"
                        class="rounded-xl bg-brand-dark-900 px-8 py-4 font-semibold text-white shadow-lg transition hover:bg-brand-dark-800"
                    >
                        Falar pelo WhatsApp
                    </a>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="bg-brand-dark-900 py-10 text-brand-dark-200">
            <div class="mx-auto flex max-w-6xl flex-col items-center gap-4 px-6 text-center md:flex-row md:justify-between md:text-left">
                <div class="flex items-center gap-3">
                    <ApplicationLogo class="h-10 w-10" />
                    <span class="flex flex-col leading-none">
                        <span class="text-base font-extrabold tracking-wide text-white">FONTOURA</span>
                        <span class="text-[0.6rem] font-semibold tracking-[0.35em] text-brand-orange-400">DESENVOLVIMENTO</span>
                    </span>
                </div>
                <p class="text-sm">
                    © 2026 Fontoura Desenvolvimento. Todos os direitos reservados.
                </p>
            </div>
        </footer>
    </div>
</template>
