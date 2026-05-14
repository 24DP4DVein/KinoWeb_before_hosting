<template>
  <div>
    <Hero @open-info="infoOpen = true" @open-movie="openMovieById" />

    <v-container>
      <!-- Filters -->
      <v-row align="center" class="mb-2">
        <v-col cols="12" sm="8">
          <v-chip-group v-model="moviesStore.genre" mandatory selected-class="text-primary">
            <v-chip
              v-for="g in genres"
              :key="g"
              :value="g"
              variant="tonal"
              size="small"
            >{{ g }}</v-chip>
          </v-chip-group>
        </v-col>
        <v-col cols="12" sm="4">
          <v-select
            v-model="moviesStore.sort"
            :items="sortOptions"
            item-title="label"
            item-value="value"
            label="Sort by"
            hide-details
            density="compact"
          />
        </v-col>
      </v-row>

      <div class="text-caption text-medium-emphasis mb-3">
        {{ moviesStore.filtered.length }} movies
      </div>

      <!-- Skeleton loader -->
      <v-row v-if="moviesStore.loading">
        <v-col v-for="n in 12" :key="n" cols="6" sm="4" md="3" lg="2">
          <v-skeleton-loader type="card" />
        </v-col>
      </v-row>

      <!-- Error -->
      <v-alert v-else-if="moviesStore.error" type="error" class="mb-4">
        {{ moviesStore.error }}
      </v-alert>

      <!-- Grid -->
      <v-row v-else>
        <v-col
          v-for="movie in moviesStore.filtered"
          :key="movie.id"
          cols="6" sm="4" md="3" lg="2"
        >
          <MovieCard :movie="movie" @click="openMovie" />
        </v-col>
        <v-col v-if="!moviesStore.filtered.length" cols="12" class="text-center py-12 text-medium-emphasis">
          No movies found
        </v-col>
      </v-row>
    </v-container>

    <MovieModal v-model="modalOpen" :movie="selectedMovie" />
    <InfoModal v-model="infoOpen" />
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import type { Movie } from '@/types'
import { useMoviesStore } from '@/stores/movies'
import Hero from '@/components/Hero.vue'
import MovieCard from '@/components/MovieCard.vue'
import MovieModal from '@/components/MovieModal.vue'
import InfoModal from '@/components/InfoModal.vue'

const moviesStore  = useMoviesStore()
const modalOpen    = ref(false)
const infoOpen     = ref(false)
const selectedMovie = ref<Movie | null>(null)

const genres = ['All', 'Action', 'Drama', 'Comedy', 'Sci-Fi', 'Thriller', 'Adventure', 'Fantasy', 'Crime']

const sortOptions = [
  { label: 'Rating (High to Low)', value: 'rating_desc' },
  { label: 'Year (New to Old)',     value: 'year_desc' },
  { label: 'Title (A–Z)',           value: 'title_asc' },
]

function openMovie(movie: Movie) {
  selectedMovie.value = movie
  modalOpen.value     = true
}

function openMovieById(id: number) {
  const movie = moviesStore.movies.find((m) => m.id === id)
  if (movie) openMovie(movie)
}
</script>
