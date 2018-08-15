import Vue from 'vue'
import Router from 'vue-router'
import mainapp from './components/mainapp.vue'
import home from './components/home.vue'
import newguest from './components/guest/newguest.vue'
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
	]
})
