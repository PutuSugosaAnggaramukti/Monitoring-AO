<template>
  <v-app>
    <v-navigation-drawer 
      v-if="!isLoginPage" 
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
          active-class="bg-white text-primary"
          rounded="lg"
        />
      </v-list>
    </v-navigation-drawer>

    <v-app-bar v-if="!isLoginPage" color="white" elevation="1">
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

const isLoginPage = computed(() => {
  return route.path === '/' || route.path === '/menu'
})

const menuItems = computed(() => {
  const items = [
    { title: 'Dashboard', icon: 'mdi-view-dashboard', to: '/dashboard' },
    { title: 'Data Nasabah', icon: 'mdi-account-group', to: '/data-nasabah' },
  ]

  if (userRole.value === 'PENAGIHAN' || userRole.value === 'ADMINISTRATOR') {
    items.push(
      { title: 'Data Kunjungan', icon: 'mdi-map-marker-distance', to: '/data-kunjungan' },
      { title: 'Pelaporan', icon: 'mdi-chart-box-outline', to: '/pelaporan' }
    )
  }

  return items
})

const handleLogout = () => {
  localStorage.removeItem('user_role')
  router.push('/')
}
</script>