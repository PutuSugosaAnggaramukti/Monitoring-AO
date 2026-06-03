<template>
  <v-container fluid class="pa-6 bg-grey-lighten-4" style="min-height: 100vh;">

    <!-- HEADER -->
    <v-card class="mb-6 pa-6 rounded-xl elevation-2" border>
      <div class="d-flex align-center">
        <div>
          <h1 class="text-h4 font-weight-bold text-primary mb-1">
            Pelaporan Kunjungan Nasabah Baru
          </h1>
          <p class="text-subtitle-1 text-grey-darken-1 mb-0">
            Upload hasil kunjungan AO ke nasabah
          </p>
        </div>
        <v-spacer></v-spacer>
        <v-avatar size="72" color="blue-lighten-5">
          <v-icon size="40" color="primary">mdi-file-document-edit-outline</v-icon>
        </v-avatar>
      </div>
    </v-card>

    <!-- FORM LAPORAN -->
    <v-card class="mb-6 pa-6 rounded-xl elevation-2">

      <div class="text-h6 font-weight-bold mb-5">Form Laporan Kunjungan</div>

      <v-row>

        <!-- NAMA SESUAI KTP -->
        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.nama_ktp"
            label="Nama Sesuai KTP"
            variant="outlined"
            prepend-inner-icon="mdi-account-card"
            density="comfortable"
          />
        </v-col>

        <!-- NAMA TANPA GELAR -->
        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.nama_tanpa_gelar"
            label="Nama Tanpa Gelar"
            variant="outlined"
            prepend-inner-icon="mdi-account"
            density="comfortable"
          />
        </v-col>

        <!-- STRATA PENDIDIKAN -->
        <v-col cols="12" md="6">
          <v-select
            v-model="form.pendidikan"
            :items="pendidikanItems"
            label="Strata Pendidikan Terakhir"
            variant="outlined"
            prepend-inner-icon="mdi-school"
            density="comfortable"
          />
        </v-col>

        <!-- NPWP -->
        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.npwp"
            label="NPWP"
            variant="outlined"
            prepend-inner-icon="mdi-identifier"
            density="comfortable"
          />
        </v-col>

        <!-- NO KTP -->
        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.no_ktp"
            label="No. KTP"
            variant="outlined"
            prepend-inner-icon="mdi-card-account-details"
            density="comfortable"
          />
        </v-col>

        <!-- NAMA SUAMI/ISTRI -->
        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.nama_pasangan"
            label="Nama Suami/Istri"
            variant="outlined"
            prepend-inner-icon="mdi-account-heart"
            density="comfortable"
          />
        </v-col>

        <!-- ALAMAT -->
        <v-col cols="12">
          <v-textarea
            v-model="form.alamat"
            label="Alamat"
            variant="outlined"
            rows="3"
            prepend-inner-icon="mdi-map-marker"
          />
        </v-col>

        <!-- PEKERJAAN -->
        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.pekerjaan"
            label="Pekerjaan"
            variant="outlined"
            prepend-inner-icon="mdi-briefcase"
            density="comfortable"
          />
        </v-col>

        <!-- GAJI PER BULAN -->
        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.gaji"
            label="Gaji per Bulan"
            variant="outlined"
            prepend-inner-icon="mdi-currency-usd"
            density="comfortable"
            prefix="Rp"
          />
        </v-col>

        <!-- CATATAN KUNJUNGAN -->
        <v-col cols="12">
          <v-textarea
            v-model="form.catatan"
            label="Catatan Kunjungan"
            variant="outlined"
            rows="4"
            auto-grow
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

      <div class="d-flex justify-end mt-4">
        <v-btn
          color="grey"
          size="large"
          variant="outlined"
          prepend-icon="mdi-refresh"
          class="rounded-lg mr-3"
          @click="resetForm"
        >
          Reset
        </v-btn>
        <v-btn
          color="primary"
          size="large"
          prepend-icon="mdi-content-save"
          class="rounded-lg"
          :loading="isLoading"
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
          <v-icon start color="primary">mdi-history</v-icon>
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

        <template v-slot:item.gaji="{ value }">
          Rp {{ Number(value).toLocaleString('id-ID') }}
        </template>

        <template v-slot:item.foto="{ item }">
          <v-btn
            v-if="item.foto"
            size="small"
            color="info"
            variant="tonal"
            :href="`http://127.0.0.1:8000/storage/${item.foto}`"
            target="_blank"
          >
            Lihat Foto
          </v-btn>
          <span v-else class="text-grey text-caption">Tidak ada</span>
        </template>

      </v-data-table>

    </v-card>

    <!-- SNACKBAR -->
    <v-snackbar
      v-model="snackbar.show"
      :color="snackbar.color"
      :timeout="3000"
      rounded="lg"
      location="top right"
    >
      <v-icon class="mr-2">{{ snackbar.icon }}</v-icon>
      {{ snackbar.message }}
    </v-snackbar>

  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const search    = ref('')
const isLoading = ref(false)

const pendidikanItems = ['SD', 'SMP', 'SMA/SMK', 'D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3']

const form = ref({
  nama_ktp:        '',
  nama_tanpa_gelar:'',
  pendidikan:      null,
  npwp:            '',
  no_ktp:          '',
  nama_pasangan:   '',
  alamat:          '',
  pekerjaan:       '',
  gaji:            '',
  catatan:         '', // ← tambahan
  foto:            null
})

const headers = [
  { title: 'NO',               key: 'no',               sortable: false },
  { title: 'NAMA KTP',         key: 'nama_ktp' },
  { title: 'NAMA TANPA GELAR', key: 'nama_tanpa_gelar' },
  { title: 'PENDIDIKAN',       key: 'pendidikan' },
  { title: 'NO KTP',           key: 'no_ktp' },
  { title: 'PEKERJAAN',        key: 'pekerjaan' },
  { title: 'GAJI',             key: 'gaji' },
  { title: 'CATATAN',          key: 'catatan' },
  { title: 'FOTO',             key: 'foto',             sortable: false }
]

const items = ref([])

// ========================
// SNACKBAR
// ========================
const snackbar = ref({ show: false, message: '', color: 'success', icon: 'mdi-check-circle' })

const showNotif = (message, color = 'success', icon = 'mdi-check-circle') => {
  snackbar.value = { show: true, message, color, icon }
}

// ========================
// FETCH LAPORAN (nasabah baru saja)
// ========================
const getLaporan = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.get(
      'http://127.0.0.1:8000/api/laporan-kunjungan', // index sudah difilter whereNotNull('nama_ktp')
      { headers: { Authorization: `Bearer ${token}` } }
    )
    items.value = response.data.data
  } catch (error) {
    console.error('Gagal fetch laporan:', error)
  }
}

// ========================
// SUBMIT
// ========================
const submitLaporan = async () => {
  isLoading.value = true
  try {
    const token = localStorage.getItem('token')
    const formData = new FormData()

    formData.append('nama_ktp',         form.value.nama_ktp)
    formData.append('nama_tanpa_gelar', form.value.nama_tanpa_gelar)
    formData.append('pendidikan',       form.value.pendidikan || '')
    formData.append('npwp',             form.value.npwp)
    formData.append('no_ktp',           form.value.no_ktp)
    formData.append('nama_pasangan',    form.value.nama_pasangan)
    formData.append('alamat',           form.value.alamat)
    formData.append('pekerjaan',        form.value.pekerjaan)
    formData.append('gaji',             form.value.gaji)
    formData.append('catatan',          form.value.catatan) // ← tambahan
    if (form.value.foto) formData.append('foto', form.value.foto)

    await axios.post(
      'http://127.0.0.1:8000/api/laporan-kunjungan',
      formData,
      {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type':  'multipart/form-data'
        }
      }
    )

    showNotif('Laporan berhasil disimpan!', 'success', 'mdi-check-circle')
    resetForm()
    await getLaporan()

  } catch (error) {
    const msg = error.response?.data?.message || 'Gagal menyimpan laporan'
    showNotif(msg, 'error', 'mdi-alert-circle')
    console.error(error)
  } finally {
    isLoading.value = false
  }
}

// ========================
// RESET
// ========================
const resetForm = () => {
  form.value = {
    nama_ktp:        '',
    nama_tanpa_gelar:'',
    pendidikan:      null,
    npwp:            '',
    no_ktp:          '',
    nama_pasangan:   '',
    alamat:          '',
    pekerjaan:       '',
    gaji:            '',
    catatan:         '', // ← tambahan
    foto:            null
  }
}

onMounted(() => {
  getLaporan()
})
</script>