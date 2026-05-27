<template>

<div class="xp-card q-mb-md q-pa-md">

  <!-- Auteur + date -->
  <div class="row items-center q-mb-sm">
    <q-avatar size="32px" color="purple" text-color="white" class="q-mr-sm" style="font-weight:800; font-size:0.85rem;">
      {{ post.username ? post.username[0].toUpperCase() : '?' }}
    </q-avatar>
    <div>
      <span class="xp-username" @click="$emit('profile', post.user_id)">
        {{ post.username }}
      </span>
      <div class="text-grey-6" style="font-size:0.75rem;">
        {{ formatDate(post.created_at) }}
      </div>
    </div>
  </div>

  <!-- Titre + contenu -->
  <div class="text-white q-mb-xs" style="font-weight:700; font-size:1.05rem;">
    {{ post.title }}
  </div>
  <div class="text-grey-4 q-mb-sm" style="font-size:0.92rem; line-height:1.5;">
    {{ post.content }}
  </div>

  <!-- Image optionnelle du post -->
  <div v-if="post.image" class="q-mb-md">
    <img
      :src="'http://localhost/xpluse/xpulse/backend/' + post.image"
      style="max-width:100%; border-radius:10px; max-height:400px; object-fit:cover;"
    />
  </div>

  <!-- Actions -->
  <div class="row items-center q-gutter-sm">

    <q-btn
      flat
      dense
      color="purple"
      icon="thumb_up"
      :label="String(post.likes)"
      class="xp-btn"
      @click="$emit('like', post.id)"
    />

    <q-btn
      flat
      dense
      :color="showComments ? 'purple' : 'grey-6'"
      icon="chat_bubble_outline"
      :label="String(localCommentsCount)"
      class="xp-btn"
      @click="toggleComments"
    />

  </div>

  <!-- Section commentaires -->
  <div v-if="showComments" class="q-mt-md">

    <q-separator dark class="q-mb-md" />

    <div v-if="comments.length === 0" class="text-grey-6" style="font-size:0.85rem;">
      Aucun commentaire.
    </div>

    <div
      v-for="c in comments"
      :key="c.id"
      class="q-mb-sm"
      style="background:#1a1a2e; border-radius:8px; padding:10px 14px;"
    >
      <span class="text-purple" style="font-size:0.8rem; font-weight:700;">{{ c.username }}</span>
      <div class="text-grey-3" style="font-size:0.88rem; margin-top:2px;">{{ c.content }}</div>
    </div>

    <!-- Ajouter un commentaire -->
    <div v-if="currentUser" class="row items-center q-mt-sm q-gutter-sm">
      <q-input
        filled
        dark
        dense
        v-model="newComment"
        placeholder="Ton commentaire..."
        style="flex:1; background:#1a1a2e; border-radius:8px;"
        @keyup.enter="addComment"
      />
      <q-btn
        flat
        dense
        color="purple"
        icon="send"
        @click="addComment"
      />
    </div>

    <div v-else class="text-grey-6 q-mt-sm" style="font-size:0.82rem;">
      <a href="#/login" class="text-purple" style="text-decoration:none;">Connecte-toi</a> pour commenter.
    </div>

  </div>

</div>

</template>

<script setup>

import { ref } from 'vue'

const props = defineProps({
  post: Object,
  currentUser: Object
})

defineEmits(['like', 'profile'])

const localCommentsCount = ref(props.post.comments_count || 0)

const showComments = ref(false)
const comments = ref([])
const newComment = ref('')

function formatDate(dt) {
  if (!dt) return ''
  const d = new Date(dt)
  return d.toLocaleDateString('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' })
}

async function loadComments() {
  const response = await fetch(
    'http://localhost/xpluse/xpulse/backend/get_comments.php?post_id=' + props.post.id
  )
  comments.value = await response.json()
}

async function toggleComments() {
  showComments.value = !showComments.value
  if (showComments.value) loadComments()
}

async function addComment() {
  if (!newComment.value.trim()) return

  await fetch('http://localhost/xpluse/xpulse/backend/add_comment.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      post_id: props.post.id,
      user_id: props.currentUser.id,
      content: newComment.value
    })
  })

  newComment.value = ''
  localCommentsCount.value++
  loadComments()
}

</script>
