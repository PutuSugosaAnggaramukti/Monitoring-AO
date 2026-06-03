<template>
  <v-container fluid class="pa-6 bg-grey-lighten-4" style="min-height: 100vh;">

    <!-- HEADER -->
    <v-card class="mb-6 pa-6 rounded-xl elevation-2" border>
      <div class="d-flex align-center">
        <div>
          <h1 class="text-h4 font-weight-bold text-primary mb-1">Jadwal Kunjungan</h1>
          <p class="text-subtitle-1 text-grey-darken-1 mb-0">
            Dashboard > <span class="font-weight-bold text-primary">Jadwal Kunjungan</span>
          </p>
        </div>
        <v-spacer></v-spacer>
        <v-icon size="64" color="blue-lighten-4">mdi-calendar-clock</v-icon>
      </div>
    </v-card>

    <!-- TABLE CARD -->
    <v-card class="rounded-xl elevation-2 overflow-hidden">

      <v-toolbar flat color="white" class="px-4">
        <v-toolbar-title class="font-weight-bold">
          <v-icon start color="primary">mdi-calendar-account</v-icon>
          Jadwal Kunjungan Nasabah
        </v-toolbar-title>
        <v-spacer></v-spacer>

        <!-- Filter Tab: Semua / Hari Ini / Riwayat -->
        <v-btn-toggle
          v-model="filterTab"
          color="primary"
          variant="outlined"
          density="compact"
          class="mr-3"
          mandatory
        >
          <v-btn value="semua" size="small">Semua</v-btn>
          <v-btn value="hari_ini" size="small">
            <v-icon start size="14">mdi-calendar-today</v-icon>
            Hari Ini
          </v-btn>
          <v-btn value="riwayat" size="small">
            <v-icon start size="14">mdi-history</v-icon>
            Riwayat
          </v-btn>
        </v-btn-toggle>

        <v-text-field
          v-model="search"
          prepend-inner-icon="mdi-magnify"
          label="Cari jadwal..."
          density="compact"
          variant="outlined"
          hide-details
          style="max-width: 220px;"
          class="mr-3"
        />

        <!-- Tombol Download -->
        <v-btn
          color="success"
          variant="tonal"
          prepend-icon="mdi-microsoft-excel"
          class="rounded-lg mr-2"
          :disabled="filteredItems.length === 0"
          @click="downloadExcel"
        >
          Download
        </v-btn>

        <v-btn
          color="primary"
          variant="flat"
          prepend-icon="mdi-plus"
          class="rounded-lg"
          @click="showModal = true"
        >
          Buat Jadwal
        </v-btn>
      </v-toolbar>

      <!-- Info jumlah data yang ditampilkan -->
      <div v-if="filterTab !== 'semua'" class="px-5 py-2 bg-blue-lighten-5 d-flex align-center">
        <v-icon size="16" color="primary" class="mr-2">mdi-information-outline</v-icon>
        <span class="text-caption text-primary">
          <template v-if="filterTab === 'hari_ini'">
            Menampilkan <strong>{{ filteredItems.length }}</strong> jadwal untuk hari ini ({{ formatDateShort(new Date()) }})
          </template>
          <template v-else>
            Menampilkan <strong>{{ filteredItems.length }}</strong> riwayat jadwal sebelum hari ini
          </template>
        </span>
      </div>

      <v-data-table
        :headers="headers"
        :items="filteredItems"
        :search="search"
        :loading="loadingTable"
        hover
      >
        <template v-slot:item.no="{ index }">{{ index + 1 }}</template>

        <template v-slot:item.tanggal_kunjungan="{ value }">
          <v-chip color="primary" size="small" variant="tonal">
            <v-icon start size="14">mdi-calendar</v-icon>
            {{ formatDate(value) }}
          </v-chip>
        </template>

        <template v-slot:item.status="{ value }">
          <v-chip :color="getStatusColor(value)" size="small" variant="flat">
            {{ value }}
          </v-chip>
        </template>

        <template v-slot:item.actions="{ item }">
          <div class="d-flex gap-1">
            <v-btn
              icon="mdi-check-circle"
              variant="text"
              size="small"
              color="success"
              title="Tandai Selesai"
              @click="updateStatus(item, 'Selesai')"
            />
            <v-btn
              icon="mdi-delete"
              variant="text"
              size="small"
              color="error"
              title="Hapus"
              @click="deleteJadwal(item.id)"
            />
          </div>
        </template>
      </v-data-table>

    </v-card>

    <!-- MODAL BUAT JADWAL -->
    <v-dialog v-model="showModal" max-width="700" scrollable>
      <v-card class="rounded-xl overflow-hidden">

        <div class="pa-5 bg-primary">
          <div class="d-flex align-center">
            <div>
              <div class="text-h6 font-weight-bold text-white">Buat Jadwal Kunjungan</div>
              <div class="text-body-2 text-blue-lighten-4 mt-1">Isi data jadwal kunjungan nasabah lama</div>
            </div>
            <v-spacer></v-spacer>
            <v-btn icon="mdi-close" variant="text" color="white" @click="closeModal" />
          </div>
        </div>

        <v-card-text class="pa-6">
          <v-row>
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
                :loading="loadingSearch"
                :no-filter="true"
                no-data-text="Tidak ada data nasabah..."
                @update:search="onSearch"
                @click="loadInitialNasabah"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                :model-value="selectedNasabah?.no_anggota || ''"
                label="No Anggota"
                readonly variant="outlined" density="comfortable"
                prepend-inner-icon="mdi-identifier" bg-color="grey-lighten-4"
              />
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                :model-value="selectedNasabah?.rekening_kredit || ''"
                label="Rekening Kredit"
                readonly variant="outlined" density="comfortable"
                prepend-inner-icon="mdi-credit-card" bg-color="grey-lighten-4"
              />
            </v-col>
            <v-col cols="12">
              <v-text-field
                :model-value="selectedNasabah?.nama || ''"
                label="Nama Nasabah"
                readonly variant="outlined" density="comfortable"
                prepend-inner-icon="mdi-account" bg-color="grey-lighten-4"
              />
            </v-col>
            <v-col cols="12">
              <v-textarea
                :model-value="selectedNasabah?.alamat || ''"
                label="Alamat"
                readonly variant="outlined" rows="2"
                prepend-inner-icon="mdi-map-marker" bg-color="grey-lighten-4"
              />
            </v-col>
            <v-col cols="12">
              <v-text-field
                v-model="form.tanggal_kunjungan"
                label="Tanggal Kunjungan"
                type="date"
                variant="outlined" density="comfortable"
                prepend-inner-icon="mdi-calendar" color="primary"
              />
            </v-col>
          </v-row>
        </v-card-text>

        <v-divider></v-divider>
        <v-card-actions class="pa-4">
          <v-spacer></v-spacer>
          <v-btn variant="text" color="grey" @click="closeModal">Batal</v-btn>
          <v-btn
            color="primary" variant="flat" class="rounded-lg"
            prepend-icon="mdi-content-save"
            :loading="loadingSubmit"
            @click="submitJadwal"
          >
            Simpan Jadwal
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- SNACKBAR -->
    <v-snackbar v-model="snackbar.show" :color="snackbar.color" :timeout="3000" rounded="lg" location="top right">
      <v-icon class="mr-2">{{ snackbar.icon }}</v-icon>
      {{ snackbar.message }}
    </v-snackbar>

  </v-container>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import axios from 'axios'
import * as XLSX from 'xlsx'

const search        = ref('')
const showModal     = ref(false)
const loadingTable  = ref(false)
const loadingSubmit = ref(false)
const loadingSearch = ref(false)
const jadwalItems   = ref([])
const nasabahItems  = ref([])
const selectedNasabah = ref(null)
const filterTab     = ref('semua') // 'semua' | 'hari_ini' | 'riwayat'
let searchTimeout   = null

const form = ref({ tanggal_kunjungan: '' })

const snackbar = ref({ show: false, message: '', color: 'success', icon: 'mdi-check-circle' })
const showNotif = (message, color = 'success', icon = 'mdi-check-circle') => {
  snackbar.value = { show: true, message, color, icon }
}

const headers = [
  { title: 'NO',               key: 'no',                    sortable: false },
  { title: 'NO ANGGOTA',       key: 'nasabah.no_anggota' },
  { title: 'REKENING KREDIT',  key: 'nasabah.rekening_kredit' },
  { title: 'NAMA NASABAH',     key: 'nasabah.nama' },
  { title: 'ALAMAT',           key: 'nasabah.alamat' },
  { title: 'TANGGAL KUNJUNGAN',key: 'tanggal_kunjungan' },
  { title: 'STATUS',           key: 'status' },
  { title: 'AKSI',             key: 'actions',               sortable: false },
]

// ========================
// FORMAT DATE
// ========================
const formatDate = (val) => {
  if (!val) return '-'
  return new Date(val).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
}

const formatDateShort = (val) => {
  if (!val) return '-'
  return new Date(val).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
}

// tanggal hari ini dalam format YYYY-MM-DD untuk perbandingan
const todayStr = new Date().toISOString().split('T')[0]

// ========================
// FILTERED ITEMS
// ========================
const filteredItems = computed(() => {
  if (filterTab.value === 'hari_ini') {
    return jadwalItems.value.filter(item => {
      const tgl = item.tanggal_kunjungan?.split('T')[0] ?? item.tanggal_kunjungan
      return tgl === todayStr
    })
  }
  if (filterTab.value === 'riwayat') {
    return jadwalItems.value.filter(item => {
      const tgl = item.tanggal_kunjungan?.split('T')[0] ?? item.tanggal_kunjungan
      return tgl < todayStr
    })
  }
  return jadwalItems.value
})

// ========================
// STATUS COLOR
// ========================
const getStatusColor = (status) => {
  if (status === 'Selesai')    return 'success'
  if (status === 'Dibatalkan') return 'error'
  return 'warning'
}

// ========================
// DOWNLOAD EXCEL
// ========================
const downloadExcel = () => {
  const label = filterTab.value === 'hari_ini'
    ? `Hari Ini (${formatDateShort(new Date())})`
    : filterTab.value === 'riwayat'
    ? 'Riwayat'
    : 'Semua'

  const rows = filteredItems.value.map((item, idx) => ({
    'No':               idx + 1,
    'No Anggota':       item.nasabah?.no_anggota    ?? '-',
    'Rekening Kredit':  item.nasabah?.rekening_kredit ?? '-',
    'Nama Nasabah':     item.nasabah?.nama           ?? '-',
    'Alamat':           item.nasabah?.alamat         ?? '-',
    'Tanggal Kunjungan':formatDate(item.tanggal_kunjungan),
    'Status':           item.status                  ?? '-',
  }))

  const ws = XLSX.utils.json_to_sheet(rows)

  // Lebar kolom otomatis
  ws['!cols'] = [
    { wch: 5 },   // No
    { wch: 14 },  // No Anggota
    { wch: 18 },  // Rekening Kredit
    { wch: 28 },  // Nama Nasabah
    { wch: 36 },  // Alamat
    { wch: 22 },  // Tanggal Kunjungan
    { wch: 20 },  // Status
  ]

  const wb = XLSX.utils.book_new()
  XLSX.utils.book_append_sheet(wb, ws, 'Jadwal Kunjungan')

  const fileName = `Jadwal_Kunjungan_${label.replace(/[^a-zA-Z0-9]/g, '_')}.xlsx`
  XLSX.writeFile(wb, fileName)

  showNotif(`File "${fileName}" berhasil diunduh`, 'success', 'mdi-check-circle')
}

// ========================
// SEARCH NASABAH
// ========================
const onSearch = (val) => {
  if (!val) return
  clearTimeout(searchTimeout)
  searchTimeout = setTimeout(async () => {
    try {
      loadingSearch.value = true
      const token = localStorage.getItem('token')
      const response = await axios.get(
        `http://127.0.0.1:8000/api/nasabah?search=${val}`,
        { headers: { Authorization: `Bearer ${token}` } }
      )
      nasabahItems.value = Array.isArray(response.data.data) ? response.data.data : []
    } catch (error) {
      console.error(error)
      nasabahItems.value = []
    } finally {
      loadingSearch.value = false
    }
  }, 300)
}

// ========================
// LOAD INITIAL NASABAH
// ========================
const loadInitialNasabah = async () => {
  if (nasabahItems.value.length > 0) return
  try {
    loadingSearch.value = true
    const token = localStorage.getItem('token')
    const response = await axios.get(
      'http://127.0.0.1:8000/api/nasabah?limit=20',
      { headers: { Authorization: `Bearer ${token}` } }
    )
    nasabahItems.value = Array.isArray(response.data.data) ? response.data.data : []
  } catch (error) {
    console.error(error)
  } finally {
    loadingSearch.value = false
  }
}

// ========================
// GET JADWAL
// ========================
const getJadwal = async () => {
  try {
    loadingTable.value = true
    const token = localStorage.getItem('token')
    const response = await axios.get(
      'http://127.0.0.1:8000/api/jadwal-kunjungan',
      { headers: { Authorization: `Bearer ${token}` } }
    )
    jadwalItems.value = response.data.data
  } catch (error) {
    console.error(error)
  } finally {
    loadingTable.value = false
  }
}

// ========================
// SUBMIT JADWAL
// ========================
const submitJadwal = async () => {
  if (!selectedNasabah.value) {
    showNotif('Pilih nasabah terlebih dahulu', 'error', 'mdi-alert-circle')
    return
  }
  if (!form.value.tanggal_kunjungan) {
    showNotif('Tanggal kunjungan wajib diisi', 'error', 'mdi-alert-circle')
    return
  }
  try {
    loadingSubmit.value = true
    const token = localStorage.getItem('token')
    await axios.post(
      'http://127.0.0.1:8000/api/jadwal-kunjungan',
      { nasabah_id: selectedNasabah.value.id, tanggal_kunjungan: form.value.tanggal_kunjungan },
      { headers: { Authorization: `Bearer ${token}` } }
    )
    showNotif('Jadwal berhasil dibuat!', 'success', 'mdi-check-circle')
    closeModal()
    await getJadwal()
  } catch (error) {
    showNotif(error.response?.data?.message || 'Gagal membuat jadwal', 'error', 'mdi-alert-circle')
  } finally {
    loadingSubmit.value = false
  }
}

// ========================
// UPDATE STATUS
// ========================
const updateStatus = async (item, status) => {
  try {
    const token = localStorage.getItem('token')
    await axios.put(
      `http://127.0.0.1:8000/api/jadwal-kunjungan/${item.id}`,
      { status },
      { headers: { Authorization: `Bearer ${token}` } }
    )
    showNotif('Status berhasil diperbarui!', 'success', 'mdi-check-circle')
    await getJadwal()
  } catch (error) {
    showNotif('Gagal memperbarui status', 'error', 'mdi-alert-circle')
  }
}

// ========================
// DELETE JADWAL
// ========================
const deleteJadwal = async (id) => {
  if (!confirm('Yakin ingin menghapus jadwal ini?')) return
  try {
    const token = localStorage.getItem('token')
    await axios.delete(
      `http://127.0.0.1:8000/api/jadwal-kunjungan/${id}`,
      { headers: { Authorization: `Bearer ${token}` } }
    )
    showNotif('Jadwal berhasil dihapus!', 'success', 'mdi-check-circle')
    await getJadwal()
  } catch (error) {
    showNotif('Gagal menghapus jadwal', 'error', 'mdi-alert-circle')
  }
}

// ========================
// CLOSE MODAL
// ========================
const closeModal = () => {
  showModal.value = false
  selectedNasabah.value = null
  nasabahItems.value = []
  form.value = { tanggal_kunjungan: '' }
}

onMounted(() => { getJadwal() })
</script>

<style scoped>
.gap-1 { gap: 4px; }
</style>