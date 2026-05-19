<template>

<div class="q-pa-md flex flex-center">

  <q-card
    class="bg-grey-10 text-white"
    style="width:500px"
  >

    <q-card-section>

      <div class="text-h5 text-purple">
        Nouveau post
      </div>

    </q-card-section>

    <q-card-section>

      <q-input
        filled
        dark
        v-model="title"
        label="Titre"
      />

      <q-input
        filled
        dark
        type="textarea"
        v-model="content"
        label="Texte"
        class="q-mt-md"
      />

      <q-btn
        color="purple"
        label="Publier"
        class="full-width q-mt-md"
        @click="createPost"
      />

    </q-card-section>

  </q-card>

</div>

</template>

<script setup>

import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const title = ref('')
const content = ref('')

async function createPost() {

  const user = JSON.parse(
    localStorage.getItem('user')
  )

  // AJOUTE ÇA POUR TESTER
  console.log(user)

  await fetch(
    'http://localhost/adam/xpulse/backend/create_post.php',
    {
      method: 'POST',

      headers: {
        'Content-Type': 'application/json'
      },

      body: JSON.stringify({
        title: title.value,
        content: content.value,
        user_id: user.id
      })
    }
  )

  router.push('/')
}

</script>