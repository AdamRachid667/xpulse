<template>

<div class="flex flex-center" style="min-height:100vh; background:#080810;">

  <q-card class="xp-card q-pa-md" style="width:400px;">

    <q-card-section class="text-center q-pb-none">
      <div class="xp-logo q-mb-xs">XPULSE</div>
      <div class="text-grey-5" style="font-size:0.9rem;">Crée ton compte</div>
    </q-card-section>

    <q-card-section>

      <q-banner v-if="errorMsg" class="q-mb-md" style="background:#3b0a0a; color:#f87171; border-radius:8px; font-size:0.9rem;">
        {{ errorMsg }}
      </q-banner>

      <q-banner v-if="successMsg" class="q-mb-md" style="background:#0a3b1a; color:#4ade80; border-radius:8px; font-size:0.9rem;">
        {{ successMsg }}
      </q-banner>

      <q-input
        filled
        dark
        v-model="username"
        label="Pseudo"
        class="xp-input q-mb-md"
      />

      <q-input
        filled
        dark
        v-model="email"
        label="Email"
        class="xp-input q-mb-md"
      />

      <q-input
        filled
        dark
        type="password"
        v-model="password"
        label="Mot de passe"
        class="xp-input q-mb-lg"
        @keyup.enter="register"
      />

      <q-btn
        color="primary"
        label="Créer le compte"
        class="xp-btn full-width"
        :loading="loading"
        @click="register"
      />

      <div class="text-center q-mt-md text-grey-5" style="font-size:0.85rem;">
        Déjà un compte ?
        <span
          class="text-purple"
          style="cursor:pointer; font-weight:700;"
          @click="$router.push('/login')"
        >
          Se connecter
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

const username = ref('')
const email = ref('')
const password = ref('')
const errorMsg = ref('')
const successMsg = ref('')
const loading = ref(false)

async function register() {

  errorMsg.value = ''
  successMsg.value = ''

  if (!username.value || !email.value || !password.value) {
    errorMsg.value = 'Remplis tous les champs.'
    return
  }

  if (password.value.length < 6) {
    errorMsg.value = 'Le mot de passe doit faire au moins 6 caractères.'
    return
  }

  loading.value = true

  const response = await fetch(
    'http://localhost/adam/xpulse/backend/register.php',
    {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        username: username.value,
        email: email.value,
        password: password.value
      })
    }
  )

  const data = await response.json()
  loading.value = false

  if (data.error) {
    errorMsg.value = data.error
  } else {
    successMsg.value = 'Compte créé ! Redirection...'
    setTimeout(() => router.push('/login'), 1500)
  }
}

</script>
