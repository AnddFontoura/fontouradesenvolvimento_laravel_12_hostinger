<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link } from '@inertiajs/vue3'

defineProps({
    contacts: {
        type: Object,
        required: true,
    },
})

// Maps the stored (English) values to the labels shown in the UI (PT).
const bestContactTimeLabels = {
    morning: 'Manhã',
    afternoon: 'Tarde',
    evening: 'Noite',
}

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
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <!-- Estado vazio -->
                    <div
                        v-if="contacts.data.length === 0"
                        class="p-10 text-center text-brand-dark-500"
                    >
                        Nenhum contato recebido até o momento.
                    </div>

                    <!-- Tabela -->
                    <div v-else class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-brand-dark-100">
                            <thead class="bg-brand-dark-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-brand-dark-600">Nome</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-brand-dark-600">E-mail</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-brand-dark-600">Telefone</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-brand-dark-600">Melhor horário</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-brand-dark-600">Descrição</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-brand-dark-600">Recebido em</th>
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
                                        <a :href="`mailto:${contact.email}`" class="hover:text-brand-orange-600">
                                            {{ contact.email }}
                                        </a>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-brand-dark-600">
                                        {{ contact.phone }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm">
                                        <span class="inline-flex rounded-full bg-brand-orange-100 px-2.5 py-0.5 text-xs font-medium text-brand-orange-800">
                                            {{ bestContactTimeLabels[contact.best_contact_time] ?? contact.best_contact_time }}
                                        </span>
                                    </td>
                                    <td class="max-w-md px-6 py-4 text-sm text-brand-dark-600">
                                        <span class="line-clamp-2">{{ contact.message }}</span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-sm text-brand-dark-500">
                                        {{ formatDate(contact.created_at) }}
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
