<template>
  <v-container fluid class="pa-6">

    <!-- HEADER -->
    <v-card class="pa-6 rounded-xl elevation-2 mb-6">
      <div class="d-flex align-center">
        <div>
          <div class="text-h5 font-weight-bold text-primary">
            Pengaturan Akun
          </div>

          <div class="text-subtitle-2 text-grey-darken-1 mt-1">
            Kelola keamanan akun dan ubah password
          </div>
        </div>

        <v-spacer></v-spacer>

        <v-avatar size="70" color="#2d5aa3">
          <v-icon size="38" color="white">
            mdi-account-cog
          </v-icon>
        </v-avatar>
      </div>
    </v-card>

    <!-- FORM -->
    <v-row justify="center">
      <v-col cols="12" md="7" lg="5">

        <v-card class="pa-6 rounded-xl elevation-2">

          <div class="text-h6 font-weight-bold mb-5">
            Ubah Password
          </div>

          <!-- NPP -->
          <v-text-field
            v-model="npp"
            label="NPP"
            prepend-inner-icon="mdi-card-account-details"
            variant="outlined"
            density="comfortable"
            readonly
            class="mb-3"
          />

          <!-- Nama -->
          <v-text-field
            v-model="nama"
            label="Nama User"
            prepend-inner-icon="mdi-account-outline"
            variant="outlined"
            density="comfortable"
            readonly
            class="mb-3"
          />

          <!-- Password Lama -->
          <v-text-field
            v-model="oldPassword"
            :type="showOldPassword ? 'text' : 'password'"
            label="Password Lama"
            prepend-inner-icon="mdi-lock-outline"
            :append-inner-icon="showOldPassword ? 'mdi-eye-off' : 'mdi-eye'"
            @click:append-inner="showOldPassword = !showOldPassword"
            variant="outlined"
            density="comfortable"
            class="mb-3"
          />

          <!-- Password Baru -->
          <v-text-field
            v-model="newPassword"
            :type="showNewPassword ? 'text' : 'password'"
            label="Password Baru"
            prepend-inner-icon="mdi-lock-reset"
            :append-inner-icon="showNewPassword ? 'mdi-eye-off' : 'mdi-eye'"
            @click:append-inner="showNewPassword = !showNewPassword"
            variant="outlined"
            density="comfortable"
            class="mb-2"
          />

          <!-- Strength -->
          <div class="mb-4">
            <div class="text-caption mb-1">
              Kekuatan Password
            </div>

            <v-progress-linear
              :model-value="passwordStrength"
              :color="strengthColor"
              height="8"
              rounded
            />

            <div class="text-caption mt-1">
              {{ strengthText }}
            </div>
          </div>

          <!-- Konfirmasi Password -->
          <v-text-field
            v-model="confirmPassword"
            :type="showConfirmPassword ? 'text' : 'password'"
            label="Konfirmasi Password"
            prepend-inner-icon="mdi-lock-check"
            :append-inner-icon="showConfirmPassword ? 'mdi-eye-off' : 'mdi-eye'"
            @click:append-inner="showConfirmPassword = !showConfirmPassword"
            variant="outlined"
            density="comfortable"
            class="mb-5"
          />

          <!-- BUTTON -->
          <v-btn
            block
            size="large"
            color="#2d5aa3"
            class="rounded-lg text-none"
            :loading="loading"
            @click="handleSave"
          >
            Simpan Password
          </v-btn>

        </v-card>

      </v-col>
    </v-row>

    <!-- SNACKBAR -->
    <v-snackbar
      v-model="snackbar"
      color="success"
      timeout="3000"
    >
      Password berhasil diperbarui
    </v-snackbar>

  </v-container>
</template>

<script setup>
import { ref, computed } from 'vue'

const loading = ref(false)
const snackbar = ref(false)

const npp = ref('220001')
const nama = ref('Administrator')

const oldPassword = ref('')
const newPassword = ref('')
const confirmPassword = ref('')

const showOldPassword = ref(false)
const showNewPassword = ref(false)
const showConfirmPassword = ref(false)

// PASSWORD STRENGTH
const passwordStrength = computed(() => {
  const pass = newPassword.value

  if (pass.length >= 10) return 100
  if (pass.length >= 8) return 75
  if (pass.length >= 6) return 50
  if (pass.length >= 3) return 25

  return 0
})

const strengthColor = computed(() => {
  if (passwordStrength.value >= 75) return 'success'
  if (passwordStrength.value >= 50) return 'warning'

  return 'error'
})

const strengthText = computed(() => {
  if (passwordStrength.value >= 75) return 'Password kuat'
  if (passwordStrength.value >= 50) return 'Password sedang'

  return 'Password lemah'
})

// SAVE
const handleSave = () => {

  if (
    !oldPassword.value ||
    !newPassword.value ||
    !confirmPassword.value
  ) {
    alert('Semua field wajib diisi')
    return
  }

  if (newPassword.value !== confirmPassword.value) {
    alert('Konfirmasi password tidak sama')
    return
  }

  loading.value = true

  setTimeout(() => {

    loading.value = false
    snackbar.value = true

    oldPassword.value = ''
    newPassword.value = ''
    confirmPassword.value = ''

  }, 1500)
}
</script>

<style scoped>
.v-container {
  max-width: 100% !important;
}
</style>