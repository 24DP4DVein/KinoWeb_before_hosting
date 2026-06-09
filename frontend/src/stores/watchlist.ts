import { defineStore } from 'pinia'
import { ref } from 'vue'
import api from '@/services/api'
import { useAuthStore } from './auth'

export const useWatchlistStore = defineStore('watchlist', () => {
  const movieIds = ref<Set<number>>(new Set())

  async function fetch() {
    try {
      const { data } = await api.get('/watchlist')
      movieIds.value = new Set(data)
    } catch {
      // keep existing state on failure
    }
  }

  async function toggle(movieId: number) {
    const auth = useAuthStore()
    if (!auth.isLoggedIn) return

    if (movieIds.value.has(movieId)) {
      movieIds.value.delete(movieId)
      try {
        await api.delete(`/watchlist/${movieId}`)
      } catch {
        movieIds.value.add(movieId)
      }
    } else {
      movieIds.value.add(movieId)
      try {
        await api.post(`/watchlist/${movieId}`)
      } catch {
        movieIds.value.delete(movieId)
      }
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
