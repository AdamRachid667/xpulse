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
  }

]

export default routes