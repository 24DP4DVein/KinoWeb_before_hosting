<template>
  <div class="hero-section py-16 px-4 text-center">
    <h1 class="text-h3 text-sm-h2 font-weight-bold mb-4">
      Explore <span class="text-primary">Movies</span>
    </h1>
    <p class="text-body-1 text-medium-emphasis mb-8 mx-auto" style="max-width: 500px">
      Discover, rate, and curate your personal movie collection.
    </p>
    <div class="d-flex ga-3 justify-center flex-wrap">
      <v-btn color="primary" size="large" prepend-icon="mdi-shuffle" @click="randomMovie">
        Random Movie
      </v-btn>
      <v-btn variant="outlined" size="large" @click="$emit('open-info')">
        Learn More
      </v-btn>
    </div>
  </div>
</template>

<script setup lang="ts">
import { useMoviesStore } from '@/stores/movies'

const emit = defineEmits<{ 'open-info': []; 'open-movie': [id: number] }>()
const moviesStore = useMoviesStore()

function randomMovie() {
  const movies = moviesStore.movies
  if (!movies.length) return
  const movie = movies[Math.floor(Math.random() * movies.length)]
  emit('open-movie', movie.id)
}
</script>

<style scoped>
.hero-section {
  background: linear-gradient(180deg, #1e293b 0%, transparent 100%);
}
</style>
