import Vue from 'vue'
import Router from 'vue-router'
import mainapp from './components/mainapp.vue'
import home from './components/home.vue'
import newcustomer from './components/customer/newcustomer.vue'
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
			path: '/newcustomer',
			name: 'newcustomer',
			component: newcustomer
		},
	]
})
