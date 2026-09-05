<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { reactive, watch } from 'vue'

// Small debounce helper so we don't add an extra dependency.
const debounce = (fn, delay) => {
    let timeout
    return (...args) => {
        clearTimeout(timeout)
        timeout = setTimeout(() => fn(...args), delay)
    }
}

const props = defineProps({
    contacts: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        default: () => ({}),
    },
    categories: {
        type: Array,
        default: () => [],
    },
})

// Local, reactive copy of the current filters coming from the server.
const form = reactive({
    name: props.filters.name ?? '',
    email: props.filters.email ?? '',
    phone: props.filters.phone ?? '',
    best_contact_time: props.filters.best_contact_time ?? '',
    status: props.filters.status ?? '',
    contact_category_id: props.filters.contact_category_id ?? '',
})

// Maps the stored (English) values to the labels shown in the UI (PT).
const bestContactTimeLabels = {
    morning: 'Manhã',
    afternoon: 'Tarde',
    evening: 'Noite',
}

const statusLabels = {
    open: 'Aberto',
    in_progress: 'Em andamento',
    closed: 'Fechado',
}

const statusClasses = {
    open: 'bg-blue-100 text-blue-800',
    in_progress: 'bg-yellow-100 text-yellow-800',
    closed: 'bg-green-100 text-green-800',
}

const applyFilters = debounce(() => {
    router.get(route('contacts.index'), cleanForm(), {
        preserveState: true,
        preserveScroll: true,
        replace: true,
    })
}, 350)

const cleanForm = () => {
    return Object.fromEntries(
        Object.entries(form).filter(([, value]) => value !== '' && value !== null),
    )
}

const resetFilters = () => {
    form.name = ''
    form.email = ''
    form.phone = ''
    form.best_contact_time = ''
    form.status = ''
    form.contact_category_id = ''
}

watch(form, () => applyFilters())

const formatDate = (value) => {
    if (!value) {
        return ''
    }

    return new Date(value).toLocaleString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    })
}
</script>

<template>
    <Head title="Contatos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-brand-dark-900">
                Contatos recebidos
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                <!-- Filtros -->
                <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3 lg:grid-cols-6">
                        <div>
                            <label for="filter-name" class="block text-sm font-medium text-brand-dark-700">Nome</label>
                            <input
                                id="filter-name"
                                v-model="form.name"
                                type="text"
                                placeholder="Parte do nome"
                                class="mt-1 w-full rounded-md border-brand-dark-200 text-sm shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                            />
                        </div>
                        <div>
                            <label for="filter-email" class="block text-sm font-medium text-brand-dark-700">E-mail</label>
                            <input
                                id="filter-email"
                                v-model="form.email"
                                type="text"
                                placeholder="Parte do e-mail"
                                class="mt-1 w-full rounded-md border-brand-dark-200 text-sm shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                            />
                        </div>
                        <div>
                            <label for="filter-phone" class="block text-sm font-medium text-brand-dark-700">Telefone</label>
                            <input
                                id="filter-phone"
                                v-model="form.phone"
                                type="text"
                                placeholder="Parte do telefone"
                                class="mt-1 w-full rounded-md border-brand-dark-200 text-sm shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                            />
                        </div>
                        <div>
                            <label for="filter-time" class="block text-sm font-medium text-brand-dark-700">Melhor horário</label>
                            <select
                                id="filter-time"
                                v-model="form.best_contact_time"
                                class="mt-1 w-full rounded-md border-brand-dark-200 text-sm shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                            >
                                <option value="">Todos</option>
                                <option value="morning">Manhã</option>
                                <option value="afternoon">Tarde</option>
                                <option value="evening">Noite</option>
                            </select>
                        </div>
                        <div>
                            <label for="filter-status" class="block text-sm font-medium text-brand-dark-700">Status</label>
                            <select
                                id="filter-status"
                                v-model="form.status"
                                class="mt-1 w-full rounded-md border-brand-dark-200 text-sm shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                            >
                                <option value="">Todos</option>
                                <option value="open">Aberto</option>
                                <option value="in_progress">Em andamento</option>
                                <option value="closed">Fechado</option>
                            </select>
                        </div>
                        <div>
                            <label for="filter-category" class="block text-sm font-medium text-brand-dark-700">Categoria</label>
                            <select
                                id="filter-category"
                                v-model="form.contact_category_id"
                                class="mt-1 w-full rounded-md border-brand-dark-200 text-sm shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                            >
                                <option value="">Todas</option>
                                <option v-for="category in categories" :key="category.id" :value="category.id">
                                    {{ category.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <button
                            type="button"
                            class="text-sm font-medium text-brand-dark-500 hover:text-brand-orange-600"
                            @click="resetFilters"
                        >
                            Limpar filtros
                        </button>
                    </div>
                </div>

                <!-- Tabela -->
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div
                        v-if="contacts.data.length === 0"
                        class="p-10 text-center text-brand-dark-500"
                    >
                        Nenhum contato encontrado com os filtros atuais.
                    </div>

                    <div v-else class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-brand-dark-100">
                            <thead class="bg-brand-dark-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-brand-dark-600">Nome</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-brand-dark-600">E-mail</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-brand-dark-600">Telefone</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-brand-dark-600">Melhor horário</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-brand-dark-600">Categoria</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-brand-dark-600">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-brand-dark-600">Recebido em</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-brand-dark-100 bg-white">
                                <tr
                                    v-for="contact in contacts.data"
                                    :key="contact.id"
                                    class="transition hover:bg-brand-orange-50/50"
                                >
                                    <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-brand-dark-900">
                                        {{ contact.name }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-brand-dark-600">
                                        {{ contact.email }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-brand-dark-600">
                                        {{ contact.phone }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        <span class="inline-flex rounded-full bg-brand-orange-100 px-2.5 py-0.5 text-xs font-medium text-brand-orange-800">
                                            {{ bestContactTimeLabels[contact.best_contact_time] ?? contact.best_contact_time }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-brand-dark-600">
                                        <span v-if="contact.category">{{ contact.category.name }}</span>
                                        <span v-else class="text-brand-dark-300">—</span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        <span
                                            class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium"
                                            :class="statusClasses[contact.status]"
                                        >
                                            {{ statusLabels[contact.status] ?? contact.status }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-brand-dark-500">
                                        {{ formatDate(contact.created_at) }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                                        <Link
                                            :href="route('contacts.show', contact.id)"
                                            class="font-medium text-brand-orange-600 hover:text-brand-orange-700"
                                        >
                                            Ver
                                        </Link>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginação -->
                    <div
                        v-if="contacts.data.length > 0"
                        class="flex flex-wrap items-center justify-between gap-4 border-t border-brand-dark-100 px-6 py-4"
                    >
                        <p class="text-sm text-brand-dark-500">
                            Mostrando {{ contacts.from }}–{{ contacts.to }} de {{ contacts.total }}
                        </p>

                        <div class="flex flex-wrap gap-1">
                            <template v-for="(link, index) in contacts.links" :key="index">
                                <span
                                    v-if="!link.url"
                                    class="rounded-md px-3 py-2 text-sm text-brand-dark-300"
                                    v-html="link.label"
                                />
                                <Link
                                    v-else
                                    :href="link.url"
                                    class="rounded-md px-3 py-2 text-sm transition"
                                    :class="link.active
                                        ? 'bg-brand-orange-600 text-white'
                                        : 'text-brand-dark-600 hover:bg-brand-dark-100'"
                                    v-html="link.label"
                                    preserve-scroll
                                />
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
