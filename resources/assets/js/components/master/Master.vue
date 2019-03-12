<template>
	<v-app dark>
		<app-aside v-model="drawer">
		</app-aside>
		
		<app-top-bar @toggleDrawer="toggleDrawer" @displaySnackbar="displaySnackbar">
		</app-top-bar>

		<v-content>
			<router-view @displaySnackbar="displaySnackbar">
			</router-view>
		</v-content>
			
		<v-snackbar
			:timeout="0"
			:absolute="false"
			:top="false"
			:color="snackbar.color"
			:multi-line="true"
			:auto-height="true"
			v-model="snackbar.show"
		>
			<div v-html="snackbar.text"></div>
			<v-btn flat icon @click.native="snackbar.show = false"><v-icon>close</v-icon></v-btn>
		</v-snackbar>
	</v-app>
</template>

<script>
	import AppAside from './Aside.vue'
	import AppTopBar from './TopBar.vue'
	
	export default {
    	data: () => ({
			drawer: true,
			snackbar: {
				text: '',
				show: false,
				color: 'success'
			},
		}),
		methods: {
			displaySnackbar(color, messages, snackbar = undefined) {
				if(snackbar == undefined) {
					snackbar = this.snackbar;
				}

				let msg = '';

				try {
					if(messages.constructor === Array) {
						for (let i = 0; i < messages.length; i++) {
							if (messages[i] === Object(messages[i])) {
								msg += Object.values(messages[i]).join('<br>');
							} else {
								msg += messages[i]+'<br>';
							}
						}
					} else {
						msg = messages;
					}
				}
				catch(err) {
					msg = 'An error has occurred';
				}

				snackbar.color = color;
				snackbar.text = msg;
				snackbar.show = true;
			},
			toggleDrawer () {
				this.drawer = !this.drawer;
			}
		},
		components: {
			'app-aside': AppAside,
			'app-top-bar': AppTopBar,
		}
	};
</script>