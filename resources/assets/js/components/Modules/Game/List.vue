<template>
    <v-container fluid grid-list-md>
        <v-layout wrap row>
            <v-flex xs12 class="headline my-4 ml-2">
                <b>Sorteios</b>
            </v-flex>
            <v-flex xs12>
                <v-layout align-center justify-center v-if="pageLoading">
                    <v-progress-circular indeterminate class="ma-5" :size="50" />
                </v-layout>
                <div v-else>
                    <v-toolbar flat>
                        <v-toolbar-title class="subheading">
                            Aqui estão listados os sorteios que você está participando.
                        </v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" to='/sorteios/adicionar'>
                            Criar Novo
                        </v-btn>
                    </v-toolbar>
                    <v-data-table :headers="headers" :items="games" item-key="name" hide-actions="true">
                        <template v-slot:items="props">
                            <tr>
                                <td>{{ props.item.name }}</td>
                                <td>{{ props.item.group.name }}</td>
                                <td>{{ props.item.exchange_date }}</td>                               
                            </tr>
                        </template>

                    </v-data-table>
                </div>
            </v-flex>
        </v-layout>       
    </v-container>
</template>

<script>
    export default {

        data: () => ({
            loading: false,
            pageLoading: false,
            headers: [{
                    text: 'Nome',
                    value: 'name'
                },
                {
                    text: 'Grupo',
                    value: 'group_id'
                },
                {
                    text: 'Data da Troca de Presentes',
                    value: 'exchange_date'
                }
            ],
            games: [],
        }),

        methods: {
            getGroups() {
                this.pageLoading = true;

                axios.get(this.$utils.apiPath('games'))
                    .then(response => {
                        this.pageLoading = false;
                        this.games = response.data
                    });
            },
        },

        beforeMount() {
            this.getGroups()
        }
    };

</script>
