<!-- src/pages/LoginPage.vue -->

<template>

<div class="q-pa-md flex flex-center">

  <q-card
    class="bg-grey-10 text-white"
    style="width:400px"
  >

    <q-card-section>

      <div class="text-h5 text-purple">
        Connexion
      </div>

    </q-card-section>

    <q-card-section>

      <q-input
        filled
        dark
        v-model="email"
        label="Email"
      />

      <q-input
        filled
        dark
        type="password"
        v-model="password"
        label="Mot de passe"
        class="q-mt-md"
      />

      <q-btn
        color="purple"
        label="Connexion"
        class="full-width q-mt-md"
        @click="login"
      />

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

async function login() {

  const response = await fetch(
    'http://localhost/adam/xpulse/backend/login.php',
    {
      method: 'POST',

      headers: {
        'Content-Type': 'application/json'
      },

      body: JSON.stringify({
        email: email.value,
        password: password.value
      })
    }
  )

  const data = await response.json()

  if(data.success) {

    localStorage.setItem(
      'user',
      JSON.stringify(data.user)
    )

    router.push('/')
  }
}

</script>