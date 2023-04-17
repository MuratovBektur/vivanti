<template>
  <div class="py-5">
    <textarea
      v-model="commentModel"
      placeholder="Введите ответ"
      type="text"
      rows="4"
      class="block p-4 w-full border border-slate-800 rounded-lg focus:border-cyan-500 focus:outline-none focus:border"
    />
    <btn @click="addComment" color="#06B6D4">Написать сообщения</btn>
  </div>
</template>

<script setup lang="ts">
import btn from '@/components/btn.vue'
import { usePostStore } from '@/stores/post.js'
import type { IPost } from '@/types'
import { ref, toRefs } from 'vue'

interface IProps {
  post: IPost
}
const props = defineProps<IProps>()
const postStore = usePostStore()

const { post } = toRefs(props)
const commentModel = ref<string>('')

async function addComment() {
  try {
    const post_id = post.value.id
    await postStore.addComment({
      content: commentModel.value,
      post_id,
      parent_id: null,
      is_it_reply_to_comment: false
    })
    // обновляем комменты
    await postStore.fetchPost(post_id)
    commentModel.value = ''
  } catch (err) {
    console.error(err)
  }
}
</script>
