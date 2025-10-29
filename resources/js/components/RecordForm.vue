<script setup lang="ts">
import { ref } from 'vue'
import { router, Link } from '@inertiajs/vue3'

defineOptions({
  name: 'RecordForm'
})

interface MedicalRecord {
  data_atendimento: string
  diagnostico: string
  tratamento: string
  observacoes: string
}

const props = defineProps<{
  patientId: number
  recordId?: number
  record?: MedicalRecord
}>()

type ErrorBag = Record<string, string[]>

const processing = ref(false)
const errors = ref<ErrorBag>({})
const form = ref({
  data_atendimento: props.record?.data_atendimento
    ? props.record.data_atendimento.split('T')[0]
    : '',
  diagnostico: props.record?.diagnostico ?? '',
  tratamento: props.record?.tratamento ?? '',
  observacoes: props.record?.observacoes ?? '',
})

const handleSubmit = () => {
  processing.value = true

  const url = props.recordId
    ? `/patients/${props.patientId}/records/${props.recordId}`
    : `/patients/${props.patientId}/records`

  const method = props.recordId ? 'put' : 'post'

  router[method](url, form.value, {
    onSuccess: () => {
      router.visit(`/patients/${props.patientId}/records`)
    },
    onError: (err) => {
      errors.value = err as unknown as ErrorBag
    },
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>

<template>
  <form @submit.prevent="handleSubmit" class="space-y-6">
    <div v-if="Object.keys(errors).length > 0" class="text-red-600 mb-4">
      <div v-for="(messages, field) in errors" :key="field">
        <div v-for="message in messages" :key="message">{{ message }}</div>
      </div>
    </div>

    <div>
      <label for="data_atendimento" class="block text-sm font-medium text-gray-700">Data do Atendimento</label>
      <input
        type="date"
        id="data_atendimento"
        v-model="form.data_atendimento"
        required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
      />
    </div>

    <div>
      <label for="diagnostico" class="block text-sm font-medium text-gray-700">Diagnóstico</label>
      <textarea
        id="diagnostico"
        v-model="form.diagnostico"
        rows="3"
        required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
      ></textarea>
    </div>

    <div>
      <label for="tratamento" class="block text-sm font-medium text-gray-700">Tratamento</label>
      <textarea
        id="tratamento"
        v-model="form.tratamento"
        rows="3"
        required
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
      ></textarea>
    </div>

    <div>
      <label for="observacoes" class="block text-sm font-medium text-gray-700">Observações</label>
      <textarea
        id="observacoes"
        v-model="form.observacoes"
        rows="3"
        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
      ></textarea>
    </div>

    <div class="flex justify-end space-x-3">
      <Link
        :href="`/patients/${props.patientId}/records`"
        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200"
      >
        Cancelar
      </Link>
      <button
        type="submit"
        :disabled="processing"
        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 disabled:opacity-50"
      >
        {{ processing ? 'Salvando...' : (props.recordId ? 'Atualizar' : 'Criar') }}
      </button>
    </div>
  </form>
</template>
