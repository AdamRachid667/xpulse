<template>

<div style="background:#080810; min-height:100vh;">

  <!-- Header -->
  <div class="xp-header q-px-lg q-py-md row justify-between items-center">

    <span class="xp-logo">XPULSE</span>

    <div class="row items-center q-gutter-sm">

      <!-- Barre de recherche -->
      <q-input
        v-model="searchQuery"
        dark
        dense
        filled
        placeholder="Rechercher..."
        style="width:220px; background:#1a1a2e; border-radius:8px;"
        @keyup.enter="search"
      >
        <template #append>
          <q-icon name="search" color="purple" style="cursor:pointer" @click="search" />
        </template>
      </q-input>

      <q-btn
        flat
        dense
        color="purple"
        label="+ Post"
        class="xp-btn"
        @click="$router.push('/create')"
      />

      <q-btn
        v-if="!currentUser"
        flat
        dense
        color="grey-4"
        label="Connexion"
        class="xp-btn"
        @click="$router.push('/login')"
      />

      <div v-else class="row items-center q-gutter-xs">
        <span
          class="xp-username"
          @click="$router.push('/profile/' + currentUser.id)"
        >
          {{ currentUser.username }}
        </span>
        <q-btn flat dense color="grey-6" icon="logout" size="sm" @click="logout" />
      </div>

    </div>

  </div>

  <!-- Résultats de recherche -->
  <div v-if="searchMode" class="q-pa-md" style="max-width:700px; margin:0 auto;">

    <div class="row items-center q-mb-md">
      <span class="text-grey-4" style="font-size:0.9rem;">
        Résultats pour "{{ lastQuery }}"
      </span>
      <q-btn flat dense color="grey-6" icon="close" size="sm" class="q-ml-sm" @click="clearSearch" />
    </div>

    <!-- Comptes trouvés -->
    <div v-if="searchResults.users && searchResults.users.length" class="q-mb-md">
      <div class="text-grey-5 q-mb-sm" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:1px;">Comptes</div>
      <div
        v-for="u in searchResults.users"
        :key="u.id"
        class="xp-card q-pa-md q-mb-sm row items-center"
        style="cursor:pointer"
        @click="$router.push('/profile/' + u.id)"
      >
        <q-avatar size="32px" color="purple" text-color="white" class="q-mr-md">
          {{ u.username[0].toUpperCase() }}
        </q-avatar>
        <span class="xp-username">{{ u.username }}</span>
      </div>
    </div>

    <!-- Posts trouvés -->
    <div class="text-grey-5 q-mb-sm" style="font-size:0.8rem; text-transform:uppercase; letter-spacing:1px;">
      Posts ({{ searchResults.posts ? searchResults.posts.length : 0 }})
    </div>

    <div v-if="searchResults.posts && searchResults.posts.length === 0" class="text-grey-6 q-pa-md">
      Aucun post trouvé.
    </div>

    <PostCard
      v-for="post in searchResults.posts"
      :key="post.id"
      :post="post"
      :current-user="currentUser"
      @like="likePost"
      @profile="goProfile"
    />

  </div>

  <!-- Feed normal -->
  <div v-else class="q-pa-md" style="max-width:700px; margin:0 auto;">

    <div v-if="posts.length === 0" class="text-center q-mt-xl text-grey-6">
      Aucun post pour l'instant.
    </div>

    <PostCard
      v-for="post in posts"
      :key="post.id"
      :post="post"
      :current-user="currentUser"
      @like="likePost"
      @profile="goProfile"
    />

  </div>

</div>

</template>

<script setup>

import { ref, onMounted, defineAsyncComponent } from 'vue'
import { useRouter } from 'vue-router'

const PostCard = defineAsyncComponent(() => import('components/PostCard.vue'))

const router = useRouter()

const posts = ref([])
const currentUser = ref(null)
const searchQuery = ref('')
const searchMode = ref(false)
const lastQuery = ref('')
const searchResults = ref({ posts: [], users: [] })

function logout() {
  localStorage.removeItem('user')
  currentUser.value = null
}

function goProfile(userId) {
  router.push('/profile/' + userId)
}

async function getPosts() {
  const response = await fetch('http://localhost/adam/xpulse/backend/get_posts.php')
  posts.value = await response.json()
}

async function likePost(id) {
  await fetch('http://localhost/adam/xpulse/backend/like.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id })
  })
  getPosts()
}

async function search() {
  const q = searchQuery.value.trim()
  if (!q) return
  lastQuery.value = q
  const response = await fetch('http://localhost/adam/xpulse/backend/search.php?q=' + encodeURIComponent(q))
  searchResults.value = await response.json()
  searchMode.value = true
}

function clearSearch() {
  searchQuery.value = ''
  searchMode.value = false
  searchResults.value = { posts: [], users: [] }
}

onMounted(() => {
  const stored = localStorage.getItem('user')
  if (stored) currentUser.value = JSON.parse(stored)
  getPosts()
})

</script>
