<template>

<div class="q-pa-md">

  <div class="row justify-between items-center">

    <h3 class="text-purple">
      XPULSE
    </h3>

    <div>

      <q-btn
        color="purple"
        label="Créer"
        class="q-mr-sm"
        @click="$router.push('/create')"
      />

      <q-btn
        color="dark"
        label="Connexion"
        @click="$router.push('/login')"
      />

    </div>

  </div>

  <q-card
    v-for="post in posts"
    :key="post.id"
    class="q-mt-md bg-grey-10 text-white"
  >

    <q-card-section>

      <div class="text-purple">
        {{ post.username }}
      </div>

      <div class="text-h6">
        {{ post.title }}
      </div>

      <div>
        {{ post.content }}
      </div>

      <div class="q-mt-md">
        👍 {{ post.likes }}
      </div>

      <q-btn
        color="purple"
        label="Like"
        class="q-mt-md"
        @click="likePost(post.id)"
      />

    </q-card-section>

  </q-card>

</div>

</template>

<script setup>

import { ref, onMounted } from 'vue'

const posts = ref([])

async function getPosts() {

  const response = await fetch(
    'http://localhost/adam/xpulse/backend/get_posts.php'
  )

  posts.value = await response.json()
}

async function likePost(id) {

  await fetch(
    'http://localhost/adam/xpulse/backend/like.php',
    {
      method: 'POST',

      headers: {
        'Content-Type': 'application/json'
      },

      body: JSON.stringify({
        id: id
      })
    }
  )

  getPosts()
}

onMounted(() => {
  getPosts()
})

</script>