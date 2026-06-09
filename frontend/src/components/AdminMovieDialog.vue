<template>
  <v-dialog v-model="isOpen" max-width="700" scrollable persistent>
    <v-card>
      <v-card-title class="pt-4 px-6">
        {{ movie ? 'Edit Movie' : 'Add Movie' }}
      </v-card-title>

      <v-card-text class="px-6">
        <v-alert
          v-if="error"
          type="error"
          variant="tonal"
          density="compact"
          class="mb-4"
          closable
          @click:close="error = null"
        >{{ error }}</v-alert>
        <v-form ref="formRef" @submit.prevent="submit">
          <v-row dense>
            <v-col cols="12" sm="8">
              <v-text-field
                v-model="form.title"
                label="Title"
                :rules="[required]"
                density="compact"
              />
            </v-col>
            <v-col cols="6" sm="2">
              <v-text-field
                v-model.number="form.year"
                label="Year"
                type="number"
                :rules="[required]"
                density="compact"
              />
            </v-col>
            <v-col cols="6" sm="2">
              <v-text-field
                v-model.number="form.rating"
                label="Rating"
                type="number"
                step="0.1"
                min="0"
                max="10"
                :rules="[required]"
                density="compact"
              />
            </v-col>

            <v-col cols="12" sm="4">
              <v-text-field
                v-model="form.duration"
                label="Duration (e.g. 2h 28m)"
                :rules="[required]"
                density="compact"
              />
            </v-col>
            <v-col cols="12" sm="8">
              <v-combobox
                v-model="form.genres"
                :items="genreOptions"
                label="Genres"
                multiple
                chips
                closable-chips
                :rules="[requiredArray]"
                density="compact"
              />
            </v-col>

            <v-col cols="12">
              <v-combobox
                v-model="form.cast"
                label="Cast (enter names)"
                multiple
                chips
                closable-chips
                :rules="[requiredArray]"
                density="compact"
                hint="Press Enter after each name"
                persistent-hint
              />
            </v-col>

            <v-col cols="12">
              <v-textarea
                v-model="form.description"
                label="Description"
                rows="4"
                :rules="[required]"
                density="compact"
                no-resize
              />
            </v-col>

            <v-col cols="12">
              <v-text-field
                v-model="form.posterGradient"
                label="Poster Gradient (CSS)"
                :rules="[required]"
                density="compact"
                hint="e.g. linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%)"
                persistent-hint
              />
              <div
                class="mt-2 rounded"
                :style="{ background: form.posterGradient, height: '40px' }"
              />
            </v-col>

            <v-col cols="12">
              <v-file-input
                v-model="posterFile"
                label="Poster Image (optional, replaces gradient)"
                accept="image/*"
                prepend-icon="mdi-image"
                density="compact"
                clearable
                :hint="movie?.has_poster ? 'Current poster will be replaced' : ''"
                persistent-hint
              />
              <v-img
                v-if="posterPreview"
                :src="posterPreview"
                height="120"
                class="mt-2 rounded"
                cover
              />
              <v-img
                v-else-if="movie?.has_poster && !posterFile?.length"
                :src="posterUrl(movie.id)"
                height="120"
                class="mt-2 rounded"
                cover
              />
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>

      <v-card-actions class="px-6 pb-4">
        <v-spacer />
        <v-btn variant="text" @click="close">Cancel</v-btn>
        <v-btn
          color="primary"
          variant="flat"
          :loading="saving"
          @click="submit"
        >
          {{ movie ? 'Save' : 'Create' }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { ref, watch, computed } from 'vue'
import type { Movie } from '@/types'
import api, { posterUrl } from '@/services/api'

const props = defineProps<{
  modelValue: boolean
  movie: Movie | null
}>()
const emit = defineEmits<{
  'update:modelValue': [v: boolean]
  saved: []
}>()

const isOpen = computed({
  get: () => props.modelValue,
  set: (v) => emit('update:modelValue', v),
})

const formRef = ref()
const saving = ref(false)
const error = ref<string | null>(null)
const posterFile = ref<File[]>([])

const genreOptions = ['Action', 'Drama', 'Comedy', 'Sci-Fi', 'Thriller', 'Adventure', 'Fantasy', 'Crime', 'Horror', 'Romance', 'Animation']

const emptyForm = () => ({
  title: '',
  year: new Date().getFullYear(),
  rating: 7.0,
  genres: [] as string[],
  duration: '',
  description: '',
  cast: [] as string[],
  posterGradient: 'linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%)',
})

const form = ref(emptyForm())

const posterPreview = computed(() => {
  const file = Array.isArray(posterFile.value) ? posterFile.value[0] : posterFile.value
  if (!file) return null
  return URL.createObjectURL(file)
})

watch(
  () => props.movie,
  (m) => {
    if (m) {
      form.value = {
        title: m.title,
        year: m.year,
        rating: m.rating,
        genres: [...m.genres],
        duration: m.duration,
        description: m.description,
        cast: [...m.cast],
        posterGradient: m.posterGradient,
      }
    } else {
      form.value = emptyForm()
    }
    posterFile.value = []
  },
  { immediate: true },
)

const required = (v: string | number) => !!v || 'Required'
const requiredArray = (v: string[]) => (v && v.length > 0) || 'At least one required'

async function submit() {
  const { valid } = await formRef.value.validate()
  if (!valid) return

  saving.value = true
  error.value = null
  try {
    let saved: Movie
    if (props.movie) {
      const { data } = await api.put(`/admin/movies/${props.movie.id}`, form.value)
      saved = data
    } else {
      const { data } = await api.post('/admin/movies', form.value)
      saved = data
    }

    const file = Array.isArray(posterFile.value) ? posterFile.value[0] : posterFile.value
    if (file) {
      const fd = new FormData()
      fd.append('poster', file)
      await api.post(`/admin/movies/${saved.id}/poster`, fd, {
        headers: { 'Content-Type': 'multipart/form-data' },
      })
    }

    emit('saved')
    close()
  } catch {
    error.value = 'Something went wrong. Please try again.'
  } finally {
    saving.value = false
  }
}

function close() {
  error.value = null
  isOpen.value = false
}
</script>
