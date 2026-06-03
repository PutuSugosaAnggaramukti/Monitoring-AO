<template>
  <v-container fluid class="pa-6">

    <!-- HEADER -->
    <v-card class="mb-6 pa-6 rounded-xl elevation-2 dashboard-header">
      <div class="d-flex align-center flex-wrap">
        <div>
          <h1 class="text-h4 font-weight-bold text-primary mb-2">Dashboard Marketing</h1>
          <div class="text-subtitle-1 text-grey-darken-1">
            Selamat datang kembali,
            <span class="font-weight-bold text-secondary">{{ userName }}</span> 👋
          </div>
        </div>
        <v-spacer></v-spacer>
        <div class="text-right mr-5">
          <div class="text-caption text-uppercase text-grey font-weight-bold">Waktu Sistem</div>
          <div class="text-h4 font-weight-black text-primary">{{ currentTime }}</div>
        </div>
        <v-avatar size="72" color="blue-lighten-5">
          <v-icon size="42" color="primary">mdi-chart-line</v-icon>
        </v-avatar>
      </div>
    </v-card>

    <!-- ADMIN ONLY CONTENT -->
    <template v-if="isAdmin">
      <v-row>
        <v-col cols="12" lg="5">
          <v-card class="rounded-xl elevation-2 pa-5 mb-5">
            <div class="text-h6 font-weight-bold mb-4">User Online</div>
            <div class="d-flex align-center mb-3">
              <v-avatar size="10" color="success" class="mr-3"></v-avatar>
              <span>7 AO sedang aktif</span>
            </div>
            <div class="d-flex align-center mb-3">
              <v-avatar size="10" color="warning" class="mr-3"></v-avatar>
              <span>2 AO belum update hari ini</span>
            </div>
            <div class="d-flex align-center">
              <v-avatar size="10" color="error" class="mr-3"></v-avatar>
              <span>1 AO belum input prospek</span>
            </div>
          </v-card>
          <v-card class="rounded-xl elevation-2 pa-5 mb-5">
            <div class="text-h6 font-weight-bold mb-4">Progress Target Marketing</div>
            <div class="text-caption mb-2">Target pencapaian bulan ini</div>
            <v-progress-linear model-value="72" color="primary" height="10" rounded />
            <div class="text-right text-caption mt-2">72 / 100 target tercapai</div>
          </v-card>
          <v-card class="rounded-xl elevation-2 pa-5">
            <div class="text-h6 font-weight-bold mb-4">Reminder</div>
            <v-alert type="warning" variant="tonal" density="compact" class="mb-3">3 survey jatuh tempo hari ini</v-alert>
            <v-alert type="info" variant="tonal" density="compact" class="mb-3">5 prospek perlu follow up</v-alert>
            <v-alert type="success" variant="tonal" density="compact">Target mingguan hampir tercapai</v-alert>
          </v-card>
        </v-col>
      </v-row>

      <v-row class="mt-1">
        <v-col cols="12">
          <v-card class="rounded-xl elevation-2 pa-5">
            <div class="d-flex align-center mb-5">
              <v-icon color="primary" class="mr-2">mdi-account-group</v-icon>
              <div class="text-h6 font-weight-bold">Monitoring Performa AO</div>
            </div>
            <v-table>
              <thead>
                <tr>
                  <th>Nama AO</th><th>Total Prospek</th><th>Follow Up</th><th>Closing</th><th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="ao in aoPerformance" :key="ao.name">
                  <td>{{ ao.name }}</td>
                  <td>{{ ao.prospek }}</td>
                  <td>{{ ao.followup }}</td>
                  <td>{{ ao.closing }}</td>
                  <td><v-chip :color="ao.statusColor" size="small" variant="flat">{{ ao.status }}</v-chip></td>
                </tr>
              </tbody>
            </v-table>
          </v-card>
        </v-col>
      </v-row>
    </template>

    <!-- AO ONLY CONTENT -->
    <template v-else>

      <!-- QUICK ACTION -->
      <v-row class="mb-2">
        <v-col cols="12" md="4">
          <v-card class="rounded-xl elevation-2 pa-5 stat-card cursor-pointer" border @click="$router.push('/jadwal-kunjungan')">
            <div class="d-flex align-center">
              <div>
                <div class="text-overline text-grey-darken-1">Jadwal Kunjungan</div>
                <div class="text-h4 font-weight-black text-primary">{{ statistik.jadwal }}</div>
                <div class="text-caption text-grey mt-2">Total jadwal aktif</div>
              </div>
              <v-spacer></v-spacer>
              <v-avatar color="blue-lighten-5" size="56">
                <v-icon color="primary" size="30">mdi-calendar-clock</v-icon>
              </v-avatar>
            </div>
          </v-card>
        </v-col>
        <v-col cols="12" md="4">
          <v-card class="rounded-xl elevation-2 pa-5 stat-card cursor-pointer" border @click="$router.push('/pelaporan')">
            <div class="d-flex align-center">
              <div>
                <div class="text-overline text-grey-darken-1">LapKun Nasabah Baru</div>
                <div class="text-h4 font-weight-black text-success">{{ statistik.lapkun_baru }}</div>
                <div class="text-caption text-grey mt-2">Laporan bulan ini</div>
              </div>
              <v-spacer></v-spacer>
              <v-avatar color="green-lighten-5" size="56">
                <v-icon color="success" size="30">mdi-account-plus-outline</v-icon>
              </v-avatar>
            </div>
          </v-card>
        </v-col>
        <v-col cols="12" md="4">
          <v-card class="rounded-xl elevation-2 pa-5 stat-card cursor-pointer" border @click="$router.push('/pelaporan-nasabah-lama')">
            <div class="d-flex align-center">
              <div>
                <div class="text-overline text-grey-darken-1">LapKun Nasabah Lama</div>
                <div class="text-h4 font-weight-black text-warning">{{ statistik.lapkun_lama }}</div>
                <div class="text-caption text-grey mt-2">Kunjungan selesai</div>
              </div>
              <v-spacer></v-spacer>
              <v-avatar color="orange-lighten-5" size="56">
                <v-icon color="warning" size="30">mdi-account-clock-outline</v-icon>
              </v-avatar>
            </div>
          </v-card>
        </v-col>
      </v-row>

      <!-- JADWAL HARI INI -->
      <v-row>
        <v-col cols="12" lg="8">
          <v-card class="rounded-xl elevation-2 pa-5 fill-height">
            <div class="d-flex align-center mb-5">
              <v-icon color="primary" class="mr-2">mdi-calendar-today</v-icon>
              <div class="text-h6 font-weight-bold">Jadwal Hari Ini</div>
            </div>

            <v-table>
              <thead>
                <tr>
                  <th>Nama Nasabah</th>
                  <th>No Anggota</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="item in jadwalHariIni"
                  :key="item.id"
                  class="jadwal-row"
                  :class="{ 'clickable-row': item.status === 'Selesai' }"
                  @click="item.status === 'Selesai' && bukaModalLaporan(item)"
                >
                  <td>
                    <div class="d-flex align-center flex-wrap gap-1">
                      {{ item.nasabah?.nama ?? '(Nasabah Baru)' }}
                      <v-chip
                        v-if="item.status === 'Selesai'"
                        color="primary"
                        size="x-small"
                        variant="tonal"
                        class="ml-1"
                      >
                        <v-icon start size="10">mdi-file-document-outline</v-icon>
                        Lihat Laporan
                      </v-chip>
                    </div>
                  </td>
                  <td>{{ item.nasabah?.no_anggota ?? '-' }}</td>
                  <td>
                    <v-chip :color="item.status === 'Selesai' ? 'success' : 'warning'" size="small">
                      {{ item.status }}
                    </v-chip>
                  </td>
                </tr>
              </tbody>
            </v-table>
          </v-card>
        </v-col>

        <!-- REMINDER & AKTIVITAS -->
        <v-col cols="12" lg="4">
          <v-card class="rounded-xl elevation-2 pa-5 mb-5">
            <div class="d-flex align-center mb-4">
              <v-icon color="warning" class="mr-2">mdi-bell-outline</v-icon>
              <div class="text-h6 font-weight-bold">Reminder</div>
            </div>
           <v-alert
              type="warning"
              variant="tonal"
              density="compact"
              class="mb-3"
            >
              {{ reminder.jadwal_belum }} jadwal belum dikunjungi
            </v-alert>

            <v-alert
              type="info"
              variant="tonal"
              density="compact"
              class="mb-3"
            >
              {{ reminder.jadwal_selesai }} kunjungan selesai
            </v-alert>

            <v-alert
              type="success"
              variant="tonal"
              density="compact"
            >
              Target mingguan tercapai {{ reminder.target_mingguan }}%
            </v-alert>
          </v-card>

          <v-card class="rounded-xl elevation-2 pa-5">
            <div class="d-flex align-center mb-4">
              <v-icon color="primary" class="mr-2">mdi-history</v-icon>
              <div class="text-h6 font-weight-bold">Aktivitas Terakhir</div>
            </div>
            <v-timeline density="compact" align="start">
              <v-timeline-item
                v-for="item in aktivitasTerakhir"
                :key="item.id"
                :dot-color="item.jenis === 'jadwal' ? 'warning' : 'primary'"
                size="small"
              >
                <div class="d-flex align-center flex-wrap gap-1 mb-1">
                  <span class="font-weight-medium text-body-2">{{ item.keterangan }}</span>
                  <v-chip
                    v-if="item.label"
                    :color="item.label === 'Nasabah Baru' ? 'success' : 'primary'"
                    size="x-small"
                    variant="flat"
                  >
                    {{ item.label }}
                  </v-chip>
                  <v-chip
                    v-else-if="item.jenis === 'jadwal'"
                    color="warning"
                    size="x-small"
                    variant="flat"
                  >
                    Jadwal
                  </v-chip>
                </div>
                <div class="text-caption text-grey-darken-1 font-weight-medium">{{ item.nama_nasabah }}</div>
                <div class="text-caption text-grey">{{ formatTanggal(item.created_at) }}</div>
              </v-timeline-item>
            </v-timeline>
          </v-card>
        </v-col>
      </v-row>

    </template>

    <!-- ============================================================ -->
    <!-- MODAL DETAIL LAPORAN KUNJUNGAN                               -->
    <!-- ============================================================ -->
    <v-dialog v-model="modalLaporan" max-width="700" scrollable>
      <v-card class="rounded-xl">

        <!-- Header -->
        <v-card-title class="pa-5 pb-3">
          <div class="d-flex align-center justify-space-between w-100">
            <div class="d-flex align-center">
              <v-avatar
                :color="jenisLaporan === 'baru' ? 'green-lighten-5' : 'blue-lighten-5'"
                size="42"
                class="mr-3"
              >
                <v-icon
                  :color="jenisLaporan === 'baru' ? 'success' : 'primary'"
                  size="22"
                >
                  {{ jenisLaporan === 'baru' ? 'mdi-account-plus-outline' : 'mdi-account-clock-outline' }}
                </v-icon>
              </v-avatar>
              <div>
                <div class="d-flex align-center gap-2">
                  <span class="text-h6 font-weight-bold">Laporan Kunjungan</span>
                  <!-- Badge jenis nasabah -->
                  <v-chip
                    v-if="jenisLaporan"
                    :color="jenisLaporan === 'baru' ? 'success' : 'primary'"
                    size="x-small"
                    variant="flat"
                    class="ml-1"
                  >
                    {{ jenisLaporan === 'baru' ? 'Nasabah Baru' : 'Nasabah Lama' }}
                  </v-chip>
                </div>
                <div class="text-caption text-grey mt-1">
                  {{ jenisLaporan === 'baru'
                      ? (laporanList[0]?.nama_ktp ?? '-')
                      : (selectedJadwal?.nasabah?.nama ?? '-') }}
                </div>
              </div>
            </div>
            <v-btn icon="mdi-close" variant="text" density="compact" @click="tutupModal" />
          </div>
        </v-card-title>

        <v-divider />

        <!-- Loading -->
        <v-card-text v-if="loadingLaporan" class="pa-10 text-center">
          <v-progress-circular indeterminate color="primary" size="48" class="mb-4" />
          <div class="text-body-2 text-grey">Memuat laporan kunjungan...</div>
        </v-card-text>

        <!-- Empty state -->
        <v-card-text v-else-if="!laporanList.length" class="pa-10 text-center">
          <v-icon size="64" color="grey-lighten-1" class="mb-3">mdi-file-document-remove-outline</v-icon>
          <div class="text-h6 text-grey-darken-1 mb-1">Laporan Belum Tersedia</div>
          <div class="text-body-2 text-grey">Laporan kunjungan untuk nasabah ini belum diupload.</div>
        </v-card-text>

        <!-- ==================== NASABAH BARU ==================== -->
        <v-card-text v-else-if="jenisLaporan === 'baru'" class="pa-5">

          <template v-for="(lap, idx) in laporanList" :key="lap.id">

            <!-- Tab jika lebih dari 1 -->
            <v-tabs v-if="laporanList.length > 1 && idx === 0" v-model="tabLaporan" color="success" class="mb-4">
              <v-tab v-for="(l, i) in laporanList" :key="l.id" :value="i">
                Laporan {{ i + 1 }}
              </v-tab>
            </v-tabs>

            <div v-show="laporanList.length === 1 || tabLaporan === idx">

              <!-- Info identitas -->
              <v-card variant="outlined" class="rounded-lg pa-4 mb-4" style="border-color: #4caf50; border-width: 1.5px;">
                <div class="d-flex align-center mb-3">
                  <v-icon color="success" size="18" class="mr-2">mdi-account-card</v-icon>
                  <span class="text-overline font-weight-bold" style="color: #4caf50;">Data Identitas</span>
                </div>
                <v-row dense>
                  <v-col cols="12" sm="6">
                    <div class="text-caption text-grey-darken-1 font-weight-medium mb-1">Nama Sesuai KTP</div>
                    <div class="font-weight-bold text-grey-darken-4" style="font-size:0.95rem;">{{ lap.nama_ktp ?? '-' }}</div>
                  </v-col>
                  <v-col cols="12" sm="6">
                    <div class="text-caption text-grey-darken-1 font-weight-medium mb-1">Nama Tanpa Gelar</div>
                    <div class="font-weight-bold text-grey-darken-4" style="font-size:0.95rem;">{{ lap.nama_tanpa_gelar ?? '-' }}</div>
                  </v-col>
                  <v-col cols="12" sm="6" class="mt-2">
                    <div class="text-caption text-grey-darken-1 font-weight-medium mb-1">No. KTP</div>
                    <div class="font-weight-bold text-grey-darken-4" style="font-size:0.95rem;">{{ lap.no_ktp ?? '-' }}</div>
                  </v-col>
                  <v-col cols="12" sm="6" class="mt-2">
                    <div class="text-caption text-grey-darken-1 font-weight-medium mb-1">NPWP</div>
                    <div class="font-weight-bold text-grey-darken-4" style="font-size:0.95rem;">{{ lap.npwp ?? '-' }}</div>
                  </v-col>
                  <v-col cols="12" sm="6" class="mt-2">
                    <div class="text-caption text-grey-darken-1 font-weight-medium mb-1">Pendidikan</div>
                    <div class="font-weight-bold text-grey-darken-4" style="font-size:0.95rem;">{{ lap.pendidikan ?? '-' }}</div>
                  </v-col>
                  <v-col cols="12" sm="6" class="mt-2">
                    <div class="text-caption text-grey-darken-1 font-weight-medium mb-1">Nama Suami/Istri</div>
                    <div class="font-weight-bold text-grey-darken-4" style="font-size:0.95rem;">{{ lap.nama_pasangan ?? '-' }}</div>
                  </v-col>
                </v-row>
              </v-card>

              <!-- Info ekonomi -->
              <v-row dense class="mb-4">
                <v-col cols="12" sm="4">
                  <v-card variant="outlined" class="rounded-lg pa-3">
                    <div class="d-flex align-center mb-1">
                      <v-icon size="15" color="primary" class="mr-2">mdi-briefcase</v-icon>
                      <span class="text-caption text-grey">Pekerjaan</span>
                    </div>
                    <div class="font-weight-medium text-body-2">{{ lap.pekerjaan ?? '-' }}</div>
                  </v-card>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-card variant="outlined" class="rounded-lg pa-3">
                    <div class="d-flex align-center mb-1">
                      <v-icon size="15" color="success" class="mr-2">mdi-currency-usd</v-icon>
                      <span class="text-caption text-grey">Gaji per Bulan</span>
                    </div>
                    <div class="font-weight-medium text-body-2">
                      Rp {{ Number(lap.gaji ?? 0).toLocaleString('id-ID') }}
                    </div>
                  </v-card>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-card variant="outlined" class="rounded-lg pa-3">
                    <div class="d-flex align-center mb-1">
                      <v-icon size="15" color="grey" class="mr-2">mdi-clock-outline</v-icon>
                      <span class="text-caption text-grey">Dilaporkan</span>
                    </div>
                    <div class="font-weight-medium text-body-2">{{ formatTanggal(lap.created_at) }}</div>
                  </v-card>
                </v-col>
              </v-row>

              <!-- Alamat -->
              <template v-if="lap.alamat">
                <div class="text-overline text-grey font-weight-bold mb-2">Alamat</div>
                <v-card variant="outlined" class="rounded-lg pa-3 mb-4">
                  <div class="text-body-2">{{ lap.alamat }}</div>
                </v-card>
              </template>

              <!-- Catatan -->
              <template v-if="lap.catatan">
                <div class="text-overline text-grey font-weight-bold mb-2">Catatan Kunjungan</div>
                <v-card variant="outlined" class="rounded-lg pa-4 mb-4">
                  <p class="text-body-2 mb-0" style="white-space: pre-wrap; line-height: 1.8;">{{ lap.catatan }}</p>
                </v-card>
              </template>

              <!-- Foto -->
              <template v-if="lap.foto">
                <div class="text-overline text-grey font-weight-bold mb-2">Foto Dokumentasi</div>
                <v-card variant="outlined" class="rounded-lg overflow-hidden mb-2">
                  <v-img :src="`http://127.0.0.1:8000/storage/${lap.foto}`" max-height="300" cover>
                    <template #error>
                      <div class="d-flex align-center justify-center pa-6 text-grey">
                        <v-icon class="mr-2">mdi-image-broken-variant</v-icon>
                        <span class="text-caption">Foto tidak dapat dimuat</span>
                      </div>
                    </template>
                  </v-img>
                </v-card>
              </template>

            </div>
          </template>

        </v-card-text>

        <!-- ==================== NASABAH LAMA ==================== -->
        <v-card-text v-else class="pa-5">

          <!-- Info Nasabah -->
          <v-card variant="outlined" class="rounded-lg pa-4 mb-5" style="border-color: rgb(var(--v-theme-primary)); border-width: 1.5px;">
            <div class="d-flex align-center mb-3">
              <v-icon color="primary" size="18" class="mr-2">mdi-account-circle-outline</v-icon>
              <span class="text-overline text-primary font-weight-bold">Informasi Nasabah</span>
            </div>
            <v-row dense>
              <v-col cols="12" sm="6">
                <div class="text-caption text-grey-darken-1 font-weight-medium mb-1">Nama Nasabah</div>
                <div class="font-weight-bold text-grey-darken-4" style="font-size: 0.95rem;">
                  {{ laporanList[0].nasabah?.nama ?? selectedJadwal?.nasabah?.nama ?? '-' }}
                </div>
              </v-col>
              <v-col cols="12" sm="6">
                <div class="text-caption text-grey-darken-1 font-weight-medium mb-1">No Anggota</div>
                <div class="font-weight-bold text-grey-darken-4" style="font-size: 0.95rem;">
                  {{ laporanList[0].nasabah?.no_anggota ?? selectedJadwal?.nasabah?.no_anggota ?? '-' }}
                </div>
              </v-col>
            </v-row>
          </v-card>

          <!-- Tab jika multi kunjungan -->
          <template v-if="laporanList.length > 1">
            <v-tabs v-model="tabLaporan" color="primary" class="mb-4">
              <v-tab v-for="(lap, idx) in laporanList" :key="lap.id" :value="idx">
                Kunjungan ke-{{ lap.kunjungan_ke ?? idx + 1 }}
              </v-tab>
            </v-tabs>
          </template>

          <template v-for="(lap, idx) in laporanList" :key="lap.id">
            <div v-show="laporanList.length === 1 || tabLaporan === idx">

              <div class="text-overline text-grey font-weight-bold mb-3">Detail Kunjungan</div>
              <v-row dense class="mb-4">
                <v-col cols="12" sm="6">
                  <v-card variant="outlined" class="rounded-lg pa-3">
                    <div class="d-flex align-center mb-1">
                      <v-icon size="15" color="primary" class="mr-2">mdi-calendar</v-icon>
                      <span class="text-caption text-grey">Tanggal Kunjungan</span>
                    </div>
                    <div class="font-weight-medium text-body-2">{{ formatTanggal(lap.tanggal_kunjungan) }}</div>
                  </v-card>
                </v-col>
                <v-col cols="12" sm="6" v-if="lap.kunjungan_ke">
                  <v-card variant="outlined" class="rounded-lg pa-3">
                    <div class="d-flex align-center mb-1">
                      <v-icon size="15" color="orange" class="mr-2">mdi-repeat</v-icon>
                      <span class="text-caption text-grey">Kunjungan Ke</span>
                    </div>
                    <div class="font-weight-medium text-body-2">{{ lap.kunjungan_ke }}</div>
                  </v-card>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-card variant="outlined" class="rounded-lg pa-3">
                    <div class="d-flex align-center mb-1">
                      <v-icon size="15" color="success" class="mr-2">mdi-check-circle-outline</v-icon>
                      <span class="text-caption text-grey">Status</span>
                    </div>
                    <v-chip color="success" size="x-small" variant="flat">Selesai</v-chip>
                  </v-card>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-card variant="outlined" class="rounded-lg pa-3">
                    <div class="d-flex align-center mb-1">
                      <v-icon size="15" color="grey" class="mr-2">mdi-clock-outline</v-icon>
                      <span class="text-caption text-grey">Dilaporkan</span>
                    </div>
                    <div class="font-weight-medium text-body-2">{{ formatTanggal(lap.created_at) }}</div>
                  </v-card>
                </v-col>
              </v-row>

              <template v-if="lap.catatan">
                <div class="text-overline text-grey font-weight-bold mb-2">Catatan Kunjungan</div>
                <v-card variant="outlined" class="rounded-lg pa-4 mb-4">
                  <p class="text-body-2 mb-0" style="white-space: pre-wrap; line-height: 1.8;">{{ lap.catatan }}</p>
                </v-card>
              </template>

              <template v-if="lap.foto">
                <div class="text-overline text-grey font-weight-bold mb-2">Foto Dokumentasi</div>
                <v-card variant="outlined" class="rounded-lg overflow-hidden mb-2">
                  <v-img :src="`http://127.0.0.1:8000/storage/${lap.foto}`" max-height="300" cover>
                    <template #error>
                      <div class="d-flex align-center justify-center pa-6 text-grey">
                        <v-icon class="mr-2">mdi-image-broken-variant</v-icon>
                        <span class="text-caption">Foto tidak dapat dimuat</span>
                      </div>
                    </template>
                  </v-img>
                </v-card>
              </template>

            </div>
          </template>

        </v-card-text>

        <v-divider />
        <v-card-actions class="pa-4">
          <v-spacer />
          <v-btn variant="outlined" rounded="lg" @click="tutupModal">Tutup</v-btn>
        </v-card-actions>

      </v-card>
    </v-dialog>

  </v-container>
</template>

<script setup>
import axios from 'axios'
import { ref, computed, onMounted, onUnmounted } from 'vue'

const currentTime = ref('')

// ========================
// USER ROLE
// ========================
const user = JSON.parse(localStorage.getItem('user') || '{}')
const isAdmin  = computed(() => user.role === 'ADMIN' || user.role === 'admin')
const userName = computed(() => user.name || user.username || 'Administrator')

// ========================
// STATISTIK AO
// ========================
const statistik         = ref({ jadwal: 0, lapkun_baru: 0, lapkun_lama: 0 })
const jadwalHariIni     = ref([])
const aktivitasTerakhir = ref([])

const getDashboard = async () => {
  try {
    const token = localStorage.getItem('token')

    const response = await axios.get(
      'http://127.0.0.1:8000/api/dashboard-marketing',
      {
        headers: {
          Authorization: `Bearer ${token}`
        }
      }
    )

    statistik.value         = response.data.statistik
    jadwalHariIni.value     = response.data.jadwal_hari_ini
    aktivitasTerakhir.value = response.data.aktivitas
    reminder.value          = response.data.reminder

  } catch (error) {
    console.error(error)
  }
}

// ========================
// REMINDER
// ========================
const reminder = ref({
  jadwal_belum: 0,
  laporan_belum: 0,
  target_mingguan: 0
})

// ========================
// MODAL LAPORAN KUNJUNGAN
// ========================
const modalLaporan   = ref(false)
const loadingLaporan = ref(false)
const laporanList    = ref([])
const jenisLaporan   = ref(null)   // 'baru' | 'lama'
const selectedJadwal = ref(null)
const tabLaporan     = ref(0)

const bukaModalLaporan = async (jadwal) => {
  selectedJadwal.value = jadwal
  laporanList.value    = []
  jenisLaporan.value   = null
  tabLaporan.value     = 0
  modalLaporan.value   = true
  loadingLaporan.value = true

  try {
    const token = localStorage.getItem('token')

    // Pakai endpoint showByJadwal — backend yang tentukan jenis laporan
    const response = await axios.get(
      `http://127.0.0.1:8000/api/laporan-kunjungan/jadwal/${jadwal.id}`,
      { headers: { Authorization: `Bearer ${token}` } }
    )

    jenisLaporan.value = response.data.jenis  // 'baru' | 'lama'
    const raw = response.data.data
    laporanList.value = Array.isArray(raw) ? raw : (raw ? [raw] : [])

  } catch (error) {
    if (error.response?.status !== 404) {
      console.error('Gagal memuat laporan:', error)
    }
    laporanList.value  = []
    jenisLaporan.value = null
  } finally {
    loadingLaporan.value = false
  }
}

const tutupModal = () => {
  modalLaporan.value   = false
  laporanList.value    = []
  jenisLaporan.value   = null
  selectedJadwal.value = null
}

// ========================
// HELPER FORMAT TANGGAL
// ========================
const formatTanggal = (dateStr) => {
  if (!dateStr) return '-'
  return new Date(dateStr).toLocaleDateString('id-ID', {
    day: '2-digit', month: 'long', year: 'numeric',
    hour: '2-digit', minute: '2-digit'
  })
}

// ========================
// AO PERFORMANCE (ADMIN)
// ========================
const aoPerformance = ref([
  { name: 'AO Rina',  prospek: 24, followup: 18, closing: 8, status: 'Aktif',           statusColor: 'success' },
  { name: 'AO Budi',  prospek: 18, followup: 12, closing: 5, status: 'Aktif',           statusColor: 'primary' },
  { name: 'AO Dimas', prospek: 11, followup: 6,  closing: 2, status: 'Perlu Follow Up', statusColor: 'warning' },
  { name: 'AO Sinta', prospek: 8,  followup: 4,  closing: 1, status: 'Kurang Aktif',    statusColor: 'error'   }
])

// ========================
// WAKTU SISTEM
// ========================
const updateTime = () => {
  const now = new Date()
  currentTime.value = now.toLocaleTimeString('id-ID', {
    hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false
  })
}

let timer
onMounted(() => { updateTime(); getDashboard(); timer = setInterval(updateTime, 1000) })
onUnmounted(() => { if (timer) clearInterval(timer) })
</script>

<style scoped>
.v-container { max-width: 100% !important; }

.dashboard-header {
  background: linear-gradient(135deg, #ffffff 0%, #f8fbff 100%);
}

.stat-card { transition: all 0.25s ease; }
.stat-card:hover { transform: translateY(-4px); }

.text-h4 { font-variant-numeric: tabular-nums; }

.fill-height { height: 100%; }

.jadwal-row { transition: background-color 0.15s ease; }
.clickable-row { cursor: pointer; }
.clickable-row:hover {
  background-color: rgba(var(--v-theme-primary), 0.06) !important;
}

.gap-1 { gap: 4px; }
</style>