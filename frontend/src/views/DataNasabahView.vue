<template>
  <v-container fluid class="pa-6 bg-grey-lighten-4" style="min-height: 100vh;">
    <v-card class="mb-6 pa-6 rounded-xl elevation-2" border>
      <div class="d-flex align-center">
        <div>
          <h1 class="text-h4 font-weight-bold text-primary mb-1">Data Nasabah</h1>
          <p class="text-subtitle-1 text-grey-darken-1 mb-0">
            Dashboard > <span class="font-weight-bold text-primary">Data Nasabah</span>
          </p>
        </div>
        <v-spacer></v-spacer>
        <v-icon size="64" color="blue-lighten-4">mdi-account-group-outline</v-icon>
      </div>
    </v-card>

    <v-card class="mb-6 pa-4 rounded-xl elevation-2">
      <v-row align="center">
        <v-col cols="12" md="8" class="d-flex flex-wrap gap-2">
          <v-btn color="success" prepend-icon="mdi-file-export" variant="flat" class="rounded-lg" @click="showExport = true">Export</v-btn>
          <v-btn color="primary" prepend-icon="mdi-file-upload" variant="flat" class="rounded-lg" @click="showImportData = true">Import Data</v-btn>
          <v-btn color="indigo-darken-2" prepend-icon="mdi-plus" variant="elevated" class="rounded-lg" @click="showAddNasabah = true">Tambah Nasabah</v-btn>
        </v-col>
        
        <v-col cols="12" md="4">
          <v-text-field
            v-model="search"
            prepend-inner-icon="mdi-magnify"
            label="Cari nama atau no. angsuran..."
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
      <v-toolbar color="white" flat class="clickable-toolbar">
        <v-tabs 
          v-model="activeTab" 
          color="primary" 
          align-tabs="start"
          slider-color="primary"
          mandatory
        >
          <v-tab value="lancar" class="text-none font-weight-bold">
            Lancar <v-chip size="x-small" class="ml-2" color="success" variant="flat">6728</v-chip>
          </v-tab>
          <v-tab value="dpk" class="text-none font-weight-bold">
            DPK <v-chip size="x-small" class="ml-2" color="warning" variant="flat">297</v-chip>
          </v-tab>
          <v-tab value="kurang_lancar" class="text-none font-weight-bold">
            Kurang Lancar <v-chip size="x-small" class="ml-2" color="orange" variant="flat">30</v-chip>
          </v-tab>
          <v-tab value="diragukan" class="text-none font-weight-bold">
            Diragukan <v-chip size="x-small" class="ml-2" color="error" variant="flat">22</v-chip>
          </v-tab>
          <v-tab value="macet" class="text-none font-weight-bold">
            Macet <v-chip size="x-small" class="ml-2" color="red-darken-4" variant="flat">133</v-chip>
          </v-tab>
        </v-tabs>
      </v-toolbar>
    </v-card>

    <v-card class="rounded-xl elevation-2 overflow-hidden">
      <v-data-table
        :headers="headers"
        :items="filteredNasabah"
        :search="search"
        hover
        class="text-no-wrap custom-table"
      >
        <template v-slot:item.no="{ index }">
          {{ index + 1 }}
        </template>
        <template v-slot:item.nominal="{ value }">
          <span class="font-weight-medium">Rp {{ value }}</span>
        </template>
        <template v-slot:item.actions="{ item }">
          <div class="d-flex gap-1">
            <v-btn icon="mdi-eye" variant="text" size="small" color="blue" title="Detail"></v-btn>
            <v-btn icon="mdi-pencil" variant="text" size="small" color="orange" title="Edit"></v-btn>
          </div>
        </template>
      </v-data-table>
    </v-card>

    <v-dialog v-model="showExport" max-width="400">
      <v-card class="rounded-xl pa-4">
        <v-card-title class="text-h5 font-weight-bold">Export Data Nasabah</v-card-title>
        <v-card-text>Apakah Anda yakin ingin mengekspor data ini ke format Excel?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn variant="text" @click="showExport = false">Batal</v-btn>
          <v-btn color="success" variant="flat" class="rounded-lg" @click="showExport = false">Download</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

   <!-- MODAL IMPORT DATA -->
    <v-dialog v-model="showImportData" max-width="650">
      <v-card class="rounded-xl overflow-hidden">

        <!-- HEADER -->
        <div class="pa-5 bg-primary">
          <div class="d-flex align-center">
            <div>
              <div class="text-h5 font-weight-bold text-white">
                Import Master Data Nasabah
              </div>

              <div class="text-body-2 text-blue-lighten-4 mt-1">
                Upload file Excel / CSV untuk menambahkan data nasabah
              </div>
            </div>

            <v-spacer></v-spacer>

            <v-icon size="50" color="white">
              mdi-file-upload-outline
            </v-icon>
          </div>
        </div>

        <v-card-text class="pa-5">

          <!-- ALERT -->
          <v-alert
            type="info"
            variant="tonal"
            class="mb-5"
            border="start"
          >
            Format file yang didukung:
            <strong>.xlsx</strong>,
            <strong>.xls</strong>,
            dan
            <strong>.csv</strong>
          </v-alert>

          <!-- FILE INPUT -->
          <v-file-input
            v-model="importFile"
            label="Pilih File Master Data"
            prepend-icon=""
            prepend-inner-icon="mdi-paperclip"
            variant="outlined"
            density="comfortable"
            color="primary"
            show-size
            accept=".xlsx,.xls,.csv"
            class="rounded-lg"
          ></v-file-input>


         <!-- PREVIEW -->
          <v-card
            v-if="importFile"
            class="mt-5 pa-4 rounded-lg"
            color="grey-lighten-4"
            flat
          >
            <div class="d-flex align-center">

              <v-icon color="success" class="mr-3">
                mdi-file-excel
              </v-icon>

              <div>
                <div class="font-weight-bold">
                  {{ importFile.name }}
                </div>

                <div class="text-caption text-grey">
                  {{ (importFile.size / 1024).toFixed(2) }} KB
                </div>
              </div>

            </div>
          </v-card>
        </v-card-text>

        <v-divider></v-divider>

        <!-- ACTION -->
        <v-card-actions class="pa-4">
          <v-spacer></v-spacer>

          <v-btn
            variant="text"
            @click="showImportData = false"
          >
            Batal
          </v-btn>

          <v-btn
            color="primary"
            variant="flat"
            class="rounded-lg"
            prepend-icon="mdi-upload"
            :loading="loadingImport"
            @click="handleImport"
          >
            Upload Data
          </v-btn>
        </v-card-actions>

      </v-card>
    </v-dialog>

    <v-dialog v-model="showAddNasabah" max-width="800" scrollable>
      <v-card class="rounded-xl pa-4">
        <v-card-title class="text-h5 font-weight-bold text-indigo-darken-2">Form Tambah Nasabah</v-card-title>
        <v-divider class="my-2"></v-divider>
        <v-card-text>
          <v-row>
            <v-col cols="12" md="6"><v-text-field label="Kode" variant="outlined" density="compact"></v-text-field></v-col>
            <v-col cols="12" md="6"><v-text-field label="No. Anggota" variant="outlined" density="compact"></v-text-field></v-col>
            <v-col cols="12" md="6"><v-text-field label="Rekening Kredit" variant="outlined" density="compact"></v-text-field></v-col>
            <v-col cols="12" md="6"><v-text-field label="Nama Nasabah" variant="outlined" density="compact"></v-text-field></v-col>
            <v-col cols="12"><v-textarea label="Alamat" variant="outlined" density="compact" rows="2"></v-textarea></v-col>
            <v-col cols="12" md="6"><v-text-field label="Tgl Pinjam" type="date" variant="outlined" density="compact"></v-text-field></v-col>
            <v-col cols="12" md="6"><v-text-field label="Tgl JT" type="date" variant="outlined" density="compact"></v-text-field></v-col>
            <v-col cols="12"><v-text-field label="Nominal" prefix="Rp" variant="outlined" density="compact"></v-text-field></v-col>
          </v-row>
        </v-card-text>
        <v-divider class="my-2"></v-divider>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn variant="text" @click="showAddNasabah = false">Batal</v-btn>
          <v-btn color="indigo-darken-2" variant="flat" class="rounded-lg">Simpan Data</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

  </v-container>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import axios from 'axios'

const search = ref('')
const activeTab = ref('lancar')

// Kontrol Import Data
const importFile = ref(null)
const loadingImport = ref(false)
const filteredNasabah = computed(() => {

  return nasabahItems.value.filter(item => {

    return item.status === activeTab.value

  })

})

// Kontrol Modal
const showExport = ref(false)
const showImportData = ref(false)
const showAddNasabah = ref(false)

const handleImport = async () => {

  if (!importFile.value) {
    alert('Pilih file terlebih dahulu')
    return
  }

  try {

    loadingImport.value = true

    const token = localStorage.getItem('token')

    const formData = new FormData()

    formData.append(
      'file',
      importFile.value
    )

    const response = await axios.post(

      'http://127.0.0.1:8000/api/nasabah/import',

      formData,

      {
        headers: {
          'Content-Type': 'multipart/form-data',
          'Authorization': `Bearer ${token}`
        }
      }
    )

    alert(response.data.message)

    await getNasabah()

    importFile.value = null

    showImportData.value = false

  } catch (error) {

    console.error(error)

    alert(
      error.response?.data?.message ||
      'Import gagal'
    )

  } finally {

    loadingImport.value = false
  }
}

const getNasabah = async () => {

  try {

    const token = localStorage.getItem('token')

    const response = await axios.get(
      'http://127.0.0.1:8000/api/nasabah',
      {
        headers: {
          Authorization: `Bearer ${token}`
        }
      }
    )

    console.log(response.data)

    nasabahItems.value = response.data.data || []

  } catch (error) {

    console.error(error)
  }
}

const headers = [
  { title: 'No', key: 'no', sortable: false },
  { title: 'Kode', key: 'kode' },
  { title: 'No. Anggota', key: 'no_anggota' },
  { title: 'Rekening Kredit', key: 'rekening_kredit' },
  { title: 'Nama Nasabah', key: 'nama' },
  { title: 'Alamat', key: 'alamat' },
  { title: 'Tgl Pinjam', key: 'tgl_pinjam' },
  { title: 'Tgl JT', key: 'tgl_jt' },
  { title: 'Nominal', key: 'nominal' },
  { title: 'Aksi', key: 'actions', sortable: false },
]

const nasabahItems = ref([])

onMounted(() => {
  getNasabah()
})
</script>

<style scoped>
.gap-2 { gap: 12px; }
.gap-1 { gap: 4px; }

/* Menjaga navigasi tab tetap bisa diklik di dalam toolbar */
.clickable-toolbar :deep(.v-toolbar__content) {
  pointer-events: auto !important;
}

.v-tab--selected {
  background-color: rgba(45, 90, 163, 0.05) !important;
}

:deep(.v-tabs-slider) {
  height: 3px !important;
}

.custom-table :deep(thead) {
  background-color: #f8fafc !important;
}

.custom-table :deep(th) {
  font-weight: 700 !important;
  color: #475569 !important;
  text-transform: uppercase;
  font-size: 12px !important;
  letter-spacing: 0.5px;
}
</style>