<template>
  <v-dialog v-model="isOpen" max-width="900" scrollable>
    <v-card v-if="movie">
      <div class="d-flex flex-column flex-sm-row">
        <!-- Poster -->
        <div
          class="movie-poster flex-shrink-0"
          :style="movie.has_poster ? {} : { background: movie.posterGradient }"
        >
          <v-img
            v-if="movie.has_poster"
            :src="`${apiUrl}/movies/${movie.id}/poster`"
            cover
            height="100%"
            width="220"
          />
        </div>

        <!-- Details -->
        <div class="flex-grow-1 overflow-auto">
          <v-card-title class="text-h5 pt-4 px-4 pb-1">{{ movie.title }}</v-card-title>
          <v-card-subtitle class="px-4 pb-2">{{ movie.year }} · {{ movie.duration }}</v-card-subtitle>

          <v-card-text>
            <!-- Ratings row -->
            <div class="d-flex align-center ga-3 mb-3">
              <div class="d-flex align-center ga-1">
                <v-icon color="amber" size="18">mdi-star</v-icon>
                <span class="font-weight-bold">{{ movie.rating }}</span>
                <span class="text-caption text-medium-emphasis">IMDb</span>
              </div>
              <template v-if="userRating">
                <v-divider vertical class="mx-1" style="height:16px" />
                <div class="d-flex align-center ga-1">
                  <v-icon color="primary" size="18">mdi-star</v-icon>
                  <span class="font-weight-bold text-primary">{{ userRating }}/10</span>
                  <span class="text-caption text-medium-emphasis">Your rating</span>
                </div>
              </template>
            </div>

            <!-- Genres -->
            <div class="d-flex flex-wrap ga-1 mb-3">
              <v-chip v-for="g in movie.genres" :key="g" size="small" variant="tonal">{{ g }}</v-chip>
            </div>

            <!-- Plot -->
            <p class="text-body-2 mb-3">{{ movie.description }}</p>

            <!-- Cast -->
            <div class="text-caption text-medium-emphasis mb-1">Cast</div>
            <p class="text-body-2 mb-4">{{ movie.cast.join(', ') }}</p>

            <!-- Rating widget -->
            <template v-if="authStore.isLoggedIn">
              <div class="text-caption text-medium-emphasis mb-2">Your Rating</div>
              <div class="d-flex flex-wrap ga-1 mb-4">
                <v-btn
                  v-for="n in 10"
                  :key="n"
                  :color="n === userRating ? 'primary' : 'default'"
                  :variant="n === userRating ? 'flat' : 'outlined'"
                  size="x-small"
                  min-width="32"
                  @click="ratingsStore.rate(movie.id, n)"
                >{{ n }}</v-btn>
              </div>
            </template>

            <!-- Personal note -->
            <template v-if="authStore.isLoggedIn">
              <v-divider class="mb-3" />
              <div class="d-flex align-center mb-2">
                <v-icon size="16" class="mr-1" color="secondary">mdi-note-text</v-icon>
                <span class="text-caption text-medium-emphasis">My Note</span>
                <v-spacer />
                <v-btn
                  v-if="notesStore.get(movie.id)"
                  size="x-small"
                  variant="text"
                  color="error"
                  prepend-icon="mdi-delete"
                  @click="deleteNote"
                >Delete</v-btn>
              </div>
              <v-textarea
                v-model="noteText"
                placeholder="Write a personal note about this movie..."
                rows="3"
                density="compact"
                variant="outlined"
                hide-details
                no-resize
                class="mb-2"
              />
              <div class="d-flex justify-end ga-2">
                <v-btn
                  v-if="noteText !== notesStore.get(movie.id)"
                  size="small"
                  variant="text"
                  @click="noteText = notesStore.get(movie.id)"
                >Cancel</v-btn>
                <v-btn
                  size="small"
                  color="secondary"
                  variant="tonal"
                  :disabled="noteText === notesStore.get(movie.id)"
                  :loading="savingNote"
                  @click="saveNote"
                >Save Note</v-btn>
              </div>
            </template>
          </v-card-text>

          <v-card-actions class="px-4 pb-4">
            <v-btn
              :color="inWatchlist ? 'error' : 'primary'"
              :variant="inWatchlist ? 'tonal' : 'flat'"
              :prepend-icon="inWatchlist ? 'mdi-bookmark-remove' : 'mdi-bookmark-plus'"
              :disabled="!authStore.isLoggedIn"
              @click="watchlistStore.toggle(movie.id)"
            >
              {{ inWatchlist ? 'Remove from Watchlist' : 'Add to Watchlist' }}
            </v-btn>
            <v-spacer />
            <v-btn variant="text" @click="isOpen = false">Close</v-btn>
          </v-card-actions>
        </div>
      </div>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import type { Movie } from '@/types'
import { useAuthStore } from '@/stores/auth'
import { useWatchlistStore } from '@/stores/watchlist'
import { useRatingsStore } from '@/stores/ratings'
import { useNotesStore } from '@/stores/notes'

const apiUrl = import.meta.env.VITE_API_URL as string || 'http://localhost:8000/api'

const props = defineProps<{ modelValue: boolean; movie: Movie | null }>()
const emit  = defineEmits<{ 'update:modelValue': [v: boolean] }>()

const isOpen = computed({
  get: () => props.modelValue,
  set: (v) => emit('update:modelValue', v),
})

const authStore      = useAuthStore()
const watchlistStore = useWatchlistStore()
const ratingsStore   = useRatingsStore()
const notesStore     = useNotesStore()

const inWatchlist = computed(() => (props.movie ? watchlistStore.has(props.movie.id) : false))
const userRating  = computed(() => (props.movie ? ratingsStore.get(props.movie.id) : null))

const noteText   = ref('')
const savingNote = ref(false)

watch(
  () => props.movie?.id,
  (id) => {
    noteText.value = id ? notesStore.get(id) : ''
  },
  { immediate: true },
)

watch(
  () => notesStore.notes,
  () => {
    if (props.movie) noteText.value = notesStore.get(props.movie.id)
  },
)

async function saveNote() {
  if (!props.movie) return
  savingNote.value = true
  try {
    await notesStore.save(props.movie.id, noteText.value)
  } finally {
    savingNote.value = false
  }
}

async function deleteNote() {
  if (!props.movie) return
  await notesStore.remove(props.movie.id)
  noteText.value = ''
}
</script>

<style scoped>
.movie-poster {
  width: 220px;
  min-height: 320px;
}
@media (max-width: 600px) {
  .movie-poster {
    width: 100%;
    min-height: 200px;
  }
}
</style>
