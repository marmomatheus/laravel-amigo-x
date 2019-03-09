// Vue
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuetify from 'vuetify';
import ValidatioRules from './libraries/ValidatioRules';

import './config/axios.js';

// Utils
import Utils from './libraries/Utils.js';
Vue.prototype.$utils = Utils;

// Masks
import Masks from './libraries/Masks.js';
Vue.prototype.$masks = Masks;

// Routes
import routes from './config/routes/';

// Starting things up
Vue.use(Vuetify, {
	theme: {
	  primary: '#4A148C',
		secondary: '#E53935'
	}
  })
Vue.use(VueRouter);
Vue.use(ValidatioRules);

const router = new VueRouter({
	mode: 'history',
	base: Utils.basePath(),
	routes: routes
});

const app = new Vue({
    el: '#app',
    router: router
});