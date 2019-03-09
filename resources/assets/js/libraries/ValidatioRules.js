class ValidatioRules {
	constructor() {
		// Alguma coisa deve ser digitada
		this.required = v => !!v || 'Esse campo é obrigatório';
		// E-mail válido
		this.email = v => /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/.test(v) || 'Email inválido';
		
	}

	
}

// export default (new ValidatioRules);

export default {
	install: function(Vue,) {
		Object.defineProperty(Vue.prototype, '$ValidatioRules', {
			value: new ValidatioRules
		});
	}
}