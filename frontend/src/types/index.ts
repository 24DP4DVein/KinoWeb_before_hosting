export interface Movie {
  id: number
  title: string
  year: number
  rating: number
  genres: string[]
  duration: string
  description: string
  cast: string[]
  posterGradient: string
  poster_url?: string | null
  watchlist_entries_count?: number
}

export interface User {
  id: number
  name: string
  email: string
  is_admin?: boolean
}

export type SortOption = 'rating_desc' | 'year_desc' | 'title_asc'
