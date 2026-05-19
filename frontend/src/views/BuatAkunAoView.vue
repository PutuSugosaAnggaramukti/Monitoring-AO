<template>
  <v-container fluid class="pa-6">

    <!-- HEADER -->
    <v-card class="mb-6 pa-6 rounded-xl elevation-2 dashboard-header">
      <div class="d-flex align-center flex-wrap">
        <div>
          <h1 class="text-h4 font-weight-bold text-primary mb-2">
            Buat Akun Baru AO
          </h1>
          <div class="text-subtitle-1 text-grey-darken-1">
            Tambahkan Account Officer baru ke sistem,
            <span class="font-weight-bold text-secondary">
              Administrator
            </span>
            👋
          </div>
        </div>

        <v-spacer></v-spacer>

        <div class="text-right mr-5">
          <div class="text-caption text-uppercase text-grey font-weight-bold">
            Waktu Sistem
          </div>
          <div class="text-h4 font-weight-black text-primary">
            {{ currentTime }}
          </div>
        </div>

        <v-avatar size="72" color="blue-lighten-5">
          <v-icon size="42" color="primary">mdi-account-plus</v-icon>
        </v-avatar>
      </div>
    </v-card>

    <v-row>

      <!-- FORM BUAT AKUN -->
      <v-col cols="12" lg="7">
        <v-card class="rounded-xl elevation-2 pa-6">

          <div class="d-flex align-center mb-6">
            <v-icon color="primary" class="mr-2">mdi-account-edit</v-icon>
            <div class="text-h6 font-weight-bold">Form Pendaftaran AO</div>
          </div>

          <v-form ref="formRef" v-model="formValid">

            <!-- NAMA LENGKAP -->
            <div class="text-caption font-weight-bold text-grey-darken-1 mb-1 text-uppercase">
              Nama Lengkap
            </div>
            <v-text-field
              v-model="form.namaLengkap"
              placeholder="Masukkan nama lengkap AO"
              variant="outlined"
              rounded="lg"
              density="comfortable"
              prepend-inner-icon="mdi-account"
              :rules="[rules.required]"
              class="mb-3"
            />

            <!-- USERNAME -->
            <div class="text-caption font-weight-bold text-grey-darken-1 mb-1 text-uppercase">
              Username
            </div>
            <v-text-field
              v-model="form.username"
              placeholder="Masukkan username"
              variant="outlined"
              rounded="lg"
              density="comfortable"
              prepend-inner-icon="mdi-card-account-details"
              :rules="[rules.required, rules.noSpace]"
              class="mb-3"
            />

            <!-- NO HP -->
            <div class="text-caption font-weight-bold text-grey-darken-1 mb-1 text-uppercase">
              No. HP
            </div>
            <v-text-field
              v-model="form.noHp"
              placeholder="Masukkan nomor HP AO"
              variant="outlined"
              rounded="lg"
              density="comfortable"
              prepend-inner-icon="mdi-phone"
              :rules="[rules.required, rules.phone]"
              class="mb-3"
            />

            <!-- WILAYAH -->
            <div class="text-caption font-weight-bold text-grey-darken-1 mb-1 text-uppercase">
              Wilayah
            </div>
            <v-select
              v-model="form.wilayah"
              :items="wilayahOptions"
              placeholder="Pilih wilayah kecamatan AO"
              variant="outlined"
              rounded="lg"
              density="comfortable"
              prepend-inner-icon="mdi-map-marker"
              :rules="[rules.required]"
              class="mb-3"
            />

            <!-- PASSWORD -->
            <div class="text-caption font-weight-bold text-grey-darken-1 mb-1 text-uppercase">
              Password
            </div>
            <v-text-field
              v-model="form.password"
              placeholder="Masukkan password"
              variant="outlined"
              rounded="lg"
              density="comfortable"
              prepend-inner-icon="mdi-lock"
              :type="showPassword ? 'text' : 'password'"
              :append-inner-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
              @click:append-inner="showPassword = !showPassword"
              :rules="[rules.required, rules.minLength]"
              class="mb-3"
            />

            <!-- KONFIRMASI PASSWORD -->
            <div class="text-caption font-weight-bold text-grey-darken-1 mb-1 text-uppercase">
              Konfirmasi Password
            </div>
            <v-text-field
              v-model="form.konfirmasiPassword"
              placeholder="Ulangi password"
              variant="outlined"
              rounded="lg"
              density="comfortable"
              prepend-inner-icon="mdi-lock-check"
              :type="showKonfirmasi ? 'text' : 'password'"
              :append-inner-icon="showKonfirmasi ? 'mdi-eye-off' : 'mdi-eye'"
              @click:append-inner="showKonfirmasi = !showKonfirmasi"
              :rules="[rules.required, rules.matchPassword]"
              class="mb-5"
            />

            <!-- ACTION BUTTONS -->
            <div class="d-flex gap-3">
              <v-btn
                color="primary"
                size="large"
                rounded="lg"
                prepend-icon="mdi-account-plus"
                :loading="isLoading"
                :disabled="!formValid"
                @click="submitForm"
                class="flex-grow-1"
              >
                Buat Akun AO
              </v-btn>

              <v-btn
                color="grey"
                size="large"
                rounded="lg"
                variant="outlined"
                prepend-icon="mdi-refresh"
                @click="resetForm"
              >
                Reset
              </v-btn>
            </div>

          </v-form>
        </v-card>
      </v-col>

      <!-- SIDE INFO -->
      <v-col cols="12" lg="5">

        <!-- STATISTIK AKUN -->
        <v-card class="rounded-xl elevation-2 pa-5 mb-5">
          <div class="d-flex align-center mb-4">
            <v-icon color="primary" class="mr-2">mdi-account-group</v-icon>
            <div class="text-h6 font-weight-bold">Statistik AO</div>
          </div>

          <v-row>
            <v-col cols="6">
              <v-card class="pa-4 rounded-xl text-center" color="blue-lighten-5" flat>
                <div class="text-h4 font-weight-black text-primary">{{ totalAO }}</div>
                <div class="text-caption text-grey-darken-1 mt-1">Total AO</div>
              </v-card>
            </v-col>
            <v-col cols="6">
              <v-card class="pa-4 rounded-xl text-center" color="green-lighten-5" flat>
                <div class="text-h4 font-weight-black text-success">{{ totalAOAktif }}</div>
                <div class="text-caption text-grey-darken-1 mt-1">AO Aktif</div>
              </v-card>
            </v-col>
          </v-row>
        </v-card>

        <!-- DAFTAR AO TERBARU -->
        <v-card class="rounded-xl elevation-2 pa-5 mb-5">
          <div class="d-flex align-center mb-4">
            <v-icon color="primary" class="mr-2">mdi-history</v-icon>
            <div class="text-h6 font-weight-bold">Daftar AO Aktif</div>
          </div>

            <v-list lines="two" class="pa-0">
  
                <!-- empty state -->
                <div v-if="recentAO.length === 0" class="text-center text-grey py-6">
                    <v-icon size="40" color="grey-lighten-1">mdi-account-off</v-icon>
                    <div class="text-caption mt-2">Belum ada AO yang didaftarkan</div>
                </div>

                <v-list-item
                    v-for="ao in recentAO"
                    :key="ao.username"
                    :subtitle="ao.wilayah + ' · ' + ao.tanggal"
                    rounded="lg"
                    class="mb-1"
                >
                    <template v-slot:title>
                    <span class="font-weight-bold">{{ ao.nama }}</span>
                    </template>
                    <template v-slot:prepend>
                    <v-avatar color="blue-lighten-5" size="40">
                        <v-icon color="primary">mdi-account</v-icon>
                    </v-avatar>
                    </template>
                    <template v-slot:append>
                    <v-chip color="primary" size="small" variant="flat">
                        {{ ao.wilayah }}
                    </v-chip>
                    </template>
                </v-list-item>

            </v-list>
        </v-card>

        <!-- KETENTUAN PASSWORD -->
        <v-card class="rounded-xl elevation-2 pa-5">
          <div class="d-flex align-center mb-4">
            <v-icon color="warning" class="mr-2">mdi-shield-lock</v-icon>
            <div class="text-h6 font-weight-bold">Ketentuan Password</div>
          </div>

          <v-alert type="info" variant="tonal" density="compact" class="mb-3">
            Minimal 8 karakter
          </v-alert>
          <v-alert type="warning" variant="tonal" density="compact" class="mb-3">
            Kombinasi huruf dan angka
          </v-alert>
          <v-alert type="success" variant="tonal" density="compact">
            Hindari informasi pribadi
          </v-alert>
        </v-card>

      </v-col>
    </v-row>

    <!-- SNACKBAR NOTIFIKASI -->
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
import { ref, onMounted, onUnmounted } from 'vue'
import axios from 'axios'

// ========================
// WAKTU SISTEM
// ========================
const currentTime = ref('')
let timer

const updateTime = () => {
  const now = new Date()
  currentTime.value = now.toLocaleTimeString('id-ID', {
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: false
  })
}

onMounted(async () => {
  updateTime()
  timer = setInterval(updateTime, 1000)
  await fetchAO()
})

onUnmounted(() => {
  if (timer) clearInterval(timer)
})

// ========================
// FORM STATE
// ========================
const formRef = ref(null)
const formValid = ref(false)
const isLoading = ref(false)
const showPassword = ref(false)
const showKonfirmasi = ref(false)

const form = ref({
  namaLengkap: '',
  username: '',
  noHp: '',
  wilayah: null,
  password: '',
  konfirmasiPassword: ''
})

const wilayahOptions = [
  'Bambanglipuro',
  'Banguntapan',
  'Bantul',
  'Dlingo',
  'Imogiri',
  'Jetis',
  'Kasihan',
  'Kretek',
  'Pajangan',
  'Pandak',
  'Piyungan',
  'Pleret',
  'Pundong',
  'Sanden',
  'Sedayu',
  'Sewon',
  'Srandakan'
]

// ========================
// VALIDASI
// ========================
const rules = {
  required: v => !!v || 'Field ini wajib diisi',
  noSpace: v => !/\s/.test(v) || 'Username tidak boleh mengandung spasi',
  phone: v => /^[0-9]{10,13}$/.test(v) || 'Nomor HP tidak valid (10-13 digit)',
  minLength: v => (v && v.length >= 8) || 'Password minimal 8 karakter',
  matchPassword: v => v === form.value.password || 'Password tidak cocok'
}

// ========================
// STATISTIK & DATA
// ========================
const totalAO = ref(12)
const totalAOAktif = ref(10)

const recentAO = ref([])

// ========================
// FETCH DATA AO
// ========================
const fetchAO = async () => {
  try {
    const token = localStorage.getItem('token')

    const response = await axios.get(
      'http://127.0.0.1:8000/api/account-officer',
      {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      }
    )

    const data = response.data.data

    // update statistik
    totalAO.value = data.length
    totalAOAktif.value = data.length

    // update list
    recentAO.value = data.map(ao => ({
      nama:     ao.nama_lengkap,
      username: ao.username,
      wilayah:  ao.wilayah,
      tanggal:  new Date(ao.created_at).toLocaleDateString('id-ID', {
        day: 'numeric', month: 'long', year: 'numeric'
      })
    }))

  } catch (error) {
    console.error('Gagal fetch data AO:', error)
  }
}


// ========================
// SNACKBAR
// ========================
const snackbar = ref({
  show: false,
  message: '',
  color: 'success',
  icon: 'mdi-check-circle'
})

const showNotif = (message, color = 'success', icon = 'mdi-check-circle') => {
  snackbar.value = { show: true, message, color, icon }
}

// ========================
// SUBMIT & RESET
// ========================
const submitForm = async () => {
  const { valid } = await formRef.value.validate()
  if (!valid) return

  isLoading.value = true

  try {
    const token = localStorage.getItem('token')

    const response = await axios.post(
      'http://127.0.0.1:8000/api/account-officer',
      {
        nama_lengkap: form.value.namaLengkap,
        username:     form.value.username,
        no_hp:        form.value.noHp,
        wilayah:      form.value.wilayah,
        password:     form.value.password
      },
      {
        headers: {
          'Authorization': `Bearer ${token}`,
          'Accept': 'application/json'
        }
      }
    )

    recentAO.value.unshift({
      nama:     form.value.namaLengkap,
      username: form.value.username,
      wilayah:  form.value.wilayah,
      tanggal:  new Date().toLocaleDateString('id-ID', {
        day: 'numeric', month: 'long', year: 'numeric'
      })
    })

    totalAO.value++
    totalAOAktif.value++

    showNotif(`Akun AO "${form.value.namaLengkap}" berhasil dibuat!`, 'success', 'mdi-check-circle')
    resetForm()

  } catch (error) {
    const errors = error.response?.data?.errors
    if (errors) {
      const firstError = Object.values(errors)[0][0]
      showNotif(firstError, 'error', 'mdi-alert-circle')
    } else {
      showNotif(error.response?.data?.message || 'Gagal terhubung ke server', 'error', 'mdi-wifi-off')
    }
  } finally {
    isLoading.value = false
  }
}

const resetForm = () => {
  formRef.value?.reset()
  form.value = {
    namaLengkap: '',
    username: '',
    noHp: '',
    wilayah: null,
    password: '',
    konfirmasiPassword: ''
  }
}
</script>

<style scoped>
.v-container {
  max-width: 100% !important;
}

.dashboard-header {
  background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
}

.stat-card {
  transition: all 0.25s ease;
}

.stat-card:hover {
  transform: translateY(-4px);
}

.text-h4 {
  font-variant-numeric: tabular-nums;
}

.fill-height {
  height: 100%;
}
</style>