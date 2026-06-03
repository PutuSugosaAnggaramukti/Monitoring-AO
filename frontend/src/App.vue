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
      <v-list-item
        :title="userName"
        :subtitle="sidebarSubtitle"
      />
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
              :title="userName"
              :subtitle="`${userRole} Monitoring`">
            </v-list-item>
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

const userData = computed(() => {
  return JSON.parse(localStorage.getItem('user') || '{}')
})

const userName = computed(() => {
  return userData.value.name || 'User'
})

const userRole = computed(() => {
  return userData.value.role || 'AO'
})

const userWilayah = computed(() => {
  return userData.value.wilayah || '-'
})

const sidebarSubtitle = computed(() => {
  return `AO ${userWilayah.value}`
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
        icon: 'mdi-wallet',
        to: '/dashboard-penagihan'
      },
      {
        title: 'Data Nasabah',
        icon: 'mdi-account-details',
        to: '/data-nasabah'
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

    const isMarketing =
      currentPath.startsWith('/dashboard-marketing') ||
      currentPath === '/pelaporan' ||
      currentPath === '/pelaporan-nasabah-lama' ||
      currentPath === '/jadwal-kunjungan'

    const isPenagihan =
      currentPath.startsWith('/dashboard-penagihan')

    // MARKETING menus
    if (isMarketing) {
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
          title: 'Jadwal Kunjungan',
          icon: 'mdi-calendar-clock',
          to: '/jadwal-kunjungan'
        },
        {
          title: 'LapKun Nasabah Baru',
          icon: 'mdi-account-plus-outline',
          to: '/pelaporan'
        },
        {
          title: 'LapKun Nasabah Lama',
          icon: 'mdi-account-clock-outline',
          to: '/pelaporan-nasabah-lama'
        },
        {
          title: 'Pengaturan Akun',
          icon: 'mdi-account-cog',
          to: '/pengaturan-akun'
        }
      ]
    }

    // PENAGIHAN menus
    if (isPenagihan) {
      return [
        {
          title: 'Menu Aplikasi',
          icon: 'mdi-apps',
          to: '/menu'
        },
        {
          title: 'Dashboard Penagihan',
          icon: 'mdi-wallet',
          to: '/dashboard-penagihan'
        },
        {
          title: 'Pengaturan Akun',
          icon: 'mdi-account-cog',
          to: '/pengaturan-akun'
        }
      ]
    }
  }

  return []
})

const handleLogout = () => {
  localStorage.removeItem('user_role')
  router.push('/')
}
</script>