<template>

<div style="min-height:100vh; background:#080810;">

  <!-- Header -->
  <div class="xp-header q-px-lg q-py-md row items-center">
    <q-btn flat dense icon="arrow_back" color="grey-5" @click="$router.push('/')" />
    <span class="xp-logo q-ml-md">XPULSE</span>
  </div>

  <div class="q-pa-md" style="max-width:700px; margin:0 auto;">

    <div v-if="!profileData" class="text-center text-grey-6 q-mt-xl">
      Chargement...
    </div>

    <div v-else>

      <!-- Carte profil -->
      <div class="xp-card q-pa-lg q-mb-lg">

        <div class="row items-center q-mb-md">
          <q-avatar size="64px" color="purple" text-color="white" class="q-mr-lg" style="font-size:1.8rem; font-weight:900;">
            {{ profileData.user.username[0].toUpperCase() }}
          </q-avatar>
          <div>
            <div class="text-white" style="font-size:1.3rem; font-weight:800;">
              {{ profileData.user.username }}
            </div>
            <div class="text-grey-5" style="font-size:0.85rem;">
              {{ profileData.posts.length }} post{{ profileData.posts.length > 1 ? 's' : '' }}
            </div>
          </div>
        </div>

        <!-- Bio -->
        <div v-if="!editingBio">
          <div class="text-grey-4 q-mb-sm" style="font-size:0.9rem; line-height:1.6;">
            {{ profileData.user.bio || 'Aucune bio.' }}
          </div>
          <q-btn
            v-if="isOwner"
            flat
            dense
            color="purple"
            label="Modifier la bio"
            icon="edit"
            class="xp-btn"
            @click="startEdit"
          />
        </div>

        <div v-else>
          <q-input
            filled
            dark
            type="textarea"
            v-model="bioInput"
            label="Ta bio"
            class="xp-input q-mb-sm"
            autogrow
            rows="3"
            maxlength="300"
            counter
          />
          <div class="row q-gutter-sm">
            <q-btn
              color="primary"
              label="Enregistrer"
              class="xp-btn"
              :loading="savingBio"
              @click="saveBio"
            />
            <q-btn
              flat
              color="grey-5"
              label="Annuler"
              class="xp-btn"
              @click="editingBio = false"
            />
          </div>
        </div>

      </div>

      <!-- Posts de l'utilisateur -->
      <div class="text-grey-5 q-mb-md" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:1px;">
        Posts de {{ profileData.user.username }}
      </div>

      <div v-if="profileData.posts.length === 0" class="text-grey-6">
        Aucun post pour l'instant.
      </div>

      <div
        v-for="post in profileData.posts"
        :key="post.id"
        class="xp-card q-mb-md q-pa-md"
      >
        <div class="text-white q-mb-xs" style="font-weight:700; font-size:1.05rem;">
          {{ post.title }}
        </div>
        <div class="text-grey-4 q-mb-md" style="font-size:0.92rem; line-height:1.5;">
          {{ post.content }}
        </div>
        <div class="row items-center q-gutter-sm">
          <span class="xp-tag">👍 {{ post.likes }}</span>
          <span class="xp-tag">💬 {{ post.comments_count || 0 }}</span>
          <span class="text-grey-6" style="font-size:0.78rem; margin-left:auto;">
            {{ formatDate(post.created_at) }}
          </span>
        </div>
      </div>

    </div>

  </div>

</div>

</template>

<script setup>

import { ref, onMounted, computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const profileData = ref(null)
const editingBio = ref(false)
const bioInput = ref('')
const savingBio = ref(false)
const currentUser = ref(null)

const isOwner = computed(() => {
  if (!currentUser.value || !profileData.value) return false
  return String(currentUser.value.id) === String(route.params.id)
})

function formatDate(dt) {
  if (!dt) return ''
  const d = new Date(dt)
  return d.toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' })
}

function startEdit() {
  bioInput.value = profileData.value.user.bio || ''
  editingBio.value = true
}

async function saveBio() {
  savingBio.value = true

  await fetch('http://localhost/xpluse/xpulse/backend/update_bio.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      user_id: currentUser.value.id,
      bio: bioInput.value
    })
  })

  profileData.value.user.bio = bioInput.value
  savingBio.value = false
  editingBio.value = false
}

async function loadProfile() {
  const response = await fetch(
    'http://localhost/xpluse/xpulse/backend/get_profile.php?user_id=' + route.params.id
  )
  profileData.value = await response.json()
}

onMounted(() => {
  const stored = localStorage.getItem('user')
  if (stored) currentUser.value = JSON.parse(stored)
  loadProfile()
})

</script>
