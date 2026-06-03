<template>
  <v-container fluid class="pa-6 bg-grey-lighten-4" style="min-height: 100vh;">

    <!-- HEADER -->
    <v-card class="mb-6 pa-6 rounded-xl elevation-2" border>
      <div class="d-flex align-center">
        <div>
          <h1 class="text-h4 font-weight-bold text-primary mb-1">
            Laporan Kunjungan
          </h1>
          <p class="text-subtitle-1 text-grey-darken-1 mb-0">
            Dashboard >
            <span class="font-weight-bold text-primary">Laporan Kunjungan</span>
          </p>
        </div>
        <v-spacer></v-spacer>
        <v-icon size="64" color="blue-lighten-4">mdi-account-clock-outline</v-icon>
      </div>
    </v-card>

    <!-- FORM -->
    <v-card class="rounded-xl elevation-2 pa-6 mb-6">

      <div class="text-h6 font-weight-bold mb-5">Form Kunjungan Nasabah</div>

      <v-row>

        <!-- PILIH NASABAH -->
        <v-col cols="12">
          <v-autocomplete
            v-model="selectedNasabah"
            :items="nasabahItems"
            item-title="nama"
            item-value="id"
            return-object
            label="Pilih Nasabah"
            prepend-inner-icon="mdi-account-search"
            variant="outlined"
            density="comfortable"
            color="primary"
            clearable
          />
        </v-col>

        <!-- AUTO FILL -->
        <v-col cols="12" md="6">
          <v-text-field
            :model-value="selectedNasabah?.no_anggota || ''"
            label="No Anggota"
            readonly
            variant="outlined"
            density="comfortable"
          />
        </v-col>

        <v-col cols="12" md="6">
          <v-text-field
            :model-value="selectedNasabah?.rekening_kredit || ''"
            label="Rekening Kredit"
            readonly
            variant="outlined"
            density="comfortable"
          />
        </v-col>

        <v-col cols="12">
          <v-text-field
            :model-value="selectedNasabah?.nama || ''"
            label="Nama Nasabah"
            readonly
            variant="outlined"
            density="comfortable"
          />
        </v-col>

        <v-col cols="12">
          <v-textarea
            :model-value="selectedNasabah?.alamat || ''"
            label="Alamat"
            readonly
            variant="outlined"
            rows="2"
          />
        </v-col>

        <!-- FORM KUNJUNGAN -->
        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.tanggal_kunjungan"
            label="Tanggal Kunjungan"
            type="date"
            variant="outlined"
            density="comfortable"
          />
        </v-col>

        <v-col cols="12" md="6">
          <v-text-field
            v-model="form.kunjungan_ke"
            label="Kunjungan Ke"
            type="number"
            variant="outlined"
            density="comfortable"
          />
        </v-col>

        <v-col cols="12">
          <v-textarea
            v-model="form.catatan"
            label="Catatan Kunjungan"
            variant="outlined"
            rows="4"
            auto-grow
          />
        </v-col>

        <!-- FOTO -->
        <v-col cols="12">
          <v-file-input
            v-model="form.foto"
            label="Upload Foto Kunjungan"
            prepend-inner-icon="mdi-camera"
            prepend-icon=""
            variant="outlined"
            density="comfortable"
            accept="image/*"
            show-size
          />
        </v-col>

        <!-- PREVIEW FOTO -->
        <v-col cols="12" v-if="previewImage">
          <v-card class="pa-4 rounded-xl" flat color="grey-lighten-4">
            <div class="text-subtitle-2 mb-3 font-weight-bold">Preview Foto</div>
            <v-img :src="previewImage" max-height="300" contain class="rounded-lg" />
          </v-card>
        </v-col>

      </v-row>

      <!-- ACTION -->
      <div class="d-flex justify-end mt-6 gap-2">
        <v-btn variant="text" color="grey" @click="resetForm">Batal</v-btn>
        <v-btn
          color="primary"
          variant="flat"
          class="rounded-lg"
          prepend-icon="mdi-content-save"
          :loading="loadingSubmit"
          @click="submitLaporan"
        >
          Simpan Laporan
        </v-btn>
      </div>

    </v-card>

    <!-- TABEL RIWAYAT -->
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
        :items="laporanItems"
        :search="search"
        :loading="loadingTable"
        hover
      >
        <template v-slot:item.no="{ index }">
          {{ index + 1 }}
        </template>

        <template v-slot:item.nasabah="{ item }">
          <div class="font-weight-medium">{{ item.nasabah?.nama || '-' }}</div>
          <div class="text-caption text-grey">{{ item.nasabah?.no_anggota || '-' }}</div>
        </template>

        <template v-slot:item.kunjungan_ke="{ value }">
          <v-chip size="small" color="primary" variant="tonal">
            Ke-{{ value }}
          </v-chip>
        </template>

        <template v-slot:item.foto="{ item }">
          <v-btn
            v-if="item.foto"
            size="small"
            color="info"
            variant="tonal"
            :href="'http://127.0.0.1:8000/storage/' + item.foto"
            target="_blank"
          >
            Lihat Foto
          </v-btn>
          <span v-else class="text-grey text-caption">Tidak ada</span>
        </template>

        <template v-slot:item.actions="{ item }">
          <v-btn
            icon="mdi-delete"
            variant="text"
            size="small"
            color="error"
            @click="deleteLaporan(item.id)"
          />
        </template>

      </v-data-table>

    </v-card>

  </v-container>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'

const nasabahItems    = ref([])
const selectedNasabah = ref(null)
const loadingSubmit   = ref(false)
const loadingTable    = ref(false)
const previewImage    = ref(null)
const search          = ref('')
const laporanItems    = ref([])

const form = ref({
  tanggal_kunjungan: '',
  kunjungan_ke: 1,
  catatan: '',
  foto: null
})

const headers = [
  { title: 'NO',            key: 'no',               sortable: false },
  { title: 'NASABAH',       key: 'nasabah',          sortable: false },
  { title: 'TANGGAL',       key: 'tanggal_kunjungan' },
  { title: 'KUNJUNGAN KE',  key: 'kunjungan_ke' },
  { title: 'CATATAN',       key: 'catatan' },
  { title: 'FOTO',          key: 'foto',             sortable: false },
  { title: 'AKSI',          key: 'actions',          sortable: false },
]

// ========================
// GET NASABAH DROPDOWN
// ========================
const getDropdownNasabah = async () => {
  try {
    const token = localStorage.getItem('token')
    const response = await axios.get(
      'http://127.0.0.1:8000/api/jadwal-kunjungan/dropdown-nasabah',
      { headers: { Authorization: `Bearer ${token}` } }
    )
    nasabahItems.value = response.data.map(item => ({
      ...item,
      nama: `${item.nama} (${item.tanggal})`
    }))
  } catch (error) {
    console.error(error)
  }
}

// ========================
// GET LAPORAN NASABAH LAMA
// ========================
const getLaporan = async () => {
  try {
    loadingTable.value = true
    const token = localStorage.getItem('token')
    const response = await axios.get(
      'http://127.0.0.1:8000/api/laporan-kunjungan/lama', // ← hanya laporan nasabah lama
      { headers: { Authorization: `Bearer ${token}` } }
    )
    laporanItems.value = response.data.data
  } catch (error) {
    console.error(error)
  } finally {
    loadingTable.value = false
  }
}

// ========================
// PREVIEW IMAGE
// ========================
watch(() => form.value.foto, (file) => {
  if (!file) { previewImage.value = null; return }
  previewImage.value = URL.createObjectURL(file)
})

// ========================
// SUBMIT
// ========================
const submitLaporan = async () => {
  if (!selectedNasabah.value) {
    alert('Pilih nasabah terlebih dahulu')
    return
  }

  try {
    loadingSubmit.value = true
    const token = localStorage.getItem('token')
    const formData = new FormData()

    formData.append('nasabah_id',        selectedNasabah.value.id)
    formData.append('tanggal_kunjungan', form.value.tanggal_kunjungan)
    formData.append('kunjungan_ke',      form.value.kunjungan_ke)
    formData.append('catatan',           form.value.catatan)
    if (form.value.foto) formData.append('foto', form.value.foto)

    const response = await axios.post(
      'http://127.0.0.1:8000/api/laporan-kunjungan/lama',
      formData,
      {
        headers: {
          Authorization: `Bearer ${token}`,
          'Content-Type': 'multipart/form-data'
        }
      }
    )

    alert(response.data.message)
    resetForm()
    await getLaporan()

  } catch (error) {
    console.error(error)
    alert(error.response?.data?.message || 'Gagal menyimpan laporan')
  } finally {
    loadingSubmit.value = false
  }
}

// ========================
// DELETE
// ========================
const deleteLaporan = async (id) => {
  if (!confirm('Yakin ingin menghapus laporan ini?')) return
  try {
    const token = localStorage.getItem('token')
    await axios.delete(
      `http://127.0.0.1:8000/api/laporan-kunjungan/${id}`,
      { headers: { Authorization: `Bearer ${token}` } }
    )
    await getLaporan()
  } catch (error) {
    console.error(error)
    alert('Gagal menghapus laporan')
  }
}

// ========================
// RESET
// ========================
const resetForm = () => {
  selectedNasabah.value = null
  form.value = { tanggal_kunjungan: '', kunjungan_ke: 1, catatan: '', foto: null }
  previewImage.value = null
}

onMounted(() => {
  getDropdownNasabah()
  getLaporan()
})
</script>

<style scoped>
.gap-2 { gap: 12px; }
</style>