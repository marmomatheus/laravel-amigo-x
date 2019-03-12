<template>		
	<v-container fluid grid-list-md>
		<v-layout wrap row>
			<v-flex xs12 class="headline my-4 ml-2">
				<b>Olá, {{ username }}</b><br>
				<span class="subheading">Aqui aparecerão os ultimos sorteios que você está participando.</span>
			</v-flex>
		</v-layout>
	</v-container>
</template>

<script>
	export default {
    	data: () => ({
    		username: null
		}),
		methods: {
			setName() {
				let user = JSON.parse(localStorage.getItem('user'));
				this.username = user.username;
			},		
		},

		beforeMount() {			
            this.setName()
        }
	};
</script>