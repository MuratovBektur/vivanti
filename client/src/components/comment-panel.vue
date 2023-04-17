<script setup lang="ts">
import { toRefs } from 'vue'

import type { IComment } from '@/types'
import CommentItem from './comment-item.vue'

interface IProps {
  comments: IComment[]
}
const props = defineProps<IProps>()

const { comments } = toRefs(props)
</script>

<template>
  <div v-if="comments?.length">
    <CommentItem :comment="comment" v-for="comment of comments" :key="comment.id" />
  </div>
</template>
