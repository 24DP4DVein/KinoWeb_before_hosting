import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/services/api'

export const useNotesStore = defineStore('notes', () => {
  const notes = ref<Record<number, string>>({})

  async function fetch() {
    try {
      const { data } = await api.get('/notes')
      notes.value = data
    } catch {
      // keep existing state on failure
    }
  }

  function get(movieId: number): string {
    return notes.value[movieId] ?? ''
  }

  async function save(movieId: number, content: string) {
    if (!content.trim()) {
      await remove(movieId)
      return
    }
    await api.post(`/notes/${movieId}`, { content })
    notes.value = { ...notes.value, [movieId]: content }
  }

  async function remove(movieId: number) {
    await api.delete(`/notes/${movieId}`)
    const updated = { ...notes.value }
    delete updated[movieId]
    notes.value = updated
  }

  function clear() {
    notes.value = {}
  }

  return { notes, fetch, get, save, remove, clear }
})
