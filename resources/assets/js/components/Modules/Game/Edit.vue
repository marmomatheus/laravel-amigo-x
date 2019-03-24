<template>
    <v-container fluid grid-list-md>
        <v-layout wrap row>
            <v-flex xs12 class="headline my-4 ml-2">
                <b>Sorteios - adicionar</b>
            </v-flex>
            <v-flex xs12>
                <v-layout align-center justify-center v-if="pageLoading">
                    <v-progress-circular indeterminate class="ma-5" :size="50" />
                </v-layout>
                <v-card class="pa-3" v-else>
                    <v-form @submit="submit" ref="form">
                        <v-card-text>
                            <v-layout row wrap>
                                <v-flex xs12 lg8>
                                    <v-text-field label="Nome" v-model="fields.name" required :rules="[$ValidatioRules.required]" :disabled="loading"></v-text-field>
                                </v-flex>
                                <v-flex xs12 lg4>
									<v-menu
										:close-on-content-click="false"
										v-model="exchangeDatePicker"
										:nudge-right="40"
										lazy
										transition="scale-transition"
										offset-y
										full-width
										max-width="290px"
										min-width="290px"
									>
										<v-text-field
											slot="activator"
											v-model="fields.exchange_date"
											label="Data da Entrega dos Presentes"
											required 
                                            :rules="[$ValidatioRules.required]" 
                                            :disabled="loading"
										></v-text-field>

										<v-date-picker v-model="exchangeDate" no-title @input="exchangeDatePicker = false"></v-date-picker>
									</v-menu>
								</v-flex>
                                <v-flex xs12 lg12>
                                     <v-autocomplete
                                        v-model="fields.group_id"
                                        :items="groups"
                                        label="Grupo (Apenas os usuários confirmados serão incluidos no sorteio)"                                        
                                        required
                                        :rules="[$ValidatioRules.required]" 
                                        item-value="id"
										item-text="name"
                                    ></v-autocomplete>
                                </v-flex>                                
                            </v-layout>                            
                        </v-card-text>                           
                       <v-card-actions>
                            <v-spacer></v-spacer>                          
                            <v-btn
                                type="submit"
                                :loading="loading"
                                :disabled="loading || submited"
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
    import Utils from './../../../libraries/Utils.js'

    export default {

        data: () => ({
            snackbar: {
                show: false,
                color: null,
                text: null
            },
            fields: {
                name: null,
                group_id: null,  
                exchange_date: null,             
            },           
            groups: [],
            loading: false,
            pageLoading: false,
            submited: false,

            exchangeDate: null,
			exchangeDatePicker: false,
        }),

        watch: {
			exchangeDate (val) {
				this.fields.exchange_date = this.$utils.formatDate(this.exchangeDate);
			},
		},

        methods: {
             getGroups() {
                this.pageLoading = true;                            
              
                let query = '?' + Utils.setUrlParams({selfOnly: true}).toString();

                axios.get(this.$utils.apiPath('groups'+query))
                    .then(response => {   
                        this.pageLoading = false;                 
                        this.groups = response.data
                    });
            },
           
            submit(e) {
                e.preventDefault();

                if (!this.$refs.form.validate()) {
                    return
                }

                this.loading = true;


                axios.post(this.$utils.apiPath('games'), this.fields)
                    .then(response => {	
                        this.loading = false;
                        this.submited = true;
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
            this.getGroups()
        }
    };

</script>
