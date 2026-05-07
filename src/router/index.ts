import { createRouter, createWebHistory } from 'vue-router'

import LoginView from '../views/LoginView.vue'
import DashboardView from '../views/DashboardView.vue'
import MenuView from '../views/MenuView.vue'
import DataNasabahView from '../views/DataNasabahView.vue'
import DataKunjunganView from '../views/DataKunjunganView.vue'
import PelaporanView from '../views/PelaporanView.vue'


const routes = [
    {
        path: '/',
        name: 'login',
        component: LoginView,
    },
    {
        path: '/dashboard',
        name: 'dashboard',
        component: DashboardView,
    },
    {
        path: '/menu',
        name: 'menu-selection',
        component: MenuView,
    },

    {
        path: '/data-nasabah',
        name: 'data-nasabah',
        component: DataNasabahView,
    },
    {
        path: '/data-kunjungan',
        name: 'data-kunjungan',
        component: DataKunjunganView,
    },
    {
        path: '/pelaporan',
        name: 'pelaporan',
        component: PelaporanView,
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router