<script setup>
import { computed } from 'vue'
import { Head, Link, useForm, usePage } from '@inertiajs/vue3'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
})

const page = usePage()
const flashSuccess = computed(() => page.props.flash?.success)

const form = useForm({
    name: '',
    email: '',
    phone: '',
    best_contact_time: '',
    message: '',
})

const submitContact = () => {
    form.post(route('contact.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    })
}

const whatsappLink =
    'https://wa.me/5541992516138?text=Ol%C3%A1,%20gostaria%20de%20um%20or%C3%A7amento%20de%20desenvolvimento'

const services = [
    {
        title: 'Aplicações Web sob medida',
        description:
            'Sistemas robustos com Laravel e Vue, do MVP à plataforma completa, focados em performance e escalabilidade.',
    },
    {
        title: 'APIs e integrações',
        description:
            'APIs REST bem documentadas, integrações com gateways de pagamento, ERPs e serviços de terceiros.',
    },
    {
        title: 'Modernização de sistemas',
        description:
            'Migração e refatoração de sistemas legados para stacks modernas, mantendo o negócio rodando sem sustos.',
    },
    {
        title: 'Consultoria e sustentação',
        description:
            'Acompanhamento técnico contínuo, revisão de arquitetura e suporte para o seu time crescer com segurança.',
    },
]

const differentials = [
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
                    <a href="#services" class="text-sm font-medium text-brand-dark-600 transition hover:text-brand-orange-600">Serviços</a>
                    <a href="#about" class="text-sm font-medium text-brand-dark-600 transition hover:text-brand-orange-600">Sobre</a>
                    <a href="#contact" class="text-sm font-medium text-brand-dark-600 transition hover:text-brand-orange-600">Contato</a>
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
                            href="#services"
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
        <section id="services" class="bg-white py-24">
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
                        v-for="service in services"
                        :key="service.title"
                        class="group rounded-2xl border border-brand-dark-100 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:border-brand-orange-200 hover:shadow-md"
                    >
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-brand-orange-500 to-brand-orange-600 text-white">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-semibold text-brand-dark-900">{{ service.title }}</h3>
                        <p class="text-brand-dark-500">{{ service.description }}</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SOBRE / DIFERENCIAIS -->
        <section id="about" class="bg-brand-dark-50 py-24">
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
                        v-for="item in differentials"
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
        <section id="contact" class="bg-gradient-to-br from-brand-orange-500 to-brand-orange-600 py-24 text-white">
            <div class="mx-auto max-w-5xl px-6">
                <div class="text-center">
                    <h2 class="text-3xl font-bold">Vamos construir algo juntos?</h2>
                    <p class="mx-auto mt-4 max-w-xl text-lg text-white/90">
                        Conte pra gente sobre seu projeto. Respondemos rápido e sem compromisso.
                    </p>
                    <div class="mt-8 flex justify-center">
                        <a
                            :href="whatsappLink"
                            target="_blank"
                            class="inline-flex items-center gap-2 rounded-xl bg-brand-dark-900 px-8 py-4 font-semibold text-white shadow-lg transition hover:bg-brand-dark-800"
                        >
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.872.118.571-.085 1.758-.719 2.006-1.413.247-.694.247-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413" />
                            </svg>
                            Falar pelo WhatsApp
                        </a>
                    </div>
                </div>

                <!-- FORMULÁRIO -->
                <div class="mx-auto mt-12 max-w-2xl rounded-2xl bg-white p-8 text-brand-dark-800 shadow-xl">
                    <h3 class="text-xl font-bold text-brand-dark-900">Prefere que a gente entre em contato?</h3>
                    <p class="mt-1 text-sm text-brand-dark-500">
                        Preencha o formulário e retornamos no melhor horário para você.
                    </p>

                    <div
                        v-if="flashSuccess"
                        class="mt-6 rounded-lg border border-brand-orange-200 bg-brand-orange-50 px-4 py-3 text-sm font-medium text-brand-orange-800"
                    >
                        {{ flashSuccess }}
                    </div>

                    <form class="mt-6 grid gap-5" @submit.prevent="submitContact">
                        <!-- Nome -->
                        <div>
                            <label for="name" class="mb-1 block text-sm font-medium text-brand-dark-700">Nome</label>
                            <input
                                id="name"
                                v-model="form.name"
                                type="text"
                                placeholder="Nome e sobrenome (ex.: João Silva)"
                                class="w-full rounded-lg border-brand-dark-200 shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                            />
                            <p v-if="form.errors.name" class="mt-1 text-sm text-red-600">{{ form.errors.name }}</p>
                        </div>

                        <div class="grid gap-5 sm:grid-cols-2">
                            <!-- Email -->
                            <div>
                                <label for="email" class="mb-1 block text-sm font-medium text-brand-dark-700">E-mail</label>
                                <input
                                    id="email"
                                    v-model="form.email"
                                    type="email"
                                    placeholder="seu@email.com"
                                    class="w-full rounded-lg border-brand-dark-200 shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                                />
                                <p v-if="form.errors.email" class="mt-1 text-sm text-red-600">{{ form.errors.email }}</p>
                            </div>

                            <!-- Telefone -->
                            <div>
                                <label for="phone" class="mb-1 block text-sm font-medium text-brand-dark-700">Telefone</label>
                                <input
                                    id="phone"
                                    v-model="form.phone"
                                    type="tel"
                                    placeholder="(41) 99999-9999"
                                    class="w-full rounded-lg border-brand-dark-200 shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                                />
                                <p v-if="form.errors.phone" class="mt-1 text-sm text-red-600">{{ form.errors.phone }}</p>
                            </div>
                        </div>

                        <!-- Melhor horário -->
                        <div>
                            <label for="best_contact_time" class="mb-1 block text-sm font-medium text-brand-dark-700">Melhor horário para contato</label>
                            <select
                                id="best_contact_time"
                                v-model="form.best_contact_time"
                                class="w-full rounded-lg border-brand-dark-200 shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                            >
                                <option value="" disabled>Selecione...</option>
                                <option value="morning">Manhã</option>
                                <option value="afternoon">Tarde</option>
                                <option value="evening">Noite</option>
                            </select>
                            <p v-if="form.errors.best_contact_time" class="mt-1 text-sm text-red-600">{{ form.errors.best_contact_time }}</p>
                        </div>

                        <!-- Descrição -->
                        <div>
                            <label for="message" class="mb-1 block text-sm font-medium text-brand-dark-700">Descrição</label>
                            <textarea
                                id="message"
                                v-model="form.message"
                                rows="4"
                                placeholder="Conte um pouco sobre o que você precisa..."
                                class="w-full rounded-lg border-brand-dark-200 shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                            ></textarea>
                            <p v-if="form.errors.message" class="mt-1 text-sm text-red-600">{{ form.errors.message }}</p>
                        </div>

                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex justify-center rounded-lg bg-brand-orange-600 px-6 py-3 font-semibold text-white shadow-sm transition hover:bg-brand-orange-700 disabled:cursor-not-allowed disabled:opacity-60"
                        >
                            {{ form.processing ? 'Enviando...' : 'Enviar mensagem' }}
                        </button>
                    </form>
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
