<template>

<div class="q-pa-md flex flex-center">

  <q-card
    class="bg-grey-10 text-white"
    style="width:400px"
  >

    <q-card-section>

      <div class="text-h5 text-purple">
        Inscription
      </div>

    </q-card-section>

    <q-card-section>

      <q-input
        filled
        dark
        v-model="username"
        label="Pseudo"
      />

      <q-input
        filled
        dark
        v-model="email"
        label="Email"
        class="q-mt-md"
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
        label="Créer le compte"
        class="full-width q-mt-md"
        @click="register"
      />

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

async function register() {

  await fetch(
    'http://localhost/adam/xpulse/backend/register.php',
    {
      method: 'POST',

      headers: {
        'Content-Type': 'application/json'
      },

      body: JSON.stringify({
        username: username.value,
        email: email.value,
        password: password.value
      })
    }
  )

  router.push('/login')
}

</script>