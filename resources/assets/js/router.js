import Vue from 'vue'
import Router from 'vue-router'
import mainapp from './components/mainapp.vue'
import home from './components/home.vue'
import newguest from './components/guest/newguest.vue'
import newbooking from './components/booking/newbooking.vue'
import room from './components/room/room.vue'
Vue.use(Router)
export default new Router({
	  mode: 'history',
	  routes:
	  [
        {
	      path: '/mainapp',
	      name: 'mainapp',
	      component: mainapp
		},
		{
			path: '/home',
			name: 'home',
			component: home
		},
		{
			path: '/newguest',
			name: 'newguest',
			component: newguest
		},
		{
			path: '/newbooking',
			name: 'newbooking',
			component: newbooking
		},
		{
			path: '/room',
			name: 'room',
			component: room
		},
	]
})
