<template>
  <v-card class="h-100" style="cursor: pointer" @click="$emit('click', movie)">
    <div class="movie-poster" :style="movie.has_poster ? {} : { background: movie.posterGradient }">
      <v-img
        v-if="movie.has_poster"
        :src="posterUrl(movie.id)"
        cover
        height="200"
      />
      <v-btn
        :icon="inWatchlist ? 'mdi-bookmark' : 'mdi-bookmark-outline'"
        :color="inWatchlist ? 'primary' : 'white'"
        variant="text"
        size="small"
        class="bookmark-btn"
        :disabled="!authStore.isLoggedIn"
        @click.stop="watchlistStore.toggle(movie.id)"
      />
    </div>

    <v-card-text class="pa-3">
      <div class="text-subtitle-2 font-weight-bold text-truncate mb-1">{{ movie.title }}</div>
      <div class="text-caption text-medium-emphasis mb-2">{{ movie.year }} · {{ movie.duration }}</div>

      <div class="d-flex flex-wrap ga-1 mb-2">
        <v-chip v-for="g in movie.genres.slice(0, 2)" :key="g" size="x-small" variant="tonal">
          {{ g }}
        </v-chip>
      </div>

      <div class="d-flex align-center ga-1">
        <template v-if="userRating">
          <v-icon size="14" color="primary">mdi-star</v-icon>
          <span class="text-caption text-primary font-weight-bold">{{ userRating }}/10</span>
        </template>
        <template v-else>
          <v-icon size="14" color="amber">mdi-star</v-icon>
          <span class="text-caption">{{ movie.rating }}</span>
        </template>
      </div>
    </v-card-text>
  </v-card>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import type { Movie } from '@/types'
import { posterUrl } from '@/services/api'
import { useAuthStore } from '@/stores/auth'
import { useWatchlistStore } from '@/stores/watchlist'
import { useRatingsStore } from '@/stores/ratings'

const props = defineProps<{ movie: Movie }>()
defineEmits<{ click: [movie: Movie] }>()

const authStore = useAuthStore()
const watchlistStore = useWatchlistStore()
const ratingsStore = useRatingsStore()

const inWatchlist = computed(() => watchlistStore.has(props.movie.id))
const userRating = computed(() => ratingsStore.get(props.movie.id))
</script>

<style scoped>
.movie-poster {
  height: 200px;
  position: relative;
}
.bookmark-btn {
  position: absolute;
  top: 8px;
  right: 8px;
}
</style>
