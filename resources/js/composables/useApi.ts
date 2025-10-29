import axios from 'axios'
import { ref } from 'vue'

const api = axios.create({
  baseURL: '/api'
})

api.interceptors.request.use((config) => {
  config.withCredentials = true
  return config
})

export function useApi() {
  const loading = ref(false)
  const error = ref(null)

  const fetchPatients = async () => {
    loading.value = true
    try {
      const response = await api.get('/patients')
      return response.data
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Erro ao carregar pacientes'
      throw err
    } finally {
      loading.value = false
    }
  }

  const fetchPatient = async (id: number) => {
    loading.value = true
    try {
      const response = await api.get(`/patients/${id}`)
      return response.data
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Erro ao carregar paciente'
      throw err
    } finally {
      loading.value = false
    }
  }

  const createPatient = async (data: any) => {
    loading.value = true
    try {
      const response = await api.post('/patients', data)
      return response.data
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Erro ao criar paciente'
      throw err
    } finally {
      loading.value = false
    }
  }

  const updatePatient = async (id: number, data: any) => {
    loading.value = true
    try {
      const response = await api.put(`/patients/${id}`, data)
      return response.data
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Erro ao atualizar paciente'
      throw err
    } finally {
      loading.value = false
    }
  }

  const deletePatient = async (id: number) => {
    loading.value = true
    try {
      await api.delete(`/patients/${id}`)
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Erro ao excluir paciente'
      throw err
    } finally {
      loading.value = false
    }
  }

  const fetchRecords = async (patientId: number) => {
    loading.value = true
    try {
      const response = await api.get(`/patients/${patientId}/records`)
      return response.data
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Erro ao carregar registros'
      throw err
    } finally {
      loading.value = false
    }
  }

  const createRecord = async (patientId: number, data: any) => {
    loading.value = true
    try {
      const response = await api.post(`/patients/${patientId}/records`, data)
      return response.data
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Erro ao criar registro'
      throw err
    } finally {
      loading.value = false
    }
  }

  const updateRecord = async (patientId: number, recordId: number, data: any) => {
    loading.value = true
    try {
      const response = await api.put(`/patients/${patientId}/records/${recordId}`, data)
      return response.data
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Erro ao atualizar registro'
      throw err
    } finally {
      loading.value = false
    }
  }

  const deleteRecord = async (patientId: number, recordId: number) => {
    loading.value = true
    try {
      await api.delete(`/patients/${patientId}/records/${recordId}`)
    } catch (err: any) {
      error.value = err.response?.data?.message || 'Erro ao excluir registro'
      throw err
    } finally {
      loading.value = false
    }
  }

  return {
    loading,
    error,
    fetchPatients,
    fetchPatient,
    createPatient,
    updatePatient,
    deletePatient,
    fetchRecords,
    createRecord,
    updateRecord,
    deleteRecord
  }
}