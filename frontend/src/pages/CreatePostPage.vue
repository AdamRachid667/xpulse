<template>

<div style="min-height:100vh; background:#080810;">

  <!-- Header -->
  <div class="xp-header q-px-lg q-py-md row items-center">
    <q-btn flat dense icon="arrow_back" color="grey-5" @click="$router.push('/')" />
    <span class="xp-logo q-ml-md">XPULSE</span>
  </div>

  <div class="flex flex-center q-pa-md">

    <q-card class="xp-card q-pa-md" style="width:560px;">

      <q-card-section class="q-pb-none">
        <div class="text-h6 text-white" style="font-weight:800;">Nouveau post</div>
        <div v-if="currentUser" class="text-grey-5 q-mt-xs" style="font-size:0.85rem;">
          Publié en tant que <span class="text-purple">{{ currentUser.username }}</span>
        </div>
      </q-card-section>

      <q-card-section>

        <q-banner v-if="errorMsg" class="q-mb-md" style="background:#3b0a0a; color:#f87171; border-radius:8px; font-size:0.9rem;">
          {{ errorMsg }}
        </q-banner>

        <div v-if="!currentUser" class="text-center q-pa-md text-grey-5">
          Tu dois être connecté pour publier.
          <div class="q-mt-md">
            <q-btn color="primary" label="Se connecter" @click="$router.push('/login')" />
          </div>
        </div>

        <div v-else>

          <q-input
            filled
            dark
            v-model="title"
            label="Titre"
            class="xp-input q-mb-md"
            maxlength="100"
            counter
          />

          <q-input
            filled
            dark
            type="textarea"
            v-model="content"
            label="Contenu"
            class="xp-input q-mb-lg"
            autogrow
            rows="4"
          />

          <q-btn
            color="primary"
            label="Publier"
            class="xp-btn full-width"
            :loading="loading"
            @click="createPost"
          />

        </div>

      </q-card-section>

    </q-card>

  </div>

</div>

</template>

<script setup>

import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const title = ref('')
const content = ref('')
const errorMsg = ref('')
const loading = ref(false)
const currentUser = ref(null)

async function createPost() {

  errorMsg.value = ''

  if (!title.value.trim() || !content.value.trim()) {
    errorMsg.value = 'Le titre et le contenu sont obligatoires.'
    return
  }

  loading.value = true

  try {
    await fetch('http://localhost/xpluse/xpulse/backend/create_post.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        title: title.value,
        content: content.value,
        user_id: currentUser.value.id
      })
    })
    router.push('/')
  } catch {
    errorMsg.value = 'Erreur de connexion au serveur.'
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  const stored = localStorage.getItem('user')
  if (stored) currentUser.value = JSON.parse(stored)
})

</script>
