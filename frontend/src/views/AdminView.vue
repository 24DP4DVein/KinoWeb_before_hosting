<template>
  <v-container class="py-6">
    <div class="d-flex align-center mb-6">
      <div>
        <div class="text-h5 font-weight-bold">Admin Panel</div>
        <div class="text-caption text-medium-emphasis">Manage movies and view statistics</div>
      </div>
      <v-spacer />
      <v-btn color="primary" prepend-icon="mdi-plus" @click="openCreate">Add Movie</v-btn>
    </div>

    <v-tabs v-model="tab" class="mb-4">
      <v-tab value="movies">Movies</v-tab>
      <v-tab value="stats" @click="loadStats">Statistics</v-tab>
    </v-tabs>

    <v-window v-model="tab">
      <v-window-item value="movies">
        <v-alert v-if="error" type="error" class="mb-4">{{ error }}</v-alert>

        <v-data-table
          :headers="movieHeaders"
          :items="movies"
          :loading="loading"
          items-per-page="20"
          class="elevation-1 rounded"
        >
          <template #item.poster="{ item }">
            <div
              class="poster-thumb rounded"
              :style="item.has_poster ? {} : { background: item.posterGradient }"
            >
              <v-img
                v-if="item.has_poster"
                :src="posterUrl(item.id)"
                cover
                height="48"
                width="36"
              />
            </div>
          </template>

          <template #item.genres="{ item }">
            <div class="d-flex flex-wrap ga-1 py-1">
              <v-chip v-for="g in item.genres" :key="g" size="x-small" variant="tonal">{{ g }}</v-chip>
            </div>
          </template>

          <template #item.watchlist_entries_count="{ item }">
            <v-chip size="small" color="primary" variant="tonal">
              {{ item.watchlist_entries_count ?? 0 }}
            </v-chip>
          </template>

          <template #item.actions="{ item }">
            <div class="d-flex ga-1">
              <v-btn icon="mdi-pencil" size="x-small" variant="text" @click="openEdit(item)" />
              <v-btn icon="mdi-delete" size="x-small" variant="text" color="error" @click="confirmDelete(item)" />
            </div>
          </template>
        </v-data-table>
      </v-window-item>

      <v-window-item value="stats">
        <v-alert v-if="statsError" type="error" class="mb-4">{{ statsError }}</v-alert>

        <v-data-table
          :headers="statsHeaders"
          :items="stats"
          :loading="statsLoading"
          items-per-page="20"
          class="elevation-1 rounded"
        >
          <template #item.watchlist_count="{ item }">
            <v-chip size="small" color="primary" variant="tonal">{{ item.watchlist_count }}</v-chip>
          </template>

          <template #item.ratings_count="{ item }">
            <v-chip size="small" color="secondary" variant="tonal">{{ item.ratings_count }}</v-chip>
          </template>

          <template #item.avg_user_rating="{ item }">
            <span v-if="item.avg_user_rating">
              <v-icon size="14" color="primary">mdi-star</v-icon>
              {{ item.avg_user_rating }}
            </span>
            <span v-else class="text-medium-emphasis">-</span>
          </template>
        </v-data-table>
      </v-window-item>
    </v-window>

    <AdminMovieDialog
      v-model="dialogOpen"
      :movie="editingMovie"
      @saved="onSaved"
    />

    <v-dialog v-model="deleteDialog" max-width="400">
      <v-card>
        <v-card-title class="pt-4">Delete Movie</v-card-title>
        <v-card-text>
          Are you sure you want to delete <strong>{{ deletingMovie?.title }}</strong>?
          This cannot be undone.
        </v-card-text>
        <v-card-actions>
          <v-spacer />
          <v-btn variant="text" @click="deleteDialog = false">Cancel</v-btn>
          <v-btn color="error" variant="flat" :loading="deleting" @click="deleteMovie">Delete</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-container>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import type { Movie } from '@/types'
import api, { posterUrl } from '@/services/api'
import AdminMovieDialog from '@/components/AdminMovieDialog.vue'
import { useMoviesStore } from '@/stores/movies'

const moviesStore = useMoviesStore()

const tab = ref('movies')
const loading = ref(false)
const error = ref<string | null>(null)
const movies = ref<Movie[]>([])

const statsLoading = ref(false)
const statsError = ref<string | null>(null)
const stats = ref<any[]>([])

const dialogOpen = ref(false)
const editingMovie = ref<Movie | null>(null)

const deleteDialog = ref(false)
const deletingMovie = ref<Movie | null>(null)
const deleting = ref(false)

const movieHeaders = [
  { title: '', key: 'poster', sortable: false, width: 52 },
  { title: 'Title', key: 'title' },
  { title: 'Year', key: 'year', width: 80 },
  { title: 'Rating', key: 'rating', width: 90 },
  { title: 'Genres', key: 'genres', sortable: false },
  { title: 'Watchlist', key: 'watchlist_entries_count', width: 110 },
  { title: '', key: 'actions', sortable: false, width: 90 },
]

const statsHeaders = [
  { title: 'Title', key: 'title' },
  { title: 'Year', key: 'year', width: 80 },
  { title: 'IMDb', key: 'rating', width: 80 },
  { title: 'In Watchlists', key: 'watchlist_count', width: 130 },
  { title: 'Rated by users', key: 'ratings_count', width: 140 },
  { title: 'Avg User Rating', key: 'avg_user_rating', width: 150 },
]

async function loadMovies() {
  loading.value = true
  error.value = null
  try {
    const { data } = await api.get('/admin/movies')
    movies.value = data
  } catch {
    error.value = 'Failed to load movies'
  } finally {
    loading.value = false
  }
}

async function loadStats() {
  if (stats.value.length) return
  statsLoading.value = true
  statsError.value = null
  try {
    const { data } = await api.get('/admin/stats')
    stats.value = data
  } catch {
    statsError.value = 'Failed to load statistics'
  } finally {
    statsLoading.value = false
  }
}

function openCreate() {
  editingMovie.value = null
  dialogOpen.value = true
}

function openEdit(movie: Movie) {
  editingMovie.value = movie
  dialogOpen.value = true
}

function confirmDelete(movie: Movie) {
  deletingMovie.value = movie
  deleteDialog.value = true
}

async function deleteMovie() {
  if (!deletingMovie.value) return
  deleting.value = true
  error.value = null

  try {
    await api.delete(`/admin/movies/${deletingMovie.value.id}`)
    movies.value = movies.value.filter((m) => m.id !== deletingMovie.value!.id)
    stats.value = []
    deleteDialog.value = false
    await moviesStore.fetchMovies()
  } catch {
    error.value = 'Failed to delete movie'
  } finally {
    deleting.value = false
  }
}

async function onSaved() {
  stats.value = []
  await Promise.all([loadMovies(), moviesStore.fetchMovies()])
}

onMounted(loadMovies)
</script>

<style scoped>
.poster-thumb {
  width: 36px;
  height: 48px;
  overflow: hidden;
}
</style>
