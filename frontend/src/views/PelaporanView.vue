<template>
  <v-container fluid class="pa-6 bg-grey-lighten-4" style="min-height: 100vh;">

    <!-- HEADER -->
    <v-card class="mb-6 pa-6 rounded-xl elevation-2" border>
      <div class="d-flex align-center">
        <div>
          <h1 class="text-h4 font-weight-bold text-primary mb-1">
            Pelaporan Kunjungan
          </h1>

          <p class="text-subtitle-1 text-grey-darken-1 mb-0">
            Upload hasil kunjungan AO ke nasabah
          </p>
        </div>

        <v-spacer></v-spacer>

        <v-avatar size="72" color="blue-lighten-5">
          <v-icon size="40" color="primary">
            mdi-file-document-edit-outline
          </v-icon>
        </v-avatar>
      </div>
    </v-card>

    <!-- FORM LAPORAN -->
    <v-card class="mb-6 pa-6 rounded-xl elevation-2">

      <div class="text-h6 font-weight-bold mb-5">
        Form Laporan Kunjungan
      </div>

      <v-row>

        <!-- NO ANGSURAN -->
        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.no_angsuran"
            label="No. Angsuran"
            variant="outlined"
            prepend-inner-icon="mdi-card-account-details"
            density="comfortable"
          />
        </v-col>

        <!-- NAMA NASABAH -->
        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.nama_nasabah"
            label="Nama Nasabah"
            variant="outlined"
            prepend-inner-icon="mdi-account"
            density="comfortable"
          />
        </v-col>

        <!-- TANGGAL -->
        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.tanggal"
            type="date"
            label="Tanggal Kunjungan"
            variant="outlined"
            prepend-inner-icon="mdi-calendar"
            density="comfortable"
          />
        </v-col>

        <!-- STATUS -->
        <v-col cols="12" md="6">
          <v-select
            v-model="form.status"
            :items="statusItems"
            label="Status Kunjungan"
            variant="outlined"
            prepend-inner-icon="mdi-check-circle-outline"
            density="comfortable"
          />
        </v-col>

        <!-- CATATAN -->
        <v-col cols="12">
          <v-textarea
            v-model="form.catatan"
            label="Catatan Hasil Kunjungan"
            variant="outlined"
            rows="4"
            prepend-inner-icon="mdi-note-text-outline"
          />
        </v-col>

        <!-- FOTO -->
        <v-col cols="12">
          <v-file-input
            v-model="form.foto"
            label="Upload Foto Kunjungan"
            variant="outlined"
            prepend-icon=""
            prepend-inner-icon="mdi-camera"
            accept="image/*"
            show-size
          />
        </v-col>

      </v-row>

      <!-- BUTTON -->
      <div class="d-flex justify-end mt-4">
        <v-btn
          color="primary"
          size="large"
          prepend-icon="mdi-content-save"
          class="rounded-lg"
          @click="submitLaporan"
        >
          Simpan Laporan
        </v-btn>
      </div>

    </v-card>

    <!-- RIWAYAT -->
    <v-card class="rounded-xl elevation-2 overflow-hidden">

      <v-toolbar flat color="white" class="px-4">
        <v-toolbar-title class="font-weight-bold">
          <v-icon start color="primary">
            mdi-history
          </v-icon>
          Riwayat Kunjungan
        </v-toolbar-title>

        <v-spacer></v-spacer>

        <v-text-field
          v-model="search"
          prepend-inner-icon="mdi-magnify"
          label="Cari laporan..."
          density="compact"
          variant="outlined"
          hide-details
          style="max-width: 300px;"
        />
      </v-toolbar>

      <v-data-table
        :headers="headers"
        :items="items"
        :search="search"
        hover
      >

        <template v-slot:item.no="{ index }">
          {{ index + 1 }}
        </template>

        <template v-slot:item.status="{ value }">
          <v-chip
            :color="getStatusColor(value)"
            size="small"
            variant="flat"
          >
            {{ value }}
          </v-chip>
        </template>

        <template v-slot:item.foto>
          <v-btn
            size="small"
            color="info"
            variant="tonal"
          >
            Lihat Foto
          </v-btn>
        </template>

      </v-data-table>

    </v-card>

  </v-container>
</template>

<script setup>
import { ref } from 'vue'

const search = ref('')

const statusItems = [
  'Berhasil Dikunjungi',
  'Tidak Bertemu',
  'Menolak',
  'Perlu Follow Up'
]

const form = ref({
  no_angsuran: '',
  nama_nasabah: '',
  tanggal: '',
  status: '',
  catatan: '',
  foto: null
})

const headers = [
  { title: 'NO', key: 'no', sortable: false },
  { title: 'NO ANGSURAN', key: 'no_angsuran' },
  { title: 'NAMA NASABAH', key: 'nama_nasabah' },
  { title: 'TANGGAL', key: 'tanggal' },
  { title: 'STATUS', key: 'status' },
  { title: 'FOTO', key: 'foto', sortable: false }
]

const items = ref([
  {
    no_angsuran: '240001',
    nama_nasabah: 'Budi Santoso',
    tanggal: '2026-05-19',
    status: 'Berhasil Dikunjungi'
  },
  {
    no_angsuran: '240002',
    nama_nasabah: 'Siti Aminah',
    tanggal: '2026-05-18',
    status: 'Perlu Follow Up'
  }
])

const getStatusColor = (status) => {
  if (status === 'Berhasil Dikunjungi') return 'success'
  if (status === 'Tidak Bertemu') return 'warning'
  if (status === 'Menolak') return 'error'
  return 'info'
}

const submitLaporan = () => {
  console.log(form.value)

  alert('Laporan berhasil disimpan')

  form.value = {
    no_angsuran: '',
    nama_nasabah: '',
    tanggal: '',
    status: '',
    catatan: '',
    foto: null
  }
}
</script>