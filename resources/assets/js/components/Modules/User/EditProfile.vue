<template>
    <v-container fluid grid-list-md>
        <v-layout wrap row>
            <v-flex xs12 class="headline my-4 ml-2">
                <b>Editar seus dados</b>
            </v-flex>
            <v-flex xs12>
                <v-layout align-center justify-center v-if="pageLoading">
                    <v-progress-circular indeterminate class="ma-5" :size="50" />
                </v-layout>
                <v-card class="pa-3" v-else>
                    <v-form @submit="submit" ref="form">
                        <v-card-text>
                            <v-layout row wrap>
                                <v-flex xs12 lg4>
                                    <v-text-field label="Nome" v-model="fields.name" required :rules="[$ValidatioRules.required]" :disabled="loading"></v-text-field>
                                </v-flex>
                                <v-flex xs12 lg4>
                                    <v-text-field label="E-mail" v-model="fields.email" type="email" required :rules="[$ValidatioRules.required,$ValidatioRules.email]" :disabled="loading"></v-text-field>
                                </v-flex>
                                 <v-flex xs12 lg4>
                                    <v-text-field v-model="fields.username" required :rules="[$ValidatioRules.required]" :disabled="loading"></v-text-field>
                                </v-flex>
                                <v-flex xs12 lg6>
                                    <v-text-field label="Senha" v-model="fields.password" type="password" :disabled="loading"></v-text-field>
                                </v-flex>
                                <v-flex xs12 lg6>
                                    <v-text-field label="Confirmar senha" v-model="fields.password_confirmation" type="password" :disabled="loading"></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                        <v-flex xs12>
									<v-card>
										<v-toolbar dense class="elevation-0">
											<v-toolbar-title>
												Presentes Desejados
											</v-toolbar-title>
											
											<v-spacer></v-spacer>
											 
											<v-tooltip bottom v-if="!loading">
												<v-btn icon slot="activator" @click="addGift">
													<v-icon>add</v-icon>
												</v-btn>
												
												<span>Adicionar Presente</span>
											</v-tooltip>
										</v-toolbar>

										<v-card-text>
											<v-layout row wrap>
												<v-flex xs12 lg6 v-for="(gift, i) in fields.gifts" :key="i">
													<v-layout row wrap>
														<v-flex xs12 lg10>
															<v-text-field
																label="Nome"
																:rules="[$ValidatioRules.required]"
																:disabled="loading"
																v-model="fields.gifts[i].name"
															></v-text-field>
                                                        </v-flex>
                                                        <v-flex xs12 lg2>
                                                            <v-tooltip
                                                                slot="append-outer"
                                                                bottom
                                                            >
                                                                <v-btn icon slot="activator" @click="removeGift(i)">
                                                                    <v-icon>delete</v-icon>
                                                                </v-btn>
                                                                Remover Presente
                                                            </v-tooltip>
														</v-flex>
													</v-layout>
												</v-flex>
											</v-layout>
										</v-card-text>
									</v-card>
								</v-flex>

                        
                       <v-card-actions>
                            <v-spacer></v-spacer>                          
                            <v-btn
                                type="submit"
                                :loading="loading"
                                :disabled="loading"
                                color="primary"
                            >
                                Salvar
                                <v-icon right>send</v-icon>
                            </v-btn>
                        </v-card-actions>                        
                    </v-form>
                </v-card>
            </v-flex>
        </v-layout>

        <v-snackbar :timeout="0" :absolute="false" :top="false" :color="snackbar.color" :multi-line="true" :auto-height="true"
            v-model="snackbar.show">
            <div v-html="snackbar.text"></div>
            <v-btn flat icon @click.native="snackbar.show = false">
                <v-icon>close</v-icon>
            </v-btn>
        </v-snackbar>
    </v-container>
</template>

<script>
    export default {

        data: () => ({
            snackbar: {
                show: false,
                color: null,
                text: null
            },
            fields: {
                name: null,
                email: null,
                username: null,
                password: null,
                password_confirmation: null,
                gifts: [{
                    name: null
                }],
            },
            loading: false,
            pageLoading: false,
        }),

        methods: {
            getProfiles() {
                this.pageLoading = true;
                let user = JSON.parse(localStorage.getItem('user'));

                axios.get('api/users/' + user.id)
                    .then(response => {
                        this.pageLoading = false;
                        this.fields.name = response.data.name;
                        this.fields.username = response.data.username;
                        this.fields.email = response.data.email;

                        this.fields.gifts = response.data.gifts;

                        if (this.fields.gifts.length == 0 || this.fields.gifts == null) {
                            this.fields.gifts = [{
                                name: null,
                                email: null,
                            }];
				        } 
                    });

            },

            addGift () {
				this.fields.gifts.push({
					name: null,
					phone: null,
				});
			},

			removeGift (toRemove) {
				this.fields.gifts = this.fields.gifts.filter((item, i) => {
					return i != toRemove;
				});
			},

            submit(e) {
                e.preventDefault();

                if (!this.$refs.form.validate()) {
                    return
                }

                this.loading = true;
                let user = JSON.parse(localStorage.getItem('user'));

                axios.put(this.$utils.apiPath('users/' + user.id), this.fields)
                    .then(response => {	
                        this.loading = false;	
                        localStorage.setItem('user', JSON.stringify(response.data.user));
                        this.displaySnackbar('success', response.data.message);
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

            displaySnackbar(color, messages, snackbar = undefined) {
                if(snackbar == undefined) {
                    snackbar = this.snackbar;
                }

                snackbar.color = color;
                snackbar.text = messages;
                snackbar.show = true;
            },
        },


        beforeMount() {
            this.getProfiles()
        }
    };

</script>
