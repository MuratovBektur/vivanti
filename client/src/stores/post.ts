import { defineStore } from 'pinia'

import type { IPost } from '@/types'
import api from '@/libs/api'

interface IState {
  post: IPost | null
  user_id: number
}
interface IAddComment {
  content: string
  post_id: number
  parent_id: number | null
  is_it_reply_to_comment: boolean
}

export const usePostStore = defineStore('post', {
  state: (): IState => ({
    post: null,
    user_id: 11
  }),
  actions: {
    async fetchPost(id: number) {
      const { data } = await api.get<IPost>(`post/${id}/${this.user_id}`)
      this.post = data
    },
    addComment(comment: IAddComment) {
      return api.post('comment/add', {
        ...comment,
        user_id: this.user_id
      })
    }
  }
})
