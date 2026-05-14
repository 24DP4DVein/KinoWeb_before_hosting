<template>
  <v-dialog v-model="isOpen" max-width="420">
    <v-card>
      <v-tabs v-model="tab" color="primary" grow>
        <v-tab value="login">Sign In</v-tab>
        <v-tab value="register">Register</v-tab>
      </v-tabs>

      <v-card-text>
        <v-alert v-if="error" type="error" density="compact" class="mb-4">{{ error }}</v-alert>

        <v-form v-if="tab === 'login'" @submit.prevent="doLogin">
          <v-text-field v-model="email" label="Email" type="email" class="mb-2" />
          <v-text-field v-model="password" label="Password" type="password" class="mb-4" />
          <v-btn type="submit" color="primary" block :loading="loading">Sign In</v-btn>
        </v-form>

        <v-form v-else @submit.prevent="doRegister">
          <v-text-field v-model="name" label="Username" class="mb-2" />
          <v-text-field v-model="email" label="Email" type="email" class="mb-2" />
          <v-text-field v-model="password" label="Password (min 6)" type="password" class="mb-4" />
          <v-btn type="submit" color="primary" block :loading="loading">Create Account</v-btn>
        </v-form>
      </v-card-text>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { ref, computed, watch } from 'vue'
import { useAuthStore } from '@/stores/auth'

const props = defineProps<{ modelValue: boolean }>()
const emit  = defineEmits<{ 'update:modelValue': [v: boolean] }>()

const isOpen = computed({
  get: () => props.modelValue,
  set: (v) => emit('update:modelValue', v),
})

const authStore = useAuthStore()
const tab       = ref('login')
const name      = ref('')
const email     = ref('')
const password  = ref('')
const loading   = ref(false)
const error     = ref('')

watch(isOpen, (open) => {
  if (!open) return
  error.value    = ''
  name.value     = ''
  email.value    = ''
  password.value = ''
})

async function doLogin() {
  error.value   = ''
  loading.value = true
  try {
    await authStore.login(email.value, password.value)
    isOpen.value = false
  } catch (e: any) {
    error.value = e.response?.data?.message ?? 'Login failed'
  } finally {
    loading.value = false
  }
}

async function doRegister() {
  error.value   = ''
  loading.value = true
  try {
    await authStore.register(name.value, email.value, password.value)
    isOpen.value = false
  } catch (e: any) {
    error.value = e.response?.data?.message ?? 'Registration failed'
  } finally {
    loading.value = false
  }
}
</script>
