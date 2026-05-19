<template>
  <v-container fluid class="pa-6 bg-grey-lighten-4" style="min-height: 100vh;">

    <!-- HEADER -->
    <v-card class="mb-6 pa-6 rounded-xl elevation-2" border>
      <div class="d-flex align-center">
        <div>
          <h1 class="text-h4 font-weight-bold text-primary mb-1">
            Jadwal Kunjungan
          </h1>

          <p class="text-subtitle-1 text-grey-darken-1 mb-0">
            Dashboard >
            <span class="font-weight-bold text-primary">
              Jadwal Kunjungan
            </span>
          </p>
        </div>

        <v-spacer></v-spacer>

        <v-btn
          color="primary"
          prepend-icon="mdi-plus"
          rounded="lg"
          @click="dialog = true"
        >
          Buat Jadwal
        </v-btn>
      </div>
    </v-card>

    <!-- TABEL -->
    <v-card class="rounded-xl elevation-2 overflow-hidden">

      <v-toolbar color="white" flat class="px-4 pt-2">
        <v-toolbar-title class="font-weight-bold">
          <v-icon start color="primary">
            mdi-calendar-clock
          </v-icon>

          Daftar Jadwal Kunjungan
        </v-toolbar-title>

        <v-spacer></v-spacer>

        <v-text-field
          v-model="search"
          prepend-inner-icon="mdi-magnify"
          label="Cari nasabah..."
          variant="outlined"
          density="compact"
          hide-details
          style="max-width: 280px;"
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

        <template v-slot:item.status="{ item }">
          <v-chip
            :color="getStatusColor(item.status)"
            size="small"
            variant="flat"
          >
            {{ item.status }}
          </v-chip>
        </template>

        <template v-slot:item.aksi="{ item }">
          <v-btn
            icon
            size="small"
            color="primary"
            variant="text"
          >
            <v-icon>mdi-eye</v-icon>
          </v-btn>

          <v-btn
            icon
            size="small"
            color="warning"
            variant="text"
          >
            <v-icon>mdi-pencil</v-icon>
          </v-btn>

          <v-btn
            icon
            size="small"
            color="error"
            variant="text"
          >
            <v-icon>mdi-delete</v-icon>
          </v-btn>
        </template>

      </v-data-table>
    </v-card>

    <!-- DIALOG -->
    <v-dialog v-model="dialog" max-width="700">

      <v-card class="rounded-xl">

        <v-card-title class="font-weight-bold">
          Buat Jadwal Kunjungan
        </v-card-title>

        <v-divider></v-divider>

        <v-card-text class="pt-5">

          <v-row>

            <v-col cols="12" md="6">
              <v-text-field
                label="Nama Nasabah"
                variant="outlined"
              />
            </v-col>

            <v-col cols="12" md="6">
              <v-text-field
                label="No. Angsuran"
                variant="outlined"
              />
            </v-col>

            <v-col cols="12">
              <v-textarea
                label="Alamat"
                variant="outlined"
                rows="3"
              />
            </v-col>

            <v-col cols="12" md="6">
              <v-text-field
                type="date"
                label="Tanggal Kunjungan"
                variant="outlined"
              />
            </v-col>

            <v-col cols="12" md="6">
              <v-text-field
                type="time"
                label="Jam Kunjungan"
                variant="outlined"
              />
            </v-col>

            <v-col cols="12">
              <v-textarea
                label="Catatan"
                variant="outlined"
                rows="3"
              />
            </v-col>

          </v-row>

        </v-card-text>

        <v-divider></v-divider>

        <v-card-actions class="pa-4">
          <v-spacer></v-spacer>

          <v-btn
            variant="text"
            @click="dialog = false"
          >
            Batal
          </v-btn>

          <v-btn
            color="primary"
            rounded="lg"
          >
            Simpan Jadwal
          </v-btn>
        </v-card-actions>

      </v-card>

    </v-dialog>

  </v-container>
</template>

<script setup>
import { ref } from 'vue'

const dialog = ref(false)
const search = ref('')

const headers = [
  { title: 'NO', key: 'no', sortable: false },
  { title: 'NO ANGSURAN', key: 'no_angsuran' },
  { title: 'NAMA NASABAH', key: 'nama_nasabah' },
  { title: 'TANGGAL', key: 'tanggal' },
  { title: 'JAM', key: 'jam' },
  { title: 'STATUS', key: 'status' },
  { title: 'AKSI', key: 'aksi', sortable: false },
]

const items = ref([
  {
    no_angsuran: '24000527',
    nama_nasabah: 'EKO SUTRISNO',
    tanggal: '2026-05-20',
    jam: '10:00',
    status: 'Terjadwal'
  },
  {
    no_angsuran: '24000528',
    nama_nasabah: 'TRI MULYONO',
    tanggal: '2026-05-21',
    jam: '13:00',
    status: 'Selesai'
  }
])

const getStatusColor = (status) => {
  if (status === 'Terjadwal') return 'warning'
  if (status === 'Selesai') return 'success'
  return 'grey'
}
</script>