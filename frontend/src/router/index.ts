import { createRouter, createWebHistory } from 'vue-router'

import LoginView from '../views/LoginView.vue'
import MenuView from '../views/MenuView.vue'

import DashboardMarketingView from '../views/DashboardMarketingView.vue'
import DashboardPenagihanView from '../views/DashboardPenagihanView.vue'


import DataNasabahView from '../views/DataNasabahView.vue'
import DataKunjunganView from '../views/DataKunjunganView.vue'
import PelaporanView from '../views/PelaporanView.vue'
import PengaturanAkunView from '../views/PengaturanAkunView.vue'
import BuatAkunAoView from '../views/BuatAkunAoView.vue'
import JadwalKunjunganView from '../views/JadwalKunjunganView.vue'
import PelaporanNasabahLama from '../views/PelaporanNasabahLamaView.vue'

const routes = [
  {
    path: '/',
    name: 'login',
    component: LoginView,
  },

  {
    path: '/menu',
    name: 'menu-selection',
    component: MenuView,
  },

  // DASHBOARD MARKETING
  {
    path: '/dashboard-marketing',
    name: 'dashboard-marketing',
    component: DashboardMarketingView,
  },

  // DASHBOARD PENAGIHAN
  {
    path: '/dashboard-penagihan',
    name: 'dashboard-penagihan',
    component: DashboardPenagihanView,
  },

  // MENU UMUM
  {
    path: '/data-nasabah',
    name: 'data-nasabah',
    component: DataNasabahView,
  },

  // KHUSUS PENAGIHAN
  {
    path: '/data-kunjungan',
    name: 'data-kunjungan',
    component: DataKunjunganView,
  },

  {
    path: '/pelaporan',
    name: 'pelaporan',
    component: PelaporanView,
  },
  
  {
    path: '/pengaturan-akun',
    name: 'pengaturan-akun',
    component: PengaturanAkunView,
  },

  {
    path: '/buat-akun-ao',
    name: 'buat-akun-ao',
    component: BuatAkunAoView,
  },
  {
    path: '/jadwal-kunjungan',
    name: 'jadwal-kunjungan',
    component: JadwalKunjunganView,
  },
  {
    path: '/pelaporan-nasabah-lama',
    name: 'pelaporan-nasabah-lama',
    component: PelaporanNasabahLama,
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router