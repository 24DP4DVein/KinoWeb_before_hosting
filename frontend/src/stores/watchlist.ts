import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/services/api'
import { useAuthStore } from './auth'

export const useWatchlistStore = defineStore('watchlist', () => {
  const movieIds = ref<Set<number>>(new Set())

  async function fetch() {
    const { data } = await api.get('/watchlist')
    movieIds.value = new Set(data)
  }

  async function toggle(movieId: number) {
    const auth = useAuthStore()
    if (!auth.isLoggedIn) return

    if (movieIds.value.has(movieId)) {
      await api.delete(`/watchlist/${movieId}`)
      movieIds.value.delete(movieId)
    } else {
      await api.post(`/watchlist/${movieId}`)
      movieIds.value.add(movieId)
    }
  }

  function has(movieId: number) {
    return movieIds.value.has(movieId)
  }

  function clear() {
    movieIds.value = new Set()
  }

  return { movieIds, fetch, toggle, has, clear }
})
