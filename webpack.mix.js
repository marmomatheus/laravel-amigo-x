const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
   .stylus('resources/assets/stylus/app.styl', 'public/css')
   .options({
		// extractVueStyles: true, // Extract .vue component styling to file, rather than inline.
		vue: {
			preserveWhitespace: false
		}
	})
	.disableNotifications()
	.version()
	.webpackConfig({
		module: {
			rules: [{
				test: /\.jsx?$/,
				// exclude: /node_modules(?!\/foundation-sites)|bower_components/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: ['@babel/preset-env']
					}
				}
			}]
		}
	});
