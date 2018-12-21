import VueRouter from 'vue-router'
import UserStore from '../stores/UserStore'

import HomePage from '../pages/Home.vue'
import LoginPage from '../pages/Login.vue'
import RegisterPage from '../pages/Register.vue'
import ChatPage from '../pages/Chat.vue'
import PrivateMessagesPage from '../pages/PrivateMessages.vue'

const Routes = [
	{
		path: '/',
		component: HomePage,
		name: 'home',
		meta: {
			auth: null
		}
	},
	{
		path: '/login',
		component: LoginPage,
		name: 'login',
		meta: {
			auth: false
		}
	},
	{
		path: '/register',
		component: RegisterPage,
		name: 'register',
		meta: {
			auth: false
		}
	},
	{
		path: '/chat',
		component: ChatPage,
		name: 'chat',
		meta: {
			auth: true
		}
	},
	{
		path: '/pms',
		component: PrivateMessagesPage,
		name: 'pms',
		meta: {
			auth: true
		}
	}
]

const Router = new VueRouter({
	mode: 'history',
	routes: Routes
})
Router.beforeEach((to, from, next) => {
	if (to.meta.auth == true) {
		if (UserStore.state.user.authenticated)
			next()
		else
			next({ name: 'login' })
	}
	else if (to.meta.auth == false) {
		if (!UserStore.state.user.authenticated)
			next()
		else
			next({ name: 'home' })
	}
	else
		next()
})

export default Router