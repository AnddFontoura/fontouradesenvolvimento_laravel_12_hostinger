<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import { Head, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'

defineProps({
    categories: {
        type: Array,
        default: () => [],
    },
})

const colorOptions = [
    { value: 'gray', label: 'Cinza' },
    { value: 'orange', label: 'Laranja' },
    { value: 'blue', label: 'Azul' },
    { value: 'green', label: 'Verde' },
    { value: 'purple', label: 'Roxo' },
    { value: 'red', label: 'Vermelho' },
    { value: 'yellow', label: 'Amarelo' },
]

const colorClasses = {
    gray: 'bg-gray-100 text-gray-800',
    orange: 'bg-brand-orange-100 text-brand-orange-800',
    blue: 'bg-blue-100 text-blue-800',
    green: 'bg-green-100 text-green-800',
    purple: 'bg-purple-100 text-purple-800',
    red: 'bg-red-100 text-red-800',
    yellow: 'bg-yellow-100 text-yellow-800',
}

// Create form.
const createForm = useForm({
    name: '',
    color: 'gray',
})

const submitCreate = () => {
    createForm.post(route('categories.store'), {
        preserveScroll: true,
        onSuccess: () => createForm.reset(),
    })
}

// Inline edit state.
const editingId = ref(null)
const editForm = useForm({
    name: '',
    color: 'gray',
})

const startEdit = (category) => {
    editingId.value = category.id
    editForm.name = category.name
    editForm.color = category.color
    editForm.clearErrors()
}

const cancelEdit = () => {
    editingId.value = null
    editForm.reset()
}

const submitEdit = (category) => {
    editForm.patch(route('categories.update', category.id), {
        preserveScroll: true,
        onSuccess: () => cancelEdit(),
    })
}

const deleteForm = useForm({})

const deleteCategory = (category) => {
    if (!confirm(`Remover a categoria "${category.name}"?`)) {
        return
    }

    deleteForm.delete(route('categories.destroy', category.id), {
        preserveScroll: true,
    })
}
</script>

<template>
    <Head title="Categorias" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-brand-dark-900">
                Categorias de contato
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto grid max-w-7xl grid-cols-1 gap-6 sm:px-6 lg:grid-cols-3 lg:px-8">
                <!-- Nova categoria -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 shadow-sm sm:rounded-lg">
                        <h3 class="text-base font-semibold text-brand-dark-900">Nova categoria</h3>
                        <form class="mt-4 space-y-4" @submit.prevent="submitCreate">
                            <div>
                                <label for="new-name" class="block text-sm font-medium text-brand-dark-700">Nome</label>
                                <input
                                    id="new-name"
                                    v-model="createForm.name"
                                    type="text"
                                    class="mt-1 w-full rounded-md border-brand-dark-200 text-sm shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                                />
                                <InputError class="mt-1" :message="createForm.errors.name" />
                            </div>
                            <div>
                                <label for="new-color" class="block text-sm font-medium text-brand-dark-700">Cor</label>
                                <select
                                    id="new-color"
                                    v-model="createForm.color"
                                    class="mt-1 w-full rounded-md border-brand-dark-200 text-sm shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                                >
                                    <option v-for="option in colorOptions" :key="option.value" :value="option.value">
                                        {{ option.label }}
                                    </option>
                                </select>
                                <InputError class="mt-1" :message="createForm.errors.color" />
                            </div>
                            <div class="flex justify-end">
                                <PrimaryButton :disabled="createForm.processing">Criar categoria</PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Lista de categorias -->
                <div class="lg:col-span-2">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div
                            v-if="categories.length === 0"
                            class="p-10 text-center text-brand-dark-500"
                        >
                            Nenhuma categoria cadastrada.
                        </div>

                        <ul v-else class="divide-y divide-brand-dark-100">
                            <li v-for="category in categories" :key="category.id" class="p-4">
                                <!-- Modo edição -->
                                <div v-if="editingId === category.id" class="space-y-3">
                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                        <div>
                                            <input
                                                v-model="editForm.name"
                                                type="text"
                                                class="w-full rounded-md border-brand-dark-200 text-sm shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                                            />
                                            <InputError class="mt-1" :message="editForm.errors.name" />
                                        </div>
                                        <div>
                                            <select
                                                v-model="editForm.color"
                                                class="w-full rounded-md border-brand-dark-200 text-sm shadow-sm focus:border-brand-orange-500 focus:ring-brand-orange-500"
                                            >
                                                <option v-for="option in colorOptions" :key="option.value" :value="option.value">
                                                    {{ option.label }}
                                                </option>
                                            </select>
                                            <InputError class="mt-1" :message="editForm.errors.color" />
                                        </div>
                                    </div>
                                    <div class="flex gap-2">
                                        <PrimaryButton :disabled="editForm.processing" @click="submitEdit(category)">Salvar</PrimaryButton>
                                        <button
                                            type="button"
                                            class="text-sm font-medium text-brand-dark-500 hover:text-brand-dark-700"
                                            @click="cancelEdit"
                                        >
                                            Cancelar
                                        </button>
                                    </div>
                                </div>

                                <!-- Modo leitura -->
                                <div v-else class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-medium"
                                            :class="colorClasses[category.color] ?? colorClasses.gray"
                                        >
                                            {{ category.name }}
                                        </span>
                                        <span class="text-xs text-brand-dark-400">
                                            {{ category.contacts_count }} contato(s)
                                        </span>
                                    </div>
                                    <div class="flex gap-3">
                                        <button
                                            type="button"
                                            class="text-sm font-medium text-brand-orange-600 hover:text-brand-orange-700"
                                            @click="startEdit(category)"
                                        >
                                            Editar
                                        </button>
                                        <button
                                            type="button"
                                            class="text-sm font-medium text-red-500 hover:text-red-700"
                                            @click="deleteCategory(category)"
                                        >
                                            Remover
                                        </button>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
