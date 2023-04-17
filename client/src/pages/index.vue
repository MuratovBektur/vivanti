<script setup lang="ts">
import { RouterLink } from 'vue-router'
import { onBeforeMount, ref } from 'vue'

import type { IPost } from '@/types'
import api from '@/libs/api'

const posts = ref<IPost[]>([])

onBeforeMount(async () => {
  const { data } = await api.get<IPost[]>('post/all')
  posts.value = data
})
</script>

<template>
  <div class="w-[40rem] mx-auto">
    <h1 class="mb-10 text-center font-bold text-2xl">Список постов</h1>
    <div v-if="posts?.length">
      <router-link
        v-for="post of posts"
        :key="post.id"
        class="block font-medium underline py-2"
        :to="`post/${post.id}`"
      >
        {{ post.title }}
      </router-link>
    </div>
  </div>
</template>
