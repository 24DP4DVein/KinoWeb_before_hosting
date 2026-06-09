<template>
  <v-app>
    <Navbar @open-auth="authDialog = true" />
    <v-main>
      <router-view />
    </v-main>
    <AuthDialog v-model="authDialog" />
  </v-app>
</template>

<script setup lang="ts">
import { ref, watch, onMounted } from 'vue'
import Navbar from '@/components/Navbar.vue'
import AuthDialog from '@/components/AuthDialog.vue'
import { useAuthStore } from '@/stores/auth'
import { useMoviesStore } from '@/stores/movies'
import { useWatchlistStore } from '@/stores/watchlist'
import { useRatingsStore } from '@/stores/ratings'
import { useNotesStore } from '@/stores/notes'

const authDialog = ref(false)
const authStore = useAuthStore()
const moviesStore = useMoviesStore()
const watchlistStore = useWatchlistStore()
const ratingsStore = useRatingsStore()
const notesStore = useNotesStore()

onMounted(async () => {
  authStore.init()
  await moviesStore.fetchMovies()
  if (authStore.isLoggedIn) {
    await Promise.all([watchlistStore.fetch(), ratingsStore.fetch(), notesStore.fetch()])
  }
})

watch(
  () => authStore.isLoggedIn,
  async (loggedIn) => {
    if (loggedIn) {
      await Promise.all([watchlistStore.fetch(), ratingsStore.fetch(), notesStore.fetch()])
    } else {
      watchlistStore.clear()
      ratingsStore.clear()
      notesStore.clear()
    }
  },
)
</script>
