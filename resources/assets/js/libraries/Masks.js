class Masks {
	constructor() {
		this.cpf = '###.###.###-##';
		this.cnpj = '##.###.###/####-##';
		this.phone = '(##) #####-####';
		this.date = '##/##/####';
		this.hour = '##:##';
		this.ddd = '##';
		this.prefix = '+###';
		this.cep = '#####-###';		
	}
}

module.exports = new Masks;