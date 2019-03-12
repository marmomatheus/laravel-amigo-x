import Login from './../../components/Login';
import Register from './../../components/Register';
import Master from './../../components/Master/Master.vue';
import routes from './loader'

export default [
	{
		path: '/login',
		component: Login
	},
	{
		path: '/registrar',
		component: Register
	},
	{
		path: '/',
		component: Master,
		children: routes,
	}
];