<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import RecordForm from '@/components/RecordForm.vue';

const props = defineProps<{
    patient: number;
    record: number;
}>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Prontuários',
        href: `/patients/${props.patient}/records`,
    },
    {
        title: 'Editar Prontuário',
        href: `/patients/${props.patient}/records/${props.record}/edit`,
    },
];
</script>

<template>
    <Head title="Editar Prontuário" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="bg-white p-6 rounded-xl shadow">
                <h1 class="text-2xl font-semibold text-gray-900 mb-6">Editar Prontuário</h1>
                <RecordForm 
                    :patient-id="props.patient"
                    :record-id="props.record"
                />
            </div>
        </div>
    </AppLayout>
</template>