<script setup lang="ts">
import { storeToRefs } from 'pinia'
import { useRoute } from 'vue-router'

import CommentPanelAdd from '@/components/comment-panel-add.vue'
import CommentPanel from '@/components/comment-panel.vue'
import { usePostStore } from '@/stores/post.js'

const route = useRoute()
const postStore = usePostStore()

const { post } = storeToRefs(postStore)

function fetchPost() {
  const postId = +route.params.id
  if (isNaN(postId)) return

  postStore.fetchPost(postId)
}

fetchPost()
</script>

<template>
  <div v-if="post">
    <h1 class="mb-10 text-center font-bold text-2xl">{{ post.title }}</h1>
    <div class="mb-10 text-lg">
      {{ post.content }}
    </div>
    <CommentPanelAdd :post="post" />
    <h2 class="text-center text-xl font-bold py-10">Комментарии</h2>
    <CommentPanel :comments="post.comments" />
  </div>
</template>
