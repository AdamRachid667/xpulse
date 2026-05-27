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
            class="xp-input q-mb-md"
            autogrow
            rows="4"
          />

          <!-- Image optionnelle -->
          <q-file
            filled
            dark
            v-model="imageFile"
            label="Image (optionnelle)"
            accept="image/*"
            class="xp-input q-mb-md"
            clearable
          >
            <template #prepend>
              <q-icon name="image" color="purple" />
            </template>
          </q-file>

          <!-- Aperçu de l'image -->
          <div v-if="imagePreview" class="q-mb-lg">
            <img :src="imagePreview" style="max-width:100%; border-radius:10px; max-height:300px; object-fit:cover;" />
          </div>

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

import { ref, watch, onMounted } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const title = ref('')
const content = ref('')
const errorMsg = ref('')
const loading = ref(false)
const currentUser = ref(null)
const imageFile = ref(null)
const imagePreview = ref(null)

// Génère un aperçu quand l'utilisateur choisit une image
watch(imageFile, (file) => {
  if (!file) { imagePreview.value = null; return }
  const reader = new FileReader()
  reader.onload = (e) => { imagePreview.value = e.target.result }
  reader.readAsDataURL(file)
})

async function createPost() {

  errorMsg.value = ''

  if (!title.value.trim() || !content.value.trim()) {
    errorMsg.value = 'Le titre et le contenu sont obligatoires.'
    return
  }

  loading.value = true

  try {
    // Utilise FormData pour pouvoir envoyer l'image en même temps
    const formData = new FormData()
    formData.append('title', title.value)
    formData.append('content', content.value)
    formData.append('user_id', currentUser.value.id)
    if (imageFile.value) formData.append('image', imageFile.value)

    await fetch('http://localhost/xpluse/xpulse/backend/create_post.php', {
      method: 'POST',
      body: formData
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
