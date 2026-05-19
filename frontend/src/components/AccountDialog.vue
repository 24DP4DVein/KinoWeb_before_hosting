<template>
  <v-dialog v-model="isOpen" max-width="400">
    <v-card>
      <v-card-title class="pt-4 px-6 d-flex align-center">
        My Account
        <v-spacer />
        <v-btn icon="mdi-close" variant="text" size="small" @click="isOpen = false" />
      </v-card-title>

      <v-card-text class="px-6 pb-2">
        <div class="d-flex align-center mb-5">
          <v-avatar size="64" color="primary" class="mr-4 flex-shrink-0">
            <span class="text-h5 font-weight-bold text-on-primary">{{ initials }}</span>
          </v-avatar>
          <div class="overflow-hidden">
            <div class="text-h6 font-weight-bold text-truncate">{{ authStore.user?.name }}</div>
            <div class="text-body-2 text-medium-emphasis text-truncate">{{ authStore.user?.email }}</div>
            <v-chip v-if="authStore.isAdmin" size="x-small" color="warning" variant="tonal" class="mt-1">
              Admin
            </v-chip>
          </div>
        </div>

        <v-divider class="mb-4" />

        <v-alert type="error" variant="tonal" density="compact" class="text-body-2">
          Deleting your account is <strong>permanent</strong>. All your watchlist, ratings and notes will be lost.
        </v-alert>
      </v-card-text>

      <v-card-actions class="px-6 pb-4">
        <v-btn
          color="error"
          variant="tonal"
          prepend-icon="mdi-delete-forever"
          @click="confirmOpen = true"
        >
          Delete Account
        </v-btn>
        <v-spacer />
        <v-btn variant="text" @click="isOpen = false">Close</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>

  <v-dialog v-model="confirmOpen" max-width="380">
    <v-card>
      <v-card-title class="pt-4 px-6">Are you sure?</v-card-title>
      <v-card-text class="px-6">
        Your account <strong>{{ authStore.user?.email }}</strong> and all associated data will be permanently deleted.
      </v-card-text>
      <v-card-actions class="px-6 pb-4">
        <v-spacer />
        <v-btn variant="text" :disabled="deleting" @click="confirmOpen = false">Cancel</v-btn>
        <v-btn color="error" variant="flat" :loading="deleting" @click="doDelete">Delete</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const props = defineProps<{ modelValue: boolean }>()
const emit  = defineEmits<{ 'update:modelValue': [v: boolean] }>()

const isOpen = computed({
  get: () => props.modelValue,
  set: (v) => emit('update:modelValue', v),
})

const authStore    = useAuthStore()
const router       = useRouter()
const confirmOpen  = ref(false)
const deleting     = ref(false)

const initials = computed(() => {
  const name = authStore.user?.name ?? ''
  return name
    .split(' ')
    .map((w) => w[0] ?? '')
    .join('')
    .toUpperCase()
    .slice(0, 2)
})

async function doDelete() {
  deleting.value = true
  try {
    await authStore.deleteAccount()
    confirmOpen.value = false
    isOpen.value      = false
    router.push('/')
  } catch {
    // keep dialog open on error
  } finally {
    deleting.value = false
  }
}
</script>
