<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PatientForm from '@/components/PatientForm.vue';

const props = defineProps<{
    patient: number;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Editar Paciente',
        href: `/patients/${props.patient}/edit`,
    },
];
</script>

<template>
    <Head title="Editar Paciente" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="bg-white p-6 rounded-xl shadow">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Editar Paciente</h1>
                <PatientForm :patient-id="props.patient" />
            </div>
        </div>
    </AppLayout>
</template>