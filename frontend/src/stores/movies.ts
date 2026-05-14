import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import api from '@/services/api'
import type { Movie, SortOption } from '@/types'

export const useMoviesStore = defineStore('movies', () => {
  const movies  = ref<Movie[]>([])
  const loading = ref(false)
  const error   = ref<string | null>(null)

  const search = ref('')
  const genre  = ref('All')
  const sort   = ref<SortOption>('rating_desc')

  async function fetchMovies() {
    loading.value = true
    error.value   = null
    try {
      const { data } = await api.get('/movies')
      movies.value = data
    } catch {
      error.value = 'Failed to load movies'
    } finally {
      loading.value = false
    }
  }

  const filtered = computed(() => {
    let list = [...movies.value]

    if (search.value.trim()) {
      const q = search.value.toLowerCase()
      list = list.filter((m) => m.title.toLowerCase().includes(q))
    }

    if (genre.value !== 'All') {
      list = list.filter((m) => m.genres.includes(genre.value))
    }

    if (sort.value === 'rating_desc') {
      list.sort((a, b) => b.rating - a.rating)
    } else if (sort.value === 'year_desc') {
      list.sort((a, b) => b.year - a.year)
    } else {
      list.sort((a, b) => a.title.localeCompare(b.title))
    }

    return list
  })

  return { movies, loading, error, search, genre, sort, filtered, fetchMovies }
})
