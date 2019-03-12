<template>
	<v-navigation-drawer clipped fixed v-model="model" app class="black" @input="updateModel">
		<v-list dense class="black" expand>
			<template v-for="(module, i) in modules">
				<v-list-group v-if="module.modules" :prepend-icon="module.icon">
					<v-list-tile slot="activator" ripple>
						<v-list-tile-content>
							<v-list-tile-title>{{ module.name }}</v-list-tile-title>
						</v-list-tile-content>
	            	</v-list-tile>
					<v-list-tile v-for="(module, i2) in module.modules" :to="'/'+module.slug" :key="i2" ripple>
						<v-list-tile-action>
							<v-icon>{{ module.icon }}</v-icon>
						</v-list-tile-action>
						<v-list-tile-content>
							<v-list-tile-title>{{ module.name }}</v-list-tile-title>
						</v-list-tile-content>
					</v-list-tile>
				</v-list-group>

				<v-list-tile v-else :to="'/'+module.slug" ripple>
					<v-list-tile-action>
						<v-icon>{{ module.icon }}</v-icon>
					</v-list-tile-action>
					<v-list-tile-content>
						<v-list-tile-title>{{ module.name }}</v-list-tile-title>
					</v-list-tile-content>
				</v-list-tile>
				<v-divider
					:key="i"
				></v-divider>
			</template>
		</v-list>
	</v-navigation-drawer>
</template>

<script>
	import Modules from './../../config/modules.js';

	export default {
		data () {
			return {
				modules: Modules,
				model: null,
			}
		},
		watch: {
			value: {
				handler () {
					this.model = this.value;
				},
			}
		},
		mounted () {
			switch (this.$vuetify.breakpoint.name) {
				case 'xs':
				case 'sm':
				case 'md':
					this.model = false;
					this.$emit('input', false);
				break;
				case 'lg':
				case 'xl':
					this.model = this.value;
				break;
			}
		},
		props: [
			'value'
		],
		methods: {
			updateModel (newValue) {
				this.model = newValue;
				this.$emit('input', newValue);
			}
		}
	};
</script>