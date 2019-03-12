<template>
	<v-toolbar dense app fixed clipped-left class="purple darken-4">
		<v-toolbar-side-icon @click.stop="toggleDrawer"></v-toolbar-side-icon>
		
		<v-toolbar-title class="white--text">
			Amigo X
		</v-toolbar-title>

		<v-spacer></v-spacer>

		<v-toolbar-items>
			<v-menu offset-y>
				<v-btn flat slot="activator" dark>
					<v-icon left>settings</v-icon>
					Configurações
				</v-btn>

				<v-card>
					<v-list>
						<v-list-tile @click="logout()">
							<v-list-tile-action>
								<v-icon>exit_to_app</v-icon>
							</v-list-tile-action>
							<v-list-tile-content>
								<v-list-tile-title>
									Sair
								</v-list-tile-title>
							</v-list-tile-content>
						</v-list-tile>
					</v-list>
				</v-card>
			</v-menu>
		</v-toolbar-items>
	</v-toolbar>
</template>

<script>	
	export default {
		data () {
			return {}
		},
		

		methods: {
			toggleDrawer () {
				this.$emit('toggleDrawer');
			},

			logout () {
				axios.post(this.$utils.apiPath('logout'))
					.then(response => {
						localStorage.removeItem('user', JSON.stringify(response.data.user));
						this.$router.push('/login');
				});					
			}
		}
	};
</script>