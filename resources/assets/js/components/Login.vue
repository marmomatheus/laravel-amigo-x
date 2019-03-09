<template>
	<v-app dark>
		<v-content>
			<v-container fluid fill-height>
				<v-layout align-center justify-center>
					<v-flex xs12 sm8 md4>
						<v-form
							@submit="submit"
							ref="form"
						>
							<v-card class="elevation-12">
								<v-toolbar class="login-container">
									<v-toolbar-title>
										Amigo X
									</v-toolbar-title>
								</v-toolbar>
								<v-card-text>
									<v-text-field
										prepend-icon="person"
										name="email"
										label="E-mail"
										type="email"
										color="black"
										:rules="[$ValidatioRules.required,$ValidatioRules.email]"
										:disabled="loading"
										required
										v-model="fields.email"
									></v-text-field>
									<v-text-field
										prepend-icon="lock"
										name="password"
										label="Senha"
										type="password"
										color="black"
										:rules="[$ValidatioRules.required]"
										:disabled="loading"
										required
										v-model="fields.password"
									></v-text-field>
								</v-card-text>
								
								<v-card-actions>
									<v-spacer></v-spacer>
									<v-btn
										type="submit"
										:loading="loading"
										:disabled="loading"
										color="primary"
										:to="'registrar'"
									>
										Registrar - se
										<v-icon right>arrow_right_alt</v-icon>
									</v-btn>
									<v-btn
										type="submit"
										:loading="loading"
										:disabled="loading"
										color="primary"
									>
										Login
										<v-icon right>send</v-icon>
									</v-btn>
								</v-card-actions>
							</v-card>
						</v-form>
					</v-flex>
				</v-layout>
			</v-container>
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
	export default {
    	data: () => ({
    		fields: {
				email: '',
				password: '',
    		},
    		snackbar: {
    			text: '',
    			show: false,
    			color: 'success'
    		},
			loading: false,
		}),
		methods: {
			displaySnackbar(color, messages, snackbar = undefined) {
				if(snackbar == undefined) {
					snackbar = this.snackbar;
				}

				snackbar.color = color;
				snackbar.text = messages;
				snackbar.show = true;
			},
			
			submit(e) {
				e.preventDefault();

				if (!this.$refs.form.validate()) {
					return
				}

				this.loading = true;

				axios.post(this.$utils.apiPath('login'), this.fields)
				.then(response => {	
					this.loading = false;	
					this.$router.push('/');
				})
				.catch(error => {
					this.loading = false;

					if(error.response.data.error != undefined) {
						return this.displaySnackbar('error', error.response.data.error);
					}
											
					let msg = '';
					for (let key in error.response.data.errors) {
						msg += '<br>' + error.response.data.errors[key].join('<br>');
					}
					this.displaySnackbar('error', msg);						
				});		

			},
		}
	};
</script>