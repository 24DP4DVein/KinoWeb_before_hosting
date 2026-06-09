import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/services/api'
import { useAuthStore } from './auth'

export const useRatingsStore = defineStore('ratings', () => {
  const ratings = ref<Record<number, number>>({})

  async function fetch() {
    try {
      const { data } = await api.get('/ratings')
      ratings.value = data
    } catch {
      // keep existing state on failure
    }
  }

  async function rate(movieId: number, value: number) {
    const auth = useAuthStore()
    if (!auth.isLoggedIn) return
    const previous = ratings.value[movieId]
    ratings.value[movieId] = value
    try {
      await api.post(`/ratings/${movieId}`, { rating: value })
    } catch {
      if (previous !== undefined) {
        ratings.value[movieId] = previous
      } else {
        delete ratings.value[movieId]
      }
    }
  }

  function get(movieId: number): number | null {
    return ratings.value[movieId] ?? null
  }

  function clear() {
    ratings.value = {}
  }

  return { ratings, fetch, rate, get, clear }
})
