const routes = [

  {
    path: '/',
    component: () => import('pages/IndexPage.vue')
  },

  {
    path: '/login',
    component: () => import('pages/LoginPage.vue')
  },

  {
    path: '/register',
    component: () => import('pages/RegisterPage.vue')
  },

  {
    path: '/create',
    component: () => import('pages/CreatePostPage.vue')
  },

  {
    path: '/profile/:id',
    component: () => import('pages/ProfilePage.vue')
  }

]

export default routes
