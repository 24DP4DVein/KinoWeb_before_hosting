<template>
  <v-container>
    <h1 class="text-h5 font-weight-bold mb-6">My Watchlist</h1>

    <v-row v-if="watchlistMovies.length">
      <v-col
        v-for="movie in watchlistMovies"
        :key="movie.id"
        cols="6" sm="4" md="3" lg="2"
      >
        <MovieCard :movie="movie" @click="openMovie" />
      </v-col>
    </v-row>

    <div v-else class="text-center py-16 text-medium-emphasis">
      <v-icon size="64" class="mb-4">mdi-bookmark-outline</v-icon>
      <p class="text-body-1">Your watchlist is empty</p>
      <v-btn variant="text" color="primary" to="/" class="mt-2">Browse Movies</v-btn>
    </div>

    <MovieModal v-model="modalOpen" :movie="selectedMovie" />
  </v-container>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import type { Movie } from '@/types'
import { useMoviesStore } from '@/stores/movies'
import { useWatchlistStore } from '@/stores/watchlist'
import MovieCard from '@/components/MovieCard.vue'
import MovieModal from '@/components/MovieModal.vue'

const moviesStore = useMoviesStore()
const watchlistStore = useWatchlistStore()
const modalOpen = ref(false)
const selectedMovie = ref<Movie | null>(null)

const watchlistMovies = computed(() =>
  moviesStore.movies.filter((m) => watchlistStore.has(m.id)),
)

function openMovie(movie: Movie) {
  selectedMovie.value = movie
  modalOpen.value = true
}
</script>
