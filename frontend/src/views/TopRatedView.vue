<template>
  <v-container>
    <h1 class="text-h5 font-weight-bold mb-1">Top Rated</h1>
    <p class="text-medium-emphasis mb-6">Movies with IMDb rating of 8.5 or higher</p>

    <v-row>
      <v-col
        v-for="movie in topRated"
        :key="movie.id"
        cols="6" sm="4" md="3" lg="2"
      >
        <MovieCard :movie="movie" @click="openMovie" />
      </v-col>
    </v-row>

    <MovieModal v-model="modalOpen" :movie="selectedMovie" />
  </v-container>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import type { Movie } from '@/types'
import { useMoviesStore } from '@/stores/movies'
import MovieCard from '@/components/MovieCard.vue'
import MovieModal from '@/components/MovieModal.vue'

const moviesStore = useMoviesStore()
const modalOpen = ref(false)
const selectedMovie = ref<Movie | null>(null)

const topRated = computed(() =>
  moviesStore.movies
    .filter((m) => m.rating >= 8.5)
    .sort((a, b) => b.rating - a.rating),
)

function openMovie(movie: Movie) {
  selectedMovie.value = movie
  modalOpen.value = true
}
</script>
