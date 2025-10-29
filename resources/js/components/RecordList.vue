<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useApi } from '@/composables/useApi'

interface Record {
  id: number
  data_atendimento: string
  diagnostico: string
  tratamento: string
}
const records = ref<Record[]>([])

const props = defineProps<{
  patientId: number
}>()

const { loading, error, fetchRecords } = useApi()

const loadRecords = async () => {
  try {
    records.value = await fetchRecords(props.patientId)
  } catch (err) {
    console.error(err)
  }
}

onMounted(() => {
  loadRecords()
})
</script>

<template>
  <div class="w-full">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-semibold text-gray-800">Prontuários</h2>
      <router-link
        :to="`/patients/${patientId}/records/new`"
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
      >
        Novo Prontuário
      </router-link>
    </div>

    <div v-if="loading" class="text-center py-4">
      Carregando...
    </div>

    <div v-else-if="error" class="text-center text-red-600 py-4">
      {{ error }}
    </div>

    <div v-else-if="records.length === 0" class="text-center text-gray-600 py-4">
      Nenhum prontuário cadastrado.
    </div>

    <div v-else class="overflow-x-auto">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data do Atendimento</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Diagnóstico</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tratamento</th>
            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <tr v-for="record in records" :key="record.id">
            <td class="px-6 py-4 whitespace-nowrap">{{ new Date(record.data_atendimento).toLocaleDateString() }}</td>
            <td class="px-6 py-4">{{ record.diagnostico }}</td>
            <td class="px-6 py-4">{{ record.tratamento }}</td>
            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
              <router-link
                :to="`/patients/${patientId}/records/${record.id}`"
                class="text-blue-600 hover:text-blue-900 mr-4"
              >
                Ver
              </router-link>
              <router-link
                :to="`/patients/${patientId}/records/${record.id}/edit`"
                class="text-green-600 hover:text-green-900"
              >
                Editar
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>