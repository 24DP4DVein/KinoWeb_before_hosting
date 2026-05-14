import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/services/api'
import { useAuthStore } from './auth'

export const useRatingsStore = defineStore('ratings', () => {
  const ratings = ref<Record<number, number>>({})

  async function fetch() {
    const { data } = await api.get('/ratings')
    ratings.value = data
  }

  async function rate(movieId: number, value: number) {
    const auth = useAuthStore()
    if (!auth.isLoggedIn) return
    await api.post(`/ratings/${movieId}`, { rating: value })
    ratings.value[movieId] = value
  }

  function get(movieId: number): number | null {
    return ratings.value[movieId] ?? null
  }

  function clear() {
    ratings.value = {}
  }

  return { ratings, fetch, rate, get, clear }
})
