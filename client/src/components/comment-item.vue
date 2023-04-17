<script setup lang="ts">
import { computed, nextTick, ref, toRefs } from 'vue'
import dayjs from 'dayjs'

import btn from '@/components/btn.vue'
import type { IComment } from '@/types'
import { usePostStore } from '@/stores/post.js'
import api from '@/libs/api'

interface IProps {
  comment: IComment
}
const props = defineProps<IProps>()
const postStore = usePostStore()

const { comment } = toRefs(props)

const commentCreateadDate = computed(() =>
  dayjs(comment.value.created_at).format('YYYY-MM-DD HH:mm')
)
// лайкал ли до этого пользователь
const isLikePressed = computed(() => comment.value.comments_likes?.length)

const textareaElement = ref<HTMLTextAreaElement>()
const commentModel = ref<string>('')
const showAddCommentPanel = ref<boolean>(false)

async function toggleComment() {
  try {
    const url = isLikePressed.value ? 'comment/removeLike' : 'comment/addLike'
    const post_id = comment.value.post_id
    await api.post(url, {
      comment_id: comment.value.id,
      user_id: postStore.user_id
    })
    // обновляем комменты
    await postStore.fetchPost(post_id)
  } catch (err) {
    console.error(err)
  }
}

async function addComment() {
  try {
    // это ответ на коммент на втором уровне?
    const is_it_reply_to_comment = !!comment.value.parent_id
    const parent_id = comment.value.parent_id || comment.value.id

    // если это ответ на коммент на втором уровне,
    // то вначале коммента добавляем имя человек к которому идет обращение
    const content = `${
      is_it_reply_to_comment ? `<span class='username'>${comment.value.user.fullname}</span>, ` : ''
    }${commentModel.value}`

    const post_id = comment.value.post_id

    await postStore.addComment({
      content,
      post_id,
      parent_id,
      is_it_reply_to_comment
    })
    // обновляем комменты
    await postStore.fetchPost(post_id)
    showAddCommentPanel.value = false
    commentModel.value = ''
  } catch (err) {
    console.error(err)
  }
}
async function openAddCommentPanel() {
  showAddCommentPanel.value = true
  await nextTick()
  textareaElement.value?.focus()
}
function closeAddCommentPanel() {
  showAddCommentPanel.value = false
  commentModel.value = ''
}
</script>

<script lang="ts">
export default {
  inheritAttrs: false
}
</script>

<template>
  <div class="py-5">
    <div class="flex">
      <div class="grow font-medium">
        {{ comment.user.fullname }}
      </div>
      <div>
        {{ commentCreateadDate }}
      </div>
    </div>
    <div class="py-3" v-html="comment.content"></div>
    <div class="flex items-center">
      <button class="text-red-500" @click="toggleComment">
        <img v-if="isLikePressed" class="w-6" src="@/assets/img/highlighted-like.svg" alt="like" />
        <img v-else class="w-6" src="@/assets/img/like.svg" alt="like" />
      </button>
      <div class="ml-3">
        {{ comment.like_count }}
      </div>
      <button
        @click="openAddCommentPanel"
        class="ml-4 py-2 px-4 rounded-full transition-all duration-300 hover:bg-cyan-400 hover:text-white"
      >
        Ответить
      </button>
    </div>
    <div v-if="showAddCommentPanel" class="pt-5">
      <textarea
        ref="textareaElement"
        v-model="commentModel"
        placeholder="Введите ответ"
        type="text"
        rows="4"
        class="block p-4 w-full border border-slate-800 rounded-lg focus:border-cyan-500 focus:outline-none focus:border"
      />
      <div class="flex space-x-2">
        <btn @click="addComment" color="#06B6D4"> Написать сообщения </btn>
        <btn @click="closeAddCommentPanel" color="red"> Отмена </btn>
      </div>
    </div>
  </div>

  <!-- nested comments -->

  <template v-if="comment.children?.length">
    <div class="pl-5" v-for="commentChild of comment.children" :key="comment.id">
      <CommentItem :comment="commentChild" />
    </div>
  </template>
</template>

<style>
.username {
  color: blue;
}
</style>
