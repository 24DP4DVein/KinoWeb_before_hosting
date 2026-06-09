<template>
  <v-dialog v-model="isOpen" max-width="480">
    <v-card>
      <v-card-title class="text-h5 pa-4">About KinoWEB</v-card-title>
      <v-card-text>
        <p class="text-body-2 mb-4">
          A full-stack movie app built with Vue 3, Vuetify, and Laravel.
        </p>

        <v-row dense>
          <v-col v-for="feature in features" :key="feature.title" cols="12">
            <v-card variant="tonal" class="pa-1">
              <v-card-text class="py-2">
                <div class="d-flex align-center ga-2 mb-1">
                  <v-icon :color="feature.color" size="20">{{ feature.icon }}</v-icon>
                  <span class="font-weight-bold text-body-2">{{ feature.title }}</span>
                </div>
                <p class="text-caption text-medium-emphasis mb-0">{{ feature.description }}</p>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-card-text>

      <v-card-actions>
        <v-spacer />
        <v-btn @click="isOpen = false">Close</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps<{ modelValue: boolean }>()
const emit = defineEmits<{ 'update:modelValue': [v: boolean] }>()

const isOpen = computed({
  get: () => props.modelValue,
  set: (v) => emit('update:modelValue', v),
})

const features = [
  {
    icon: 'mdi-database',
    color: 'primary',
    title: 'MySQL Database',
    description: 'Movies, watchlists, ratings, and notes are stored through Laravel Eloquent.',
  },
  {
    icon: 'mdi-shield-lock',
    color: 'success',
    title: 'Secure Auth',
    description: 'Laravel Sanctum handles token-based authentication.',
  },
  {
    icon: 'mdi-lightning-bolt',
    color: 'warning',
    title: 'Vue 3 + Vuetify',
    description: 'A simple responsive interface built with Vuetify components.',
  },
]
</script>
