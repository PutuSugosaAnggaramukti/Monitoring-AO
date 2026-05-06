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
        <v-list-item prepend-icon="mdi-view-dashboard" title="Dashboard" to="/dashboard" />
        <v-list-item prepend-icon="mdi-account-group" title="Nasabah" to="/nasabah" />
      </v-list>
    </v-navigation-drawer>

    <!-- Navbar Atas -->
    <v-app-bar v-if="!isLoginPage" color="white" elevation="1">
      <v-app-bar-nav-icon color="#2d5aa3" @click="drawer = !drawer" />
      <v-app-bar-title class="text-primary font-weight-bold">Monitoring AO</v-app-bar-title>
    </v-app-bar>

    <!-- Tempat merender DashboardView.vue atau halaman lain -->
    <v-main :style="!isLoginPage ? 'background-color: #f5f7fa;' : ''">
      <router-view />
    </v-main>
  </v-app>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute } from 'vue-router'

const drawer = ref(true)
const route = useRoute()

const isLoginPage = computed(() => route.path === '/')
</script>