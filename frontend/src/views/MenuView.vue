<template>
  <v-container fluid class="fill-height pa-0" style="min-height: 100vh; background-color: #f5f7fa; min-height: 100vh;">
    <v-row justify="center">
      <v-col cols="12" class="text-center mb-8">
        <h1 class="text-h4 font-weight-bold text-primary">Menu Aplikasi</h1>
        <p class="text-grey-darken-1">Silakan pilih menu layanan yang ingin Anda akses hari ini</p>
      </v-col>

    <v-col cols="12" md="5">
      <v-card
        class="pa-10 rounded-xl text-center cursor-pointer"
        elevation="2"
        @click="selectMenu('MARKETING')"
      >
        <v-icon size="80" color="primary">
          mdi-bullhorn
        </v-icon>

        <div class="text-h4 font-weight-bold mt-4">
          Marketing
        </div>
      </v-card>
    </v-col>

    <v-col cols="12" md="5">
      <v-card
        class="pa-10 rounded-xl text-center cursor-pointer"
        elevation="2"
        @click="selectMenu('PENAGIHAN')"
      >
        <v-icon size="80" color="warning">
          mdi-cash-register
        </v-icon>

        <div class="text-h4 font-weight-bold mt-4">
          Penagihan
        </div>
      </v-card>
    </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { useRouter } from 'vue-router'

const router = useRouter()

const selectMenu = (role, type = 'ADMIN') => {

  localStorage.setItem('user_role', role)
  localStorage.setItem('user_type', type)

  // =========================
  // MARKETING
  // =========================
  if (role === 'MARKETING') {

    if (type === 'ADMIN') {
      router.push('/dashboard-marketing')
    } else {
      router.push('/dashboard-marketing-ao')
    }

  }

  // =========================
  // PENAGIHAN
  // =========================
  else if (role === 'PENAGIHAN') {

    if (type === 'ADMIN') {
      router.push('/dashboard-penagihan')
    } else {
      router.push('/dashboard-penagihan-ao')
    }

  }
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