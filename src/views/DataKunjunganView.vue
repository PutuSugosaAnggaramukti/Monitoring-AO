<template>
  <v-container fluid class="pa-6 bg-grey-lighten-4" style="min-height: 100vh;">
    <v-card class="mb-6 pa-6 rounded-xl elevation-2" border>
      <div class="d-flex align-center">
        <div>
          <h1 class="text-h4 font-weight-bold text-primary mb-1">
            {{ selectedCategory ? 'Data ' + selectedCategory : 'Data Kunjungan' }}
          </h1>
          <p class="text-subtitle-1 text-grey-darken-1 mb-0">
            Dashboard > 
            <span :class="!selectedCategory ? 'font-weight-bold text-primary' : ''" @click="selectedCategory = null" style="cursor:pointer">
              Data Kunjungan
            </span>
            <span v-if="selectedCategory" class="font-weight-bold text-primary"> 
              > {{ selectedCategory }} 
            </span>
          </p>
        </div>
        <v-spacer></v-spacer>
        <v-btn 
          v-if="selectedCategory" 
          prepend-icon="mdi-arrow-left" 
          variant="tonal" 
          color="primary" 
          class="rounded-lg"
          @click="selectedCategory = null"
        >
          Kembali ke Menu Utama
        </v-btn>
        <v-icon v-else size="64" color="blue-lighten-4">mdi-map-marker-path</v-icon>
      </div>
    </v-card>

    <v-fade-transition mode="out-in">
      
      <v-row v-if="!selectedCategory" key="menu-cards" justify="center" class="mt-4">
        <v-col cols="12" md="5">
          <v-card 
            class="pa-6 rounded-xl elevation-3 text-center clickable-card overflow-hidden" 
            @click="selectedCategory = 'Kunjungan AO Umum'"
          >
            <div class="bg-primary-lighten-5 rounded-circle d-inline-flex pa-4 mb-4">
              <v-icon size="80" color="primary">mdi-account-group</v-icon>
            </div>
            <h2 class="text-h5 font-weight-bold mb-2">Kunjungan AO Umum</h2>
            <v-btn block color="primary" variant="flat" class="mt-4 rounded-lg">Pilih Kategori</v-btn>
          </v-card>
        </v-col>

        <v-col cols="12" md="5">
          <v-card 
            class="pa-6 rounded-xl elevation-3 text-center clickable-card overflow-hidden" 
            @click="selectedCategory = 'Kunjungan AO Pegawai'"
          >
            <div class="bg-indigo-lighten-5 rounded-circle d-inline-flex pa-4 mb-4">
              <v-icon size="80" color="indigo-darken-2">mdi-badge-account-horizontal</v-icon>
            </div>
            <h2 class="text-h5 font-weight-bold mb-2">Kunjungan AO Pegawai</h2>
            <v-btn block color="indigo-darken-2" variant="flat" class="mt-4 rounded-lg">Pilih Kategori</v-btn>
          </v-card>
        </v-col>
      </v-row>

      <div v-else key="data-tables">
        <v-card class="mb-6 pa-4 rounded-xl elevation-2">
          <v-row align="center">
            <v-col cols="12" md="6" class="d-flex flex-wrap gap-2">
              <v-select
                v-model="filterBulan"
                :items="['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni']"
                label="Bulan"
                variant="outlined"
                density="compact"
                hide-details
                class="rounded-lg"
                style="max-width: 150px;"
              ></v-select>
              <v-btn color="success" prepend-icon="mdi-file-excel" variant="flat" class="rounded-lg">
                Export Excel
              </v-btn>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="search"
                prepend-inner-icon="mdi-magnify"
                label="Cari AO..."
                variant="outlined"
                density="compact"
                hide-details
                class="rounded-lg"
              ></v-text-field>
            </v-col>
          </v-row>
        </v-card>

        <v-card class="rounded-xl elevation-2 overflow-hidden">
          <v-data-table
            :headers="headers"
            :items="filteredItems"
            :search="search"
            class="custom-table"
          >
            <template v-slot:item.no="{ index }">{{ index + 1 }}</template>
            <template v-slot:item.sudah_dikunjungi="{ value }">
              <v-chip color="success" size="small" variant="flat" class="font-weight-bold">{{ value }}</v-chip>
            </template>
            <template v-slot:item.total_rencana="{ value }">
              <v-chip color="grey-lighten-2" size="small" variant="flat" class="font-weight-bold">{{ value }}</v-chip>
            </template>
          </v-data-table>
        </v-card>
      </div>

    </v-fade-transition>
  </v-container>
</template>


<script setup>
import { ref, computed } from 'vue'

const selectedCategory = ref(null) 
const search = ref('')
const filterBulan = ref('Mei')

const headers = [
  { title: 'NO', key: 'no', width: '70px' },
  { title: 'KODE AO', key: 'kode' },
  { title: 'NAMA PETUGAS (AO)', key: 'nama' },
  { title: 'SUDAH DIKUNJUNGI', key: 'sudah_dikunjungi', align: 'center' },
  { title: 'TOTAL RENCANA', key: 'total_rencana', align: 'center' },
  { title: 'AKSI', key: 'actions', align: 'center', sortable: false },
]

const itemsUmum = [
  { kode: 'C-012', nama: 'AO Umum 1', sudah_dikunjungi: 10, total_rencana: 10 },
  { kode: 'C-013', nama: 'AO Umum 2', sudah_dikunjungi: 4, total_rencana: 12 },
]

const itemsPegawai = [
  { kode: 'P-001', nama: 'AO Pegawai 1', sudah_dikunjungi: 15, total_rencana: 20 },
  { kode: 'P-002', nama: 'AO Pegawai 2', sudah_dikunjungi: 5, total_rencana: 5 },
]

const filteredItems = computed(() => {
  return selectedCategory.value === 'Kunjungan AO Umum' ? itemsUmum : itemsPegawai
})
</script>

<style scoped>
.gap-2 { gap: 12px; }

.clickable-card {
  transition: all 0.3s ease;
  cursor: pointer;
  border: 2px solid transparent;
}

.clickable-card:hover {
  transform: translateY(-5px);
  border-color: #2d5aa3;
  box-shadow: 0 10px 20px rgba(45, 90, 163, 0.15) !important;
}

.bg-primary-lighten-5 { background-color: #e3f2fd; }
.bg-indigo-lighten-5 { background-color: #e8eaf6; }

.custom-table :deep(thead) {
  background-color: #f8fafc !important;
}
.custom-table :deep(th) {
  font-weight: 700 !important;
  color: #475569 !important;
  text-transform: uppercase;
  font-size: 11px !important;
}
</style>