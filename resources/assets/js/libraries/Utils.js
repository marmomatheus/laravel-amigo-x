class Utils {
	constructor() {
		// Gets the base path in the html
		this._basePath = document.head.querySelector('meta[name="base-path"]').content;
	}

	/**
     * Gets the base path of the application
     *
     * @param  {string} url
     * @return {string}
     */
	basePath(url = '') {
		return this._basePath + url;
	}

	/**
     * Gets the image path of the application
     *
     * @param  {string} url
     * @return {string}
     */
	imgPath(url = '') {
		return this.basePath('img/' + url);
	}

	/**
     * Gets the api path of the application
     *
     * @param  {string} url
     * @return {string}
     */
	apiPath(url = '') {
		return this.basePath('api/' + url);
	}

	/**
     * Transforms an object in a URLSearchParams
     *
     * @param  {object} params
     * @return {URLSearchParams}
     */
	setUrlParams(params) {
		let searchParams = new URLSearchParams();
		
		Object.keys(params).forEach(function(key) {
			if(Array.isArray(params[key])) {
				params[key].forEach(function(value) {
					searchParams.append(key+'[]', value);
				})
			} else {
				searchParams.append(key, params[key]);
			}
		});

		return searchParams;
	}

	/**
     * Try to get messages from response, otherwise return the defaultMessage
     *
     * @param  {mixed} response
     * @param  {string} defaultMessage
     * @return {array} or {string}
     */
	getResponseErrors(response, defaultMessage) {
		if (typeof response === 'object' && response.data.messages != undefined) {
			return response.data.messages;
		} else {
			return defaultMessage;
		}
	}

	/**
     * Recive an array and transform it in an object to be placed as properties in a component
     *
     * @param  {array} sizes
     * @return {array of objects}
     */
	formatSizes (sizes) {
		if(!sizes) {
			return [];
		}

		return sizes.split(' ').map(function(size) {
			return {[size]: true};
		});
	}

	/**
     * Recive an date string and transform it to the brazilian format
     *
     * @param  {string} date
     * @return {string}
     */
	formatDate (date) {
		// Por alguma razão essas linhas comentadas retornam a data de um dia antes...
		// date = new Date(date);
		// return date.toLocaleString("pt-BR");

		if (!date) {
			return null;
		}

		date = date.split(' ');
		
		let [year, month, day] = date[0].split('-');

        date[0] = `${day}/${month}/${year}`;
		return date.join(' ');
	}

	formatDateWithoutMask (date) {

		if (!date) {
			return null;
		}

		date = date.split(' ');
		
		let [year, month, day] = date[0].split('-');

        date[0] = `${day}/${month}/${year}`;
		return date.join(' ');
	}

	can (moduleId, __action) {
		let actions = JSON.parse(localStorage.getItem('actions')),
			action = actions.find((_action) => {
				return _action.module_id == moduleId;
			});

		return action[__action];
	}
}

module.exports = new Utils;