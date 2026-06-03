<template>
  <v-container fluid class="fill-height pa-0" style="min-height: 100vh; background-color: #f5f7fa;">
    <v-row justify="center" align="center" style="min-height: 100vh;">
      <v-col cols="12" class="text-center mb-4">
        <h1 class="text-h4 font-weight-bold text-primary">Menu Aplikasi</h1>
        <p class="text-grey-darken-1">Silakan pilih menu layanan yang ingin Anda akses hari ini</p>
      </v-col>

      <v-col cols="12" md="5">
        <v-card
          class="pa-10 rounded-xl text-center cursor-pointer"
          elevation="2"
          @click="selectMenu('MARKETING')"
        >
          <v-icon size="80" color="primary">mdi-bullhorn</v-icon>
          <div class="text-h4 font-weight-bold mt-4">Marketing</div>
        </v-card>
      </v-col>

      <v-col cols="12" md="5">
        <v-card
          class="pa-10 rounded-xl text-center cursor-pointer"
          elevation="2"
          @click="selectMenu('PENAGIHAN')"
        >
          <v-icon size="80" color="warning">mdi-wallet</v-icon>
          <div class="text-h4 font-weight-bold mt-4">Penagihan</div>
        </v-card>
      </v-col>

      <!-- ADMIN ONLY -->
      <v-col v-if="isAdmin" cols="12" md="5">
        <v-card
          class="pa-10 rounded-xl text-center cursor-pointer new-account-card"
          elevation="2"
          @click="goToCreateAccount"
        >
          <v-icon size="80" color="success">mdi-account-plus</v-icon>
          <div class="text-h4 font-weight-bold mt-4">Buat Akun Baru AO</div>
        </v-card>
      </v-col>

      <!-- Logout Card -->
      <v-col cols="12" :md="isAdmin ? '5' : '10'">
        <v-card
          class="pa-10 rounded-xl text-center cursor-pointer logout-card"
          elevation="2"
          @click="logout"
        >
          <v-icon size="80" color="error">mdi-logout</v-icon>
          <div class="text-h4 font-weight-bold mt-4">Logout</div>
        </v-card>
      </v-col>

    </v-row>
  </v-container>
</template>

<script setup>
import { computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// check if user is admin
const isAdmin = computed(() => {
  const user = JSON.parse(localStorage.getItem('user') || '{}')
  return user.role === 'ADMIN' || user.role === 'admin'
})

const selectMenu = (menu, type = 'ADMIN') => {

  // simpan menu aplikasi
  localStorage.setItem('menu_aplikasi', menu)

  // simpan tipe user
  localStorage.setItem('user_type', type)

  // routing
  if (menu === 'MARKETING') {

    if (type === 'ADMIN') {
      router.push('/dashboard-marketing')
    } else {
      router.push('/dashboard-marketing-ao')
    }

  } else if (menu === 'PENAGIHAN') {

    if (type === 'ADMIN') {
      router.push('/dashboard-penagihan')
    } else {
      router.push('/dashboard-penagihan-ao')
    }

  }
}

const goToCreateAccount = () => {
  router.push('/buat-akun-ao')
}

const logout = () => {
  localStorage.removeItem('user_role')
  localStorage.removeItem('user_type')
  localStorage.removeItem('token')
  localStorage.removeItem('user')
  router.push('/')
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
.new-account-card:hover {
  border: 2px solid #4caf50 !important;
}
.logout-card:hover {
  border: 2px solid #f44336 !important;
}
</style>