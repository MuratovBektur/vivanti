export interface IComment {
  id: number
  post_id: number
  parent_id: number | null
  user: IUser
  content: string
  is_it_reply_to_comment: boolean
  like_count: number
  created_at: Date
  updated_at: Date
  comments_likes: ICommentsLikes[]
  children: IComment[]
}

export interface ICommentsLikes {
  user_id: number
  comment_id: number
}

export interface IPost {
  id: number
  title: string
  content: string
  created_at: Date
  updated_at: Date
  comments: IComment[]
}

export interface IUser {
  id: number
  fullname: string
  email: string
  email_verified_at: Date | null
  created_at: Date
  updated_at: Date
}
