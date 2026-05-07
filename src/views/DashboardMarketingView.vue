# Dashboard Marketing Admin - Vuetify

```vue
<template>
  <v-container fluid class="pa-6">

    <!-- HEADER -->
    <v-card class="mb-6 pa-6 rounded-xl elevation-2 dashboard-header">
      <div class="d-flex align-center flex-wrap">

        <div>
          <h1 class="text-h4 font-weight-bold text-primary mb-2">
            Dashboard Marketing
          </h1>

          <div class="text-subtitle-1 text-grey-darken-1">
            Selamat datang kembali,
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
          <v-icon size="42" color="primary">
            mdi-chart-line
          </v-icon>
        </v-avatar>
      </div>
    </v-card>


    <!-- STATISTIK -->
    <v-row class="mb-2">

      <v-col cols="12" sm="6" md="3">
        <v-card class="pa-5 rounded-xl elevation-2 stat-card" border>

          <div class="d-flex justify-space-between align-start">
            <div>
              <div class="text-overline text-grey-darken-1">
                Total Prospek
              </div>

              <div class="text-h4 font-weight-black text-primary mt-1">
                128
              </div>
            </div>

            <v-avatar color="blue-lighten-5" size="48">
              <v-icon color="primary">
                mdi-account-search
              </v-icon>
            </v-avatar>
          </div>

          <div class="text-caption text-grey mt-4">
            +12 prospek baru hari ini
          </div>

        </v-card>
      </v-col>


      <v-col cols="12" sm="6" md="3">
        <v-card class="pa-5 rounded-xl elevation-2 stat-card" border>

          <div class="d-flex justify-space-between align-start">
            <div>
              <div class="text-overline text-grey-darken-1">
                Nasabah Baru
              </div>

              <div class="text-h4 font-weight-black text-success mt-1">
                24
              </div>
            </div>

            <v-avatar color="green-lighten-5" size="48">
              <v-icon color="success">
                mdi-account-plus
              </v-icon>
            </v-avatar>
          </div>

          <div class="text-caption text-grey mt-4">
            Closing bulan ini
          </div>

        </v-card>
      </v-col>


      <v-col cols="12" sm="6" md="3">
        <v-card class="pa-5 rounded-xl elevation-2 stat-card" border>

          <div class="d-flex justify-space-between align-start">
            <div>
              <div class="text-overline text-grey-darken-1">
                Pending Survey
              </div>

              <div class="text-h4 font-weight-black text-warning mt-1">
                18
              </div>
            </div>

            <v-avatar color="orange-lighten-5" size="48">
              <v-icon color="warning">
                mdi-timer-sand
              </v-icon>
            </v-avatar>
          </div>

          <div class="text-caption text-grey mt-4">
            Menunggu tindak lanjut
          </div>

        </v-card>
      </v-col>


      <v-col cols="12" sm="6" md="3">
        <v-card class="pa-5 rounded-xl elevation-2 stat-card" border>

          <div class="d-flex justify-space-between align-start">
            <div>
              <div class="text-overline text-grey-darken-1">
                Target Bulanan
              </div>

              <div class="text-h4 font-weight-black text-info mt-1">
                72%
              </div>
            </div>

            <v-avatar color="light-blue-lighten-5" size="48">
              <v-icon color="info">
                mdi-target
              </v-icon>
            </v-avatar>
          </div>

          <v-progress-linear
            model-value="72"
            color="info"
            height="7"
            rounded
            class="mt-4"
          />

        </v-card>
      </v-col>

    </v-row>


    <!-- CONTENT -->
    <v-row>

      <!-- AKTIVITAS -->
      <v-col cols="12" lg="7">

        <v-card class="rounded-xl elevation-2 pa-5 fill-height">

          <div class="d-flex align-center mb-4">
            <v-icon color="primary" class="mr-2">
              mdi-history
            </v-icon>

            <div class="text-h6 font-weight-bold">
              Aktivitas Terbaru AO
            </div>
          </div>


          <v-timeline density="compact" align="start">

            <v-timeline-item
              dot-color="success"
              size="small"
            >
              <div class="font-weight-medium">
                AO Rina berhasil closing nasabah baru
              </div>

              <div class="text-caption text-grey">
                Kredit UMKM Rp 150.000.000 - 5 menit lalu
              </div>
            </v-timeline-item>


            <v-timeline-item
              dot-color="primary"
              size="small"
            >
              <div class="font-weight-medium">
                AO Budi menambahkan prospek baru
              </div>

              <div class="text-caption text-grey">
                Calon nasabah wilayah Bantul - 12 menit lalu
              </div>
            </v-timeline-item>


            <v-timeline-item
              dot-color="warning"
              size="small"
            >
              <div class="font-weight-medium">
                Survey lapangan dijadwalkan ulang
              </div>

              <div class="text-caption text-grey">
                Nasabah belum berada di lokasi - 30 menit lalu
              </div>
            </v-timeline-item>


            <v-timeline-item
              dot-color="info"
              size="small"
            >
              <div class="font-weight-medium">
                Pengajuan kredit disetujui
              </div>

              <div class="text-caption text-grey">
                Oleh Supervisor Marketing - 1 jam lalu
              </div>
            </v-timeline-item>


            <v-timeline-item
              dot-color="error"
              size="small"
            >
              <div class="font-weight-medium">
                Follow up belum dilakukan
              </div>

              <div class="text-caption text-grey">
                3 prospek belum dihubungi - 2 jam lalu
              </div>
            </v-timeline-item>

          </v-timeline>

        </v-card>

      </v-col>


      <!-- QUICK INFO -->
      <v-col cols="12" lg="5">

        <v-card class="rounded-xl elevation-2 pa-5 mb-5">

          <div class="text-h6 font-weight-bold mb-4">
            User Online
          </div>

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

          <div class="text-h6 font-weight-bold mb-4">
            Progress Target Marketing
          </div>

          <div class="text-caption mb-2">
            Target pencapaian bulan ini
          </div>

          <v-progress-linear
            model-value="72"
            color="primary"
            height="10"
            rounded
          />

          <div class="text-right text-caption mt-2">
            72 / 100 target tercapai
          </div>

        </v-card>


        <v-card class="rounded-xl elevation-2 pa-5">

          <div class="text-h6 font-weight-bold mb-4">
            Reminder
          </div>

          <v-alert
            type="warning"
            variant="tonal"
            density="compact"
            class="mb-3"
          >
            3 survey jatuh tempo hari ini
          </v-alert>

          <v-alert
            type="info"
            variant="tonal"
            density="compact"
            class="mb-3"
          >
            5 prospek perlu follow up
          </v-alert>

          <v-alert
            type="success"
            variant="tonal"
            density="compact"
          >
            Target mingguan hampir tercapai
          </v-alert>

        </v-card>

      </v-col>

    </v-row>


    <!-- TABEL PERFORMA AO -->
    <v-row class="mt-1">
      <v-col cols="12">

        <v-card class="rounded-xl elevation-2 pa-5">

          <div class="d-flex align-center mb-5">
            <v-icon color="primary" class="mr-2">
              mdi-account-group
            </v-icon>

            <div class="text-h6 font-weight-bold">
              Monitoring Performa AO
            </div>
          </div>


          <v-table>
            <thead>
              <tr>
                <th>Nama AO</th>
                <th>Total Prospek</th>
                <th>Follow Up</th>
                <th>Closing</th>
                <th>Status</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="ao in aoPerformance" :key="ao.name">
                <td>{{ ao.name }}</td>
                <td>{{ ao.prospek }}</td>
                <td>{{ ao.followup }}</td>
                <td>{{ ao.closing }}</td>

                <td>
                  <v-chip
                    :color="ao.statusColor"
                    size="small"
                    variant="flat"
                  >
                    {{ ao.status }}
                  </v-chip>
                </td>
              </tr>
            </tbody>
          </v-table>

        </v-card>

      </v-col>
    </v-row>

  </v-container>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const currentTime = ref('')

const aoPerformance = ref([
  {
    name: 'AO Rina',
    prospek: 24,
    followup: 18,
    closing: 8,
    status: 'Aktif',
    statusColor: 'success'
  },
  {
    name: 'AO Budi',
    prospek: 18,
    followup: 12,
    closing: 5,
    status: 'Aktif',
    statusColor: 'primary'
  },
  {
    name: 'AO Dimas',
    prospek: 11,
    followup: 6,
    closing: 2,
    status: 'Perlu Follow Up',
    statusColor: 'warning'
  },
  {
    name: 'AO Sinta',
    prospek: 8,
    followup: 4,
    closing: 1,
    status: 'Kurang Aktif',
    statusColor: 'error'
  }
])

const updateTime = () => {
  const now = new Date()

  currentTime.value = now.toLocaleTimeString('id-ID', {
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit',
    hour12: false
  })
}

let timer

onMounted(() => {
  updateTime()

  timer = setInterval(() => {
    updateTime()
  }, 1000)
})

onUnmounted(() => {
  if (timer) clearInterval(timer)
})
</script>

<style scoped>
.v-container {
  max-width: 100% !important;
}

.dashboard-header {
  background: linear-gradient(
    135deg,
    #ffffff 0%,
    #f8fbff 100%
  );
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

