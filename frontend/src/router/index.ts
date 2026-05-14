import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import WatchlistView from '@/views/WatchlistView.vue'
import TopRatedView from '@/views/TopRatedView.vue'
import AdminView from '@/views/AdminView.vue'

const router = createRouter({
  history: createWebHistory(),
  routes: [
    { path: '/',           component: HomeView },
    { path: '/top-rated',  component: TopRatedView },
    {
      path: '/watchlist',
      component: WatchlistView,
      beforeEnter: () => {
        const token = localStorage.getItem('token')
        if (!token) return '/'
      },
    },
    {
      path: '/admin',
      component: AdminView,
      beforeEnter: () => {
        const raw = localStorage.getItem('user')
        if (!raw) return '/'
        if (!JSON.parse(raw).is_admin) return '/'
      },
    },
  ],
})

export default router
