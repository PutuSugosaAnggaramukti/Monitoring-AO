<template>
  <v-app>
    <v-navigation-drawer 
    v-if="!hideLayout"
    v-model="drawer" 
    color="#2d5aa3" 
    theme="dark"
    permanent
    >
    
    <v-list class="pa-4">
      <v-list-item title="AO Bank Bantul" subtitle="Monitoring"></v-list-item>
    </v-list>
    
    <v-divider></v-divider>
    
    <v-list nav>
      <v-list-item 
        v-for="item in menuItems" 
        :key="item.title"
        :prepend-icon="item.icon" 
        :title="item.title" 
        :to="item.to"
        exact
        active-class="bg-white text-primary"
        rounded="lg"
      />
    </v-list>

    <!-- LOGOUT BUTTON -->
    <template v-slot:append>
      <div class="pa-4">
        <v-btn
          block
          color="white"
          variant="outlined"
          prepend-icon="mdi-logout"
          rounded="lg"
          @click="handleLogout"
        >
          Logout
        </v-btn>
      </div>
    </template>

  </v-navigation-drawer>

    <v-app-bar v-if="!hideLayout" color="white" elevation="1">
      <v-app-bar-nav-icon color="#2d5aa3" @click="drawer = !drawer" />
      <v-app-bar-title class="text-primary font-weight-bold">Monitoring AO</v-app-bar-title>
      
      <v-spacer></v-spacer>

      <v-menu min-width="200px" rounded>
        <template v-slot:activator="{ props }">
          <v-btn icon v-bind="props" class="mr-2">
            <v-avatar color="#2d5aa3" size="default">
              <v-icon color="white">mdi-account</v-icon>
            </v-avatar>
          </v-btn>
        </template>
        
        <v-card class="mt-2 pa-2 rounded-lg">
          <v-list>
            <v-list-item
              title="Administrator"
              subtitle="AO Bank Bantul"
            />
            <v-divider class="my-2"></v-divider>
            <v-list-item 
              link 
              color="error" 
              prepend-icon="mdi-logout" 
              title="Logout"
              @click="handleLogout"
            />
          </v-list>
        </v-card>
      </v-menu>
    </v-app-bar>

    <v-main class="bg-grey-lighten-4">
      <router-view />
    </v-main>
  </v-app>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router' 

const drawer = ref(true)
const route = useRoute()
const router = useRouter() 

const userRole = computed(() => {
  return localStorage.getItem('user_role')?.toUpperCase() || 'UMUM'
})

const hideLayout = computed(() => {
  return route.path === '/' || route.path === '/menu'
})

const menuItems = computed(() => {

  const role = localStorage.getItem('user_role')?.toUpperCase()
  const currentPath = route.path

  // =========================
  // HALAMAN MENU
  // =========================
  if (currentPath === '/menu') {
    return []
  }

  // =========================
  // MENU ADMIN
  // =========================
  if (role === 'ADMIN') {
    return [
      {
        title: 'Menu Aplikasi',
        icon: 'mdi-apps',
        to: '/menu'
      },
      {
        title: 'Dashboard Marketing',
        icon: 'mdi-bullhorn',
        to: '/dashboard-marketing'
      },
      {
        title: 'Dashboard Penagihan',
        icon: 'mdi-cash-register',
        to: '/dashboard-penagihan'
      },
      {
        title: 'Data Nasabah',
        icon: 'mdi-account-details',
        to: '/data-nasabah'
      },
      {
        title: 'Pelaporan',
        icon: 'mdi-chart-box-outline',
        to: '/pelaporan'
      },
      {
        title: 'Buat Akun Baru AO',
        icon: 'mdi-account-plus',
        to: '/buat-akun-ao'
      },
      {
        title: 'Pengaturan Akun',
        icon: 'mdi-account-cog',
        to: '/pengaturan-akun'
      }
    ]
  }

  // =========================
  // MENU AO
  // =========================
  if (role === 'AO') {
    return [
      {
        title: 'Menu Aplikasi',
        icon: 'mdi-apps',
        to: '/menu'
      },
      {
        title: 'Dashboard Marketing',
        icon: 'mdi-bullhorn',
        to: '/dashboard-marketing'
      },
      {
        title: 'Dashboard Penagihan',
        icon: 'mdi-cash-register',
        to: '/dashboard-penagihan'
      },
      {
        title: 'Jadwal Kunjungan',
        icon: 'mdi-calendar-clock',
        to: '/jadwal-kunjungan'
      },
      {
        title: 'Pelaporan',
        icon: 'mdi-chart-box-outline',
        to: '/pelaporan'
      },
      {
        title: 'Pengaturan Akun',
        icon: 'mdi-account-cog',
        to: '/pengaturan-akun'
      }
    ]
  }

  return []
})

const handleLogout = () => {
  localStorage.removeItem('user_role')
  router.push('/')
}
</script>