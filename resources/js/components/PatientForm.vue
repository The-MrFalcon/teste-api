<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

interface Patient {
    nome: string;
    cpf: string;
    data_nascimento: string;
    email: string;
    telefone: string;
}

const props = defineProps<{
    patient?: Patient;
    patientId?: number;
}>();

const form = ref({
    nome: props.patient?.nome ?? '',
    cpf: props.patient?.cpf ?? '',
    data_nascimento: props.patient?.data_nascimento
        ? props.patient.data_nascimento.split('T')[0]
        : '',
    email: props.patient?.email ?? '',
    telefone: props.patient?.telefone ?? '',
});

const processing = ref(false);
const errors = ref<{ [key: string]: string | string[] }>({});

const handleSubmit = () => {
    processing.value = true;
    const url = props.patientId ? `/patients/${props.patientId}` : '/patients';
    const method = props.patientId ? 'put' : 'post';

    router[method](url, form.value, {
        onSuccess: () => {
            router.visit('/dashboard');
        },
        onError: (err) => {
            errors.value = err;
        },
        onFinish: () => {
            processing.value = false;
        },
    });
};
</script>

<template>
    <form @submit.prevent="handleSubmit" class="space-y-6">
        <div v-if="Object.keys(errors).length > 0" class="mb-4 text-red-600">
            <div v-for="(error, key) in errors" :key="key">{{ error }}</div>
        </div>

        <div>
            <label for="nome" class="block text-sm font-medium text-gray-700"
                >Nome</label
            >
            <input
                type="text"
                id="nome"
                v-model="form.nome"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
        </div>

        <div>
            <label for="cpf" class="block text-sm font-medium text-gray-700"
                >CPF</label
            >
            <input
                type="text"
                id="cpf"
                v-model="form.cpf"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
        </div>

        <div>
            <label
                for="data_nascimento"
                class="block text-sm font-medium text-gray-700"
                >Data de Nascimento</label
            >
            <input
                type="date"
                id="data_nascimento"
                v-model="form.data_nascimento"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700"
                >Email</label
            >
            <input
                type="email"
                id="email"
                v-model="form.email"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
        </div>

        <div>
            <label
                for="telefone"
                class="block text-sm font-medium text-gray-700"
                >Telefone</label
            >
            <input
                type="tel"
                id="telefone"
                v-model="form.telefone"
                required
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
            />
        </div>

        <div class="flex justify-end space-x-3">
            <Link
                href="/dashboard"
                class="rounded-md bg-gray-100 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-200"
            >
                Cancelar
            </Link>
            <button
                type="submit"
                :disabled="processing"
                class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 disabled:opacity-50"
            >
                {{
                    processing
                        ? 'Salvando...'
                        : props.patientId
                          ? 'Atualizar'
                          : 'Criar'
                }}
            </button>
        </div>
    </form>
</template>
