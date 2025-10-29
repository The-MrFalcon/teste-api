<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import RecordList from '@/components/RecordList.vue';

const props = defineProps<{
    patient: number;
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
];
</script>

<template>
    <Head title="Prontuários" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="bg-white p-6 rounded-xl shadow">
                <RecordList :patient-id="props.patient" />
            </div>
        </div>
    </AppLayout>
</template>