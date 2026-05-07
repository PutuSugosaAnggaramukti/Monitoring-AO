<template>
  <div class="bg-login">
    
    <v-card width="420" class="pa-8 rounded-xl elevation-4 login-card">

      <div class="text-center mb-6">
        <img src="/logo.png" class="logo mb-2" />
        <div class="text-h6 font-weight-bold text-primary">
          Monitoring
        </div>
        <div class="text-caption text-grey">
          AO Bank Bantul
        </div>
      </div>

     <!--FORM -->
     <v-form ref="formRef" @submit.prevent="handleLogin">

        <!-- Username -->
        <v-text-field
            v-model="username"
            label="Username"
            variant="outlined"
            bg-color="white"
            color="primary"
            rounded="lg"
            density="comfortable"
            :rules="[rules.required]"
            class="mb-3"
        />

        <!-- Password -->
        <v-text-field
            v-model="password"
            :type="showPassword ? 'text' : 'password'"
            label="Password"
            variant="outlined"
            bg-color="white"
            color="primary"
            rounded="lg"
            density="comfortable"
            :rules="[rules.required]"
            class="mb-5"
        />

            <!-- Login Button -->
            <v-btn
                block
                class="mb-3 login-btn"
                type="submit"
                :loading="loading"
            >
            Login
            </v-btn>

            <!-- Reset Password -->
            <v-btn
                block
                variant="outlined"
                class="reset-btn"
                @click="dialogReset = true"
            >
            Reset Password
            </v-btn>
        </v-form>
    </v-card>

   <v-dialog v-model="dialogReset" max-width="400" scrim="transparent">
        <v-card class="pa-6 rounded-xl reset-card" bg-color="white">

            <div class="text-h6 mb-4 font-weight-bold">
            Reset Password
            </div>

            <!-- Username -->
            <v-text-field
            v-model="resetUsername"
            label="Username"
            variant="outlined"
            bg-color="white"
            class="mb-3"
            />

            <!-- Password Baru -->
            <v-text-field
            v-model="newPassword"
            label="Password Baru"
            type="password"
            variant="outlined"
            bg-color="white"
            class="mb-3"
            />

            <!-- Konfirmasi Password -->
            <v-text-field
            v-model="confirmPassword"
            label="Konfirmasi Password"
            type="password"
            variant="outlined"
            bg-color="white"
            class="mb-4"
            />

            <!-- Button -->
            <v-btn
            block
            class="mb-2 login-btn"
            :loading="loadingReset"
            @click="handleResetPassword"
            >
            Simpan Password
            </v-btn>

            <v-btn block variant="text" @click="dialogReset = false">
            Batal
            </v-btn>

        </v-card>
        </v-dialog>

  </div>
</template>

<script setup>
import { ref } from 'vue'
import {useRouter} from 'vue-router'

const router = useRouter()

const username = ref('')
const password = ref('')
const loading = ref(false)
const showPassword = ref(false)
const formRef = ref(null)

// rules validasi
const rules = {
  required: v => !!v || 'Field wajib diisi'
}

// submit login
const handleLogin = async () => {
  const { valid } = await formRef.value.validate()

  if (!valid) return

  loading.value = true

  // simulasi API
  setTimeout(() => {
    console.log('Login:', username.value, password.value)
    loading.value = false
    router.push('/menu')
  }, 1500)
}

// reset form
const handleReset = () => {
  username.value = ''
  password.value = ''
  formRef.value.resetValidation()
}

// ===== RESET PASSWORD =====
const dialogReset = ref(false)
const loadingReset = ref(false)

const resetUsername = ref('')
const newPassword = ref('')
const confirmPassword = ref('')

const handleResetPassword = () => {
  // validasi
  if (!resetUsername.value || !newPassword.value || !confirmPassword.value) {
    alert('Semua field wajib diisi')
    return
  }

  if (newPassword.value !== confirmPassword.value) {
    alert('Password tidak sama')
    return
  }

  loadingReset.value = true

  // simulasi API
  setTimeout(() => {
    console.log('Reset:', {
      username: resetUsername.value,
      password: newPassword.value
    })

    loadingReset.value = false
    dialogReset.value = false

    // reset form
    resetUsername.value = ''
    newPassword.value = ''
    confirmPassword.value = ''
  }, 1500)
}

</script>

<style scoped>

/* ===== ROOT BACKGROUND ===== */
.bg-login {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;

  display: flex;
  align-items: center;
  justify-content: center;

  /* background utama */
  background: url('/bg-login.png') center/cover no-repeat;

  overflow: hidden;
  z-index: 0;
}

/* ===== OVERLAY + GARIS DIAGONAL ===== */
.bg-login::before {
  content: "";
  position: absolute;
  inset: 0;

  /* overlay putih transparan + garis */
  background:
    linear-gradient(rgba(255,255,255,0.7), rgba(255,255,255,0.7)),
    repeating-linear-gradient(
      135deg,
      rgba(0,0,0,0.03) 0px,
      rgba(0,0,0,0.03) 2px,
      transparent 2px,
      transparent 12px
    );

  z-index: 1;
  pointer-events: none;
}

/* ===== ORNAMEN BIRU KIRI ATAS ===== */
.bg-login::after {
  content: "";
  position: absolute;
  top: -120px;
  left: -120px;

  width: 320px;
  height: 320px;

  background: #2d5aa3;
  border-radius: 50px;
  transform: rotate(45deg);

  z-index: 1;
  pointer-events: none;
}

/* ===== CARD LOGIN ===== */
.login-card {
  position: relative;
  z-index: 2;

  width: 420px;
  padding: 32px;

  background: rgba(255, 255, 255, 0.6);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.3);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
  border-radius: 16px;
}

/* ===== CARD RESET PASSWORD ===== */
.reset-card {
  background: rgba(255, 255, 255, 0.6);
  backdrop-filter: blur(10px);
  -webkit-backdrop-filter: blur(10px);

  border: 1px solid rgba(255, 255, 255, 0.3);
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);

  color: #000; 
}

/* ===== LOGO ===== */
.logo {
  width: 120px;
  object-fit: contain;
}

/* ===== BUTTON LOGIN ===== */
.login-btn {
  background: #2d5aa3;
  color: #fff;
  border-radius: 999px;
  text-transform: none;
  font-weight: 600;
}

/* ===== BUTTON RESET ===== */
.reset-btn {
  border-radius: 999px;
  border: 1px solid #2d5aa3;
  color: #2d5aa3;
  background:  rgba(255,255,255,0.7);
  text-transform: none;
}

/* ===== RESPONSIVE (MOBILE) ===== */
@media (max-width: 600px) {
  .login-card {
    width: 90%;
    padding: 24px;
  }

  .logo {
    width: 100px;
  }
}

</style>