<template>
  <v-container fluid class="pa-6">
    <v-card class="mb-6 pa-6 rounded-xl elevation-2" border>
      <div class="d-flex align-center">
        <div>
          <div class="d-flex align-center mb-1">
            <h1 class="text-h4 font-weight-bold text-primary mr-3">
              Dashboard {{ userRole === 'MARKETING' ? 'Marketing' : 'Penagihan' }}
            </h1>
          </div>
          <p class="text-subtitle-1 text-grey-darken-1 mb-0">
            Selamat datang kembali, <span class="font-weight-bold text-secondary">Administrator</span> 👋
          </p>
        </div>
        <v-spacer></v-spacer>
        <div class="text-right mr-6">
          <div class="text-caption text-grey text-uppercase font-weight-bold mb-n1">Waktu Sistem</div>
          <div class="text-h4 font-weight-black text-primary">{{ currentTime }}</div>
        </div>
        <v-icon size="64" color="blue-lighten-4">mdi-clock-outline</v-icon>
      </div>
    </v-card>

    <v-row v-if="userRole === 'PENAGIHAN'" class="mb-3 d-flex align-stretch">
      <v-col cols="12">
        <h2 class="text-h5 font-weight-bold text-grey-darken-2 mb-4">Statistik Kinerja</h2>
      </v-col>
      
      <v-col cols="12" sm="6" md="3">
        <v-card class="pa-5 rounded-xl elevation-2 fill-height d-flex flex-column" border="start" style="border-inline-start: 6px solid #2d5aa3 !important;">
          <div class="text-overline text-grey-darken-1">Total Rencana</div>
          <div class="text-h4 font-weight-black text-primary mb-auto">24</div>
          <div class="text-caption text-grey mt-2">Kunjungan Hari Ini</div>
        </v-card>
      </v-col>

      <v-col cols="12" sm="6" md="3">
        <v-card class="pa-5 rounded-xl elevation-2 fill-height d-flex flex-column" border="start" style="border-inline-start: 6px solid #4CAF50 !important;">
          <div class="text-overline text-grey-darken-1">Sudah Dikunjungi</div>
          <div class="text-h4 font-weight-black text-success mb-auto">15</div>
          <v-progress-linear model-value="62" color="success" height="4" rounded class="mt-2"></v-progress-linear>
        </v-card>
      </v-col>

      <v-col cols="12" sm="6" md="3">
        <v-card class="pa-5 rounded-xl elevation-2 fill-height d-flex flex-column" border="start" style="border-inline-start: 6px solid #FB8C00 !important;">
          <div class="text-overline text-grey-darken-1">Belum Dikunjungi</div>
          <div class="text-h4 font-weight-black text-warning mb-auto">7</div>
          <div class="text-caption text-grey mt-2">Menunggu Antrean</div>
        </v-card>
      </v-col>

      <v-col cols="12" sm="6" md="3">
        <v-card class="pa-5 rounded-xl elevation-2 fill-height d-flex flex-column" border="start" style="border-inline-start: 6px solid #F44336 !important;">
          <div class="text-overline text-grey-darken-1">Gagal Kunjungan</div>
          <div class="text-h4 font-weight-black text-error mb-auto">2</div>
          <div class="text-caption text-grey mt-2">Butuh Tindak Lanjut</div>
        </v-card>
      </v-col>
    </v-row>

    <v-row>
      <v-col cols="12" sm="6" md="4">
        <v-card class="pa-6 rounded-xl elevation-2">
          <div class="text-subtitle-1 text-grey mb-2">Total Nasabah Kelolaan</div>
          <div class="text-h4 font-weight-bold text-primary mb-4">150</div>
          <v-progress-linear model-value="70" color="#2d5aa3" height="8" rounded></v-progress-linear>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const currentTime = ref('')
const userRole = ref('')

const updateTime = () => {
  const now = new Date()
  currentTime.value = now.toLocaleTimeString('id-ID', {
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: false
  })
}

let timer
onMounted(() => {
  const savedRole = localStorage.getItem('user_role')
  userRole.value = savedRole ? savedRole.toUpperCase() : 'UMUM'
  
  updateTime()
  timer = setInterval(() => {
    updateTime()
  }, 1000)
})

onUnmounted(() => {
  if (timer) clearInterval(timer)
})
</script>

<style scoped>
.v-container {
  max-width: 100% !important;
}
.text-h4 {
  font-variant-numeric: tabular-nums;
}
/* Memastikan card dalam row d-flex align-stretch benar-benar mengisi tinggi col */
.fill-height {
  height: 100%;
}
</style>