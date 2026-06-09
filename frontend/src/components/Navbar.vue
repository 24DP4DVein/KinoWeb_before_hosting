<template>
  <v-app-bar color="surface" elevation="2">
    <v-app-bar-nav-icon class="d-flex d-sm-none" @click="drawer = true" />

    <v-app-bar-title class="flex-shrink-0" style="min-width: fit-content">
      <router-link to="/" class="text-decoration-none text-primary font-weight-bold text-h6">
        KinoWEB
      </router-link>
    </v-app-bar-title>

    <div class="d-none d-sm-flex flex-grow-1 mx-3" style="max-width: 300px">
      <v-text-field
        v-model="moviesStore.search"
        prepend-inner-icon="mdi-magnify"
        placeholder="Search movies..."
        hide-details
        density="compact"
        variant="outlined"
        rounded="lg"
        clearable
        style="width: 100%"
      />
    </div>

    <div class="d-none d-sm-flex align-center ga-1 mr-2">
      <v-btn variant="text" size="small" to="/">Home</v-btn>
      <v-btn variant="text" size="small" to="/top-rated">Top Rated</v-btn>
      <v-btn variant="text" size="small" to="/watchlist">Watchlist</v-btn>
      <v-btn v-if="authStore.isAdmin" variant="tonal" color="warning" size="small" to="/admin">Admin</v-btn>
    </div>

    <v-btn
      :icon="isDark ? 'mdi-white-balance-sunny' : 'mdi-weather-night'"
      size="small"
      variant="text"
      class="mr-1"
      @click="toggleTheme"
    />

    <template v-if="authStore.isLoggedIn">
      <v-chip
        class="mr-1"
        color="primary"
        size="small"
        style="cursor: pointer"
        @click="accountDialog = true"
      >
        {{ authStore.user?.name }}
      </v-chip>
      <v-btn icon="mdi-logout" size="small" class="mr-2" @click="logout" />
    </template>

    <template v-else>
      <v-btn color="primary" variant="tonal" size="small" class="mr-2" @click="$emit('open-auth')">
        Sign In
      </v-btn>
    </template>
  </v-app-bar>

  <v-navigation-drawer v-model="drawer" temporary>
    <v-list>
      <v-list-item class="py-3 px-4">
        <v-text-field
          v-model="moviesStore.search"
          prepend-inner-icon="mdi-magnify"
          placeholder="Search movies..."
          hide-details
          density="compact"
          variant="outlined"
          rounded="lg"
          clearable
        />
      </v-list-item>
      <v-divider />
      <v-list-item prepend-icon="mdi-home" to="/" @click="drawer = false">Home</v-list-item>
      <v-list-item prepend-icon="mdi-star" to="/top-rated" @click="drawer = false">Top Rated</v-list-item>
      <v-list-item prepend-icon="mdi-bookmark" to="/watchlist" @click="drawer = false">Watchlist</v-list-item>
      <v-list-item v-if="authStore.isAdmin" prepend-icon="mdi-shield-crown" to="/admin" @click="drawer = false">Admin Panel</v-list-item>
      <v-divider class="my-1" />
      <v-list-item
        v-if="authStore.isLoggedIn"
        prepend-icon="mdi-account-circle"
        @click="openAccount"
      >
        My Account
      </v-list-item>
      <v-list-item prepend-icon="mdi-theme-light-dark" @click="toggleTheme">
        {{ isDark ? 'Light Theme' : 'Dark Theme' }}
      </v-list-item>
      <v-list-item v-if="authStore.isLoggedIn" prepend-icon="mdi-logout" @click="logout">
        Sign Out
      </v-list-item>
    </v-list>
  </v-navigation-drawer>

  <AccountDialog v-model="accountDialog" />
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useTheme } from 'vuetify'
import { useAuthStore } from '@/stores/auth'
import { useMoviesStore } from '@/stores/movies'
import AccountDialog from '@/components/AccountDialog.vue'

defineEmits<{ 'open-auth': [] }>()

const drawer = ref(false)
const accountDialog = ref(false)
const authStore = useAuthStore()
const moviesStore = useMoviesStore()
const theme = useTheme()

const isDark = computed(() => theme.global.name.value === 'dark')

function toggleTheme() {
  const next = isDark.value ? 'light' : 'dark'
  theme.global.name.value = next
  localStorage.setItem('theme', next)
}

function openAccount() {
  drawer.value = false
  accountDialog.value = true
}

async function logout() {
  await authStore.logout()
}
</script>
