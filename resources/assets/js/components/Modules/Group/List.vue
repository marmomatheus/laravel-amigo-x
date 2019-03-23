<template>
    <v-container fluid grid-list-md>
        <v-layout wrap row>
            <v-flex xs12 class="headline my-4 ml-2">
                <b>Grupos</b>
            </v-flex>
            <v-flex xs12>
                <v-layout align-center justify-center v-if="pageLoading">
                    <v-progress-circular indeterminate class="ma-5" :size="50" />
                </v-layout>
                <div v-else>
                    <v-toolbar flat>
                        <v-toolbar-title class="subheading">
                            Aqui estão listados os grupos que você criou ou foi inserido.
                        </v-toolbar-title>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" to='/grupos/adicionar'>
                            Criar Novo
                        </v-btn>
                    </v-toolbar>
                    <v-data-table :headers="headers" :items="groups" item-key="name" hide-actions="true">
                        <template v-slot:items="props">
                            <tr>
                                <td>{{ props.item.name }}</td>
                                <td>{{ props.item.creator.name }}</td>
                                <td>{{ props.item.participants.length }}</td>
                                <td>
                                    <v-tooltip bottom>
                                        <v-btn icon slot="activator" class="mx-0" @click="moreDetails(props.item)">
                                            <v-icon>search</v-icon>
                                        </v-btn>
                                        <span>Mais detalhes</span>
                                    </v-tooltip>
                                    <!-- <v-tooltip bottom>
                                        <v-btn icon
                                        slot="activator"
                                        class="mx-0">
                                            <v-icon>delete</v-icon>
                                        </v-btn>
                                        <span>Excluir</span>
                                    </v-tooltip> -->
                                </td>
                            </tr>
                        </template>

                    </v-data-table>
                </div>
            </v-flex>
        </v-layout>
        <v-dialog v-model="dialog" max-width="500px">
            <v-card>
                <v-card-title class="headline">
                    {{ groupName }}
                </v-card-title>
                <v-card-text>
                    <span class="subheading">
                        Criado por: {{ groupCreator }}
                    </span>
                    <v-list subheader>
                        <v-subheader>Participantes</v-subheader>
                        <v-list-tile v-for="item in groupParticipants" :key="item.name">
                            <v-list-tile-content>
                                <v-list-tile-title>{{ item.name }}</v-list-tile-title>
                            </v-list-tile-content>

                            <v-list-tile-action>
                                <v-tooltip left>
                                    <template>
                                        <v-icon slot="activator" :color="item.pivot.confirmed ? 'green' : 'red'">done</v-icon>
                                    </template>
                                    <span>{{ item.pivot.confirmed ? 'Confirmado' : 'Não Confirmado' }}</span>
                                </v-tooltip>
                            </v-list-tile-action>
                        </v-list-tile>
                    </v-list>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn @click="dialog = false">Fechar</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
    export default {

        data: () => ({
            participants: [{
                id: null,
                name: null
            }],
            dialog: false,
            loading: false,
            pageLoading: false,
            headers: [{
                    text: 'Nome',
                    value: 'name'
                },
                {
                    text: 'Criador',
                    value: 'creator_id'
                },
                {
                    text: 'Participantes',
                    value: 'participants'
                },
                {
                    text: 'Comandos',
                    value: ''
                }
            ],
            groups: [],
            groupName: null,
            groupCreator: null,
            groupParticipants: null,
        }),

        methods: {
            getGroups() {
                this.pageLoading = true;

                axios.get(this.$utils.apiPath('groups'))
                    .then(response => {
                        this.pageLoading = false;
                        this.groups = response.data
                    });
            },

            moreDetails(item) {
                this.groupName = item.name;
                this.groupCreator = item.creator.name;
                this.groupParticipants = item.participants;
                this.dialog = true;
            },

        },

        beforeMount() {
            this.getGroups()
        }
    };

</script>
