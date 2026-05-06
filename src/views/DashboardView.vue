<template>
  
  <v-container fluid class="pa-6">
    
    <div class="dashboard-header mb-6">
      <h1 class="text-h4 font-weight-bold text-primary">Dashboard</h1>
      <p class="text-subtitle-1 text-grey-darken-1">Selamat datang kembali 👋</p>
    </div>

    <v-row>
      <v-col cols="12" sm="6" md="3">
        <v-card class="pa-4 rounded-xl elevation-2" color="white">
          <div class="text-overline text-grey-darken-1 mb-1">Total Nasabah</div>
          <div class="text-h4 font-weight-bold text-primary">150</div>
          
          <v-progress-linear 
            color="primary" 
            model-value="100" 
            class="mt-4" 
            rounded 
            height="6"
          ></v-progress-linear>
        </v-card>
      </v-col>
      
    </v-row>

  </v-container>
</template>

<script setup>

</script>

<style scoped>
.v-container {
  max-width: 100% !important;
}
</style>