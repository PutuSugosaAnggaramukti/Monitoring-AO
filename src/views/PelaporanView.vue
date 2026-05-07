<template>
  <v-container fluid class="pa-6 bg-grey-lighten-4" style="min-height: 100vh;">
    <v-card class="mb-6 pa-6 rounded-xl elevation-2" border>
      <div class="d-flex align-center">
        <div>
          <h1 class="text-h4 font-weight-bold text-primary mb-1">Pelaporan</h1>
          <p class="text-subtitle-1 text-grey-darken-1 mb-0">
            Dashboard > <span class="font-weight-bold text-primary">Pelaporan</span>
          </p>
        </div>
        <v-spacer></v-spacer>
        <v-icon size="64" color="blue-lighten-4">mdi-chart-box-outline</v-icon>
      </div>
    </v-card>

    <v-card class="mb-6 pa-4 rounded-xl elevation-2">
      <v-row align="center">
        <v-col cols="12" md="6">
          <v-btn color="success" prepend-icon="mdi-file-excel" variant="flat" class="rounded-lg">
            Export Excel (Semua)
          </v-btn>
        </v-col>
        <v-col cols="12" md="6">
          <v-text-field
            v-model="searchGlobal"
            prepend-inner-icon="mdi-magnify"
            label="Pencarian Global (AO atau Nasabah)..."
            variant="outlined"
            density="compact"
            hide-details
            color="primary"
            class="rounded-lg"
          ></v-text-field>
        </v-col>
      </v-row>
    </v-card>

    <v-card class="mb-6 rounded-xl elevation-2 overflow-hidden">
      <v-card-title class="pa-4 font-weight-bold text-grey-darken-3 d-flex align-center">
        <v-icon start color="primary">mdi-account-clock</v-icon>
        Daftar AO Aktif Berkunjung
      </v-card-title>
      <v-data-table
        :headers="headersAO"
        :items="itemsAO"
        :search="searchGlobal"
        class="custom-table"
        hover
      >
        <template v-slot:item.no="{ index }">
          {{ index + 1 }}
        </template>
        <template v-slot:item.nama="{ value }">
          <span class="font-weight-bold text-primary">{{ value }}</span>
        </template>
      </v-data-table>
    </v-card>

    <v-card class="rounded-xl elevation-2 overflow-hidden">
      <v-toolbar color="white" flat class="px-4 pt-2">
        <v-toolbar-title class="text-subtitle-1 font-weight-bold text-grey-darken-3">
          <v-icon start color="success">mdi-home-check</v-icon>
          Daftar Nasabah Sudah Dikunjungi
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-text-field
          v-model="searchNasabah"
          prepend-inner-icon="mdi-account-search"
          label="Cari No. Angsuran / Nama Nasabah..."
          variant="outlined"
          density="compact"
          hide-details
          single-line
          color="success"
          style="max-width: 300px;"
          class="rounded-lg"
        ></v-text-field>
      </v-toolbar>
      
      <v-data-table
        :headers="headersNasabah"
        :items="itemsNasabah"
        :search="searchNasabah || searchGlobal"
        class="custom-table"
        hover
      >
        <template v-slot:item.no="{ index }">
          {{ index + 1 }}
        </template>
        <template v-slot:item.ao_visit="{ item }">
          <v-chip size="small" color="success" variant="flat" class="font-weight-bold">
            <v-icon start size="14">mdi-account-tie</v-icon>
            ({{ item.kode_ao }}) {{ item.nama_ao }}
          </v-chip>
        </template>
        <template v-slot:item.tgl_kunjungan="{ value }">
          <span class="text-grey-darken-2 font-weight-medium">{{ value }}</span>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'

const searchGlobal = ref('')
const searchNasabah = ref('')

const headersAO = [
  { title: 'NO', key: 'no', width: '70px', sortable: false },
  { title: 'TANGGAL KUNJUNGI TERAKHIR', key: 'tgl_terakhir', align: 'start' },
  { title: 'KODE AO', key: 'kode_ao', align: 'start' },
  { title: 'NAMA AO', key: 'nama', align: 'start' },
]

const headersNasabah = [
  { title: 'NO', key: 'no', width: '70px', sortable: false },
  { title: 'NO. ANGSURAN', key: 'no_angsuran', align: 'start' },
  { title: 'NAMA NASABAH', key: 'nama_nasabah', align: 'start' },
  { title: 'DIKUNJUNGI OLEH (AO)', key: 'ao_visit', align: 'start' },
  { title: 'TGL KUNJUNGAN', key: 'tgl_kunjungan', align: 'center' },
]

// Data Dummy
const itemsAO = ref([
  { tgl_terakhir: '05-05-2026', kode_ao: 'C-011', nama: 'Wahyu Nugroho' },
  { tgl_terakhir: '06-05-2026', kode_ao: 'C-004', nama: 'Tri Suryana' },
  { tgl_terakhir: '07-05-2026', kode_ao: 'C-006', nama: 'Fajar Setyahartadi' },
])

const itemsNasabah = ref([
  { 
    no_angsuran: '20000228', 
    nama_nasabah: 'EKO SUTRISNO AJI', 
    kode_ao: 'C-011', 
    nama_ao: 'Wahyu Nugroho', 
    tgl_kunjungan: '05-05-2026' 
  },
  { 
    no_angsuran: '24000527', 
    nama_nasabah: 'A BRILYAN VANDI YANSA', 
    kode_ao: 'C-004', 
    nama_ao: 'Tri Suryana', 
    tgl_kunjungan: '06-05-2026' 
  },
])
</script>

<style scoped>
.custom-table :deep(thead) {
  background-color: #f8fafc !important;
}
.custom-table :deep(th) {
  font-weight: 700 !important;
  color: #475569 !important;
  text-transform: uppercase;
  font-size: 11px !important;
  letter-spacing: 0.5px;
}
.custom-table :deep(td) {
  height: 52px !important;
}
</style>