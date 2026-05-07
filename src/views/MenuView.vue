<template>
  <v-container fluid class="fill-height pa-0" style="min-height: 100vh; background-color: #f5f7fa; min-height: 100vh;">
    <v-row justify="center">
      <v-col cols="12" class="text-center mb-8">
        <h1 class="text-h4 font-weight-bold text-primary">Menu Aplikasi</h1>
        <p class="text-grey-darken-1">Silakan pilih menu layanan yang ingin Anda akses hari ini</p>
      </v-col>

      <v-col cols="12" sm="5" md="4">
        <v-card @click="selectMenu('marketing')" hover class="pa-6 text-center rounded-xl elevation-3">
          <v-icon size="80" color="#2d5aa3" class="mb-4">mdi-bullhorn-outline</v-icon>
          <h2 class="text-h5 font-weight-bold">Marketing</h2>
        </v-card>
      </v-col>

      <v-col cols="12" sm="5" md="4">
        <v-card @click="selectMenu('penagihan')" hover class="pa-6 text-center rounded-xl elevation-3">
          <v-icon size="80" color="orange-darken-2" class="mb-4">mdi-cash-register</v-icon>
          <h2 class="text-h5 font-weight-bold">Penagihan</h2>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const selectMenu = (role) => {
  localStorage.setItem('user_role', role)
  router.push('/dashboard')
}
</script>

<style scoped>
.v-card {
  transition: transform 0.3s;
  cursor: pointer;
}
.v-card:hover {
  transform: translateY(-10px);
  border: 2px solid #2d5aa3;
}
</style>