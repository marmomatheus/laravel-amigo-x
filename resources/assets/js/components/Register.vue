<template>
    <v-app dark>
        <v-content>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-form ref="form">
                            <v-card class="mx-auto" max-width="500">
                                <v-card-title class="title font-weight-regular justify-space-between">
                                    <span>{{ currentTitle }}</span>
                                    <v-avatar color="primary lighten-2" class="subheading white--text" size="24" v-text="step"></v-avatar>
                                </v-card-title>

                                <v-window v-model="step">
                                    <v-window-item :value="1">
                                        <v-card-text>
                                            <v-text-field label="Nome" v-model="fields.name" required :rules="[$ValidatioRules.required]"></v-text-field>                                           
                                            <v-text-field label="Email" v-model="fields.email" required :rules="[$ValidatioRules.required, $ValidatioRules.email]"></v-text-field>  
                                            <v-text-field label="Nome de Usuário" v-model="fields.username" required :rules="[$ValidatioRules.required]"></v-text-field>                                            
                                        </v-card-text>
                                    </v-window-item>

                                    <v-window-item :value="2">
                                        <v-card-text>
                                            <v-text-field label="Senha" type="password" v-model="fields.password" required :rules="[$ValidatioRules.required]"></v-text-field>
                                            <v-text-field label="Confirme sua senha" type="password" v-model="fields.password_confirmation" required :rules="[$ValidatioRules.required]"></v-text-field>                                           
                                        </v-card-text>
                                    </v-window-item>

                                    <v-window-item :value="3">
                                        <div class="pa-3 text-xs-center">                                            
                                            <h3 class="title font-weight-light mb-2">Bem Vindo!</h3>
                                            <span class="caption grey--text">Faça <a to="'/login'">login</a> para continuar</span>
                                        </div>
                                    </v-window-item>
                                </v-window>

                                <v-divider></v-divider>

                                <v-card-actions>
                                    <v-btn :disabled="step === 1 || step === 3" flat @click="step--">
                                        Voltar
                                    </v-btn>
                                    <v-spacer></v-spacer>
                                    <!-- <v-btn
                                        v-if="step === 2"
										type="submit"
										:loading="loading"
										:disabled="loading"
										color="primary"
									>
										Cadastrar
									</v-btn> -->
                                    <v-btn :disabled="step === 3 || loading" :loading="loading" color="primary" depressed @click="stepOrSend">
                                        Próximo
                                    </v-btn>
                                </v-card-actions>
                            </v-card>
                        </v-form>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-content>

        <v-snackbar :timeout="0" :absolute="false" :top="false" :color="snackbar.color" :multi-line="true" :auto-height="true"
            v-model="snackbar.show">
            <div v-html="snackbar.text"></div>
            <v-btn flat icon @click.native="snackbar.show = false">
                <v-icon>close</v-icon>
            </v-btn>
        </v-snackbar>
    </v-app>
</template>

<script>
    export default {
        data: () => ({
            step: 1,
            snackbar: {
                text: '',
                show: false,
                color: 'success'
            },
            loading: false,
            fields:
            {
                name: null,
                email: null,
                username: null,
                password: null,
                password_confirmation: null
            },
        }),

        computed: {
            currentTitle () {
                switch (this.step) {
                    case 1: return 'Seus dados'
                    case 2: return 'Cria sua senha'
                    default: return 'Conta Criada!'
                }
            }   
        },

        methods: {
            displaySnackbar(color, messages, snackbar = undefined) {
                if(snackbar == undefined) {
                    snackbar = this.snackbar;
                }

                snackbar.color = color;
                snackbar.text = messages;
                snackbar.show = true;
            },

            stepOrSend() {
                if(this.step === 1) {                    
                    this.step++
                } else {
                    if (!this.$refs.form.validate()) {
                        this.step--
                        return
                    }
                    return this.submit();    
                }

            },

            submit() {       
                this.loading = true;				
                
                axios.post(this.$utils.apiPath('register'), this.fields)
					.then(response => {	
                        this.loading = false;	
						this.step++;
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
            }
        }       
    }
    

</script>
