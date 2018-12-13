import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'
import EventList from './views/EventList.vue'
import About from './views/About.vue'
import Ranking from './views/Ranking.vue'
import Inquiry from './views/Inquiry.vue'

Vue.use(Router)

export default new Router({
  mode: 'history',
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/eventlist',
      name: 'eventlist',
      component: EventList
    },
    {
      path: '/ranking',
      name: 'ranking',
      component: Ranking
    },
    {
      path: '/inquiry',
      name: 'inquiry',
      component: Inquiry
    },
    {
      path: '/about',
      name: 'about',
      component: About
    }
  ]
})
