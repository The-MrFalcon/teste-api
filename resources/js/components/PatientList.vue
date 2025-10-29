<script setup lang="ts">
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'

interface Patient {
  id: number
  nome: string
  cpf: string
  data_nascimento: string
  email: string
  telefone: string
}

defineProps<{
  patients: Patient[]
}>()
</script>

<template>
  <div class="w-full">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-semibold text-gray-800">Pacientes</h2>
      <Link
        href="/patients/new"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Novo Paciente
      </Link>
    </div>

    <div v-if="patients.length === 0" class="text-center text-gray-600 py-4">
      Nenhum paciente cadastrado.
    </div>

    <div v-else class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPF</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data de Nascimento</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefone</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="patient in patients" :key="patient.id">
            <td class="px-6 py-4 whitespace-nowrap">{{ patient.nome }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ patient.cpf }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ new Date(patient.data_nascimento).toLocaleDateString() }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ patient.email }}</td>
            <td class="px-6 py-4 whitespace-nowrap">{{ patient.telefone }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <Link
                :href="`/patients/${patient.id}`"
                class="text-blue-600 hover:text-blue-900 mr-4"
              >
                Ver
              </Link>
              <Link
                :href="`/patients/${patient.id}/edit`"
                class="text-green-600 hover:text-green-900 mr-4"
              >
                Editar
              </Link>
              <Link
                :href="`/patients/${patient.id}/records`"
                class="text-purple-600 hover:text-purple-900"
              >
                Prontuários
              </Link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>