<template>

<div class="flex flex-center" style="min-height:100vh; background:#080810;">

  <q-card class="xp-card q-pa-md" style="width:400px;">

    <q-card-section class="text-center q-pb-none">
      <div class="xp-logo q-mb-xs">XPULSE</div>
      <div class="text-grey-5" style="font-size:0.9rem;">Connexion à ton compte</div>
    </q-card-section>

    <q-card-section>

      <q-banner v-if="errorMsg" class="q-mb-md" style="background:#3b0a0a; color:#f87171; border-radius:8px; font-size:0.9rem;">
        {{ errorMsg }}
      </q-banner>

      <q-input
        filled
        dark
        v-model="email"
        label="Email"
        class="xp-input q-mb-md"
        @keyup.enter="login"
      />

      <q-input
        filled
        dark
        type="password"
        v-model="password"
        label="Mot de passe"
        class="xp-input q-mb-lg"
        @keyup.enter="login"
      />

      <q-btn
        color="primary"
        label="Se connecter"
        class="xp-btn full-width"
        :loading="loading"
        @click="login"
      />

      <div class="text-center q-mt-md text-grey-5" style="font-size:0.85rem;">
        Pas encore de compte ?
        <span
          class="text-purple"
          style="cursor:pointer; font-weight:700;"
          @click="$router.push('/register')"
        >
          S'inscrire
        </span>
      </div>

    </q-card-section>

  </q-card>

</div>

</template>

<script setup>

import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const email = ref('')
const password = ref('')
const errorMsg = ref('')
const loading = ref(false)

async function login() {

  errorMsg.value = ''

  if (!email.value || !password.value) {
    errorMsg.value = 'Remplis tous les champs.'
    return
  }

  loading.value = true

  try {
    const response = await fetch(
      'http://localhost/xpluse/xpulse/backend/login.php',
      {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          email: email.value,
          password: password.value
        })
      }
    )

    const data = await response.json()

    if (data.success) {
      localStorage.setItem('user', JSON.stringify(data.user))
      router.push('/')
    } else {
      errorMsg.value = 'Email ou mot de passe incorrect.'
    }
  } catch {
    errorMsg.value = 'Erreur de connexion au serveur.'
  } finally {
    loading.value = false
  }
}

</script>
