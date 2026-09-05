<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const props = defineProps({
    contact: {
        type: Object,
        required: true,
    },
    categories: {
        type: Array,
        default: () => [],
    },
})

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

// Form for updating category/status.
const detailsForm = useForm({
    contact_category_id: props.contact.contact_category_id ?? '',
    status: props.contact.status,
})

const submitDetails = () => {
    detailsForm
        .transform((data) => ({
            ...data,
            contact_category_id: data.contact_category_id === '' ? null : data.contact_category_id,
        }))
        .patch(route('contacts.update', props.contact.id), {
            preserveScroll: true,
        })
}

// Form for adding a note.
const noteForm = useForm({
    body: '',
})

const submitNote = () => {
    noteForm.post(route('contacts.notes.store', props.contact.id), {
        preserveScroll: true,
        onSuccess: () => noteForm.reset('body'),
    })
}

const deleteNote = (noteId) => {
    noteForm.delete(route('contacts.notes.destroy', [props.contact.id, noteId]), {
        preserveScroll: true,
    })
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
    <Head :title="`Contato: ${contact.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-brand-dark-900">
                    {{ contact.name }}
                </h2>
                <Link
                    :href="route('contacts.index')"
                    class="text-sm font-medium text-brand-dark-500 hover:text-brand-orange-600"
                >
                    &larr; Voltar
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-6 sm:px-6 lg:grid-cols-3 lg:px-8">
                <!-- Coluna esquerda: dados + edição -->
                <div class="space-y-6 lg:col-span-1">
                    <!-- Dados do contato -->
                    <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                        <h3 class="text-base font-semibold text-brand-dark-900">Dados do contato</h3>
                        <dl class="mt-4 space-y-3 text-sm">
                            <div>
                                <dt class="font-medium text-brand-dark-500">E-mail</dt>
                                <dd class="text-brand-dark-800">
                                    <a :href="`mailto:${contact.email}`" class="hover:text-brand-orange-600">{{ contact.email }}</a>
                                </dd>
                            </div>
                            <div>
                                <dt class="font-medium text-brand-dark-500">Telefone</dt>
                                <dd class="text-brand-dark-800">{{ contact.phone }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-brand-dark-500">Melhor horário</dt>
                                <dd class="text-brand-dark-800">{{ bestContactTimeLabels[contact.best_contact_time] ?? contact.best_contact_time }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-brand-dark-500">Recebido em</dt>
                                <dd class="text-brand-dark-800">{{ formatDate(contact.created_at) }}</dd>
                            </div>
                            <div>
                                <dt class="font-medium text-brand-dark-500">Mensagem</dt>
                                <dd class="whitespace-pre-line text-brand-dark-800">{{ contact.message }}</dd>
                            </div>
                        </dl>
                    </div>

                    <!-- Categorização / status -->
                    <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                        <h3 class="text-base font-semibold text-brand-dark-900">Classificação</h3>
                        <form class="mt-4 space-y-4" @submit.prevent="submitDetails">
                            <div>
                                <label for="category" class="block text-sm font-medium text-brand-dark-700">Categoria</label>
                                <select
                                    id="category"
                                    v-model="detailsForm.contact_category_id"
                                    class="mt-1 w-full rounded-md border-brand-dark-200 text-sm shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                                >
                                    <option value="">Sem categoria</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">
                                        {{ category.name }}
                                    </option>
                                </select>
                                <InputError class="mt-1" :message="detailsForm.errors.contact_category_id" />
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-brand-dark-700">Status</label>
                                <select
                                    id="status"
                                    v-model="detailsForm.status"
                                    class="mt-1 w-full rounded-md border-brand-dark-200 text-sm shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                                >
                                    <option value="open">Aberto</option>
                                    <option value="in_progress">Em andamento</option>
                                    <option value="closed">Fechado</option>
                                </select>
                                <InputError class="mt-1" :message="detailsForm.errors.status" />
                            </div>
                            <div class="flex justify-end">
                                <PrimaryButton :disabled="detailsForm.processing">Salvar</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Coluna direita: anotações (chamados) -->
                <div class="lg:col-span-2">
                    <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                        <h3 class="text-base font-semibold text-brand-dark-900">Anotações</h3>

                        <!-- Nova anotação -->
                        <form class="mt-4 space-y-2" @submit.prevent="submitNote">
                            <textarea
                                v-model="noteForm.body"
                                rows="3"
                                placeholder="Registre um atendimento, observação ou próximo passo..."
                                class="w-full rounded-md border-brand-dark-200 text-sm shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                            ></textarea>
                            <InputError :message="noteForm.errors.body" />
                            <div class="flex justify-end">
                                <PrimaryButton :disabled="noteForm.processing">Adicionar anotação</PrimaryButton>
                            </div>
                        </form>

                        <!-- Lista de anotações -->
                        <div class="mt-6 space-y-4">
                            <p
                                v-if="contact.notes.length === 0"
                                class="text-sm text-brand-dark-400"
                            >
                                Nenhuma anotação registrada ainda.
                            </p>

                            <div
                                v-for="note in contact.notes"
                                :key="note.id"
                                class="rounded-lg border border-brand-dark-100 bg-brand-dark-50/50 p-4"
                            >
                                <div class="flex items-center justify-between">
                                    <p class="text-xs font-medium text-brand-dark-500">
                                        {{ note.author?.name ?? 'Usuário' }} · {{ formatDate(note.created_at) }}
                                    </p>
                                    <button
                                        type="button"
                                        class="text-xs font-medium text-red-500 hover:text-red-700"
                                        @click="deleteNote(note.id)"
                                    >
                                        Remover
                                    </button>
                                </div>
                                <p class="mt-2 whitespace-pre-line text-sm text-brand-dark-800">{{ note.body }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
