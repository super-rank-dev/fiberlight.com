function QcformbuilderFormsAdminClippys2( elId, config, $ ){

	var self = this;



	this.init = function () {

		var vm;

		var linkCB = function(post,term){
			return post.link + '?utm-source=wp-admin&utm_campaign=clippy&utm_term=' + term;
		};

		var docsComponent = {
			template:  '#tmpl--qcformbuilder-help-clippy',
			props: [ 'important' ],
			methods: {
				link:linkCB,

			}
		};

		var extendComponent = {
			template: '#tmpl--qcformbuilder-extend-clippy',
			props: [ 'product','title' ],
			methods: {
				link:linkCB,

			}
		};


		$.when(
			get(config.cfdotcom.api.important),
			get(config.cfdotcom.api.product)
		).then(function (dImportant, dProduct) {
			var importantDocs = dImportant[0],
				products = dProduct[0],
				product = products[ pickRandomProperty(products) ],
				showExtend = 0 < Object.keys(products).length,
				showDocs = 0 < Object.keys(importantDocs).length;


			vm = new Vue({
				el: '#qcformbuilder-forms-clippy',
				components: {
					docs : docsComponent,
					extend: extendComponent
				},
				data: function () {
					return {
						importantDocs: importantDocs,
						products: products,
						product: product,
						extendTitle: config.extend_title,
					}
				},
				methods: {
					showDocs: function(){
						return showDocs;
					},
					showExtend: function(){
						return showExtend;
					}

				}
			});
		});


	};


	this.remove = function () {
		$( '#' + elId  ).remove();
	};

	function get( url ) {
		return $.get( url, {
			crossDomain: true
		} ).done( function(r){
			return r;
		}).fail( function(){
			return false;
		});
	}

	function pickRandomProperty(obj) {
		var result;
		var count = 0;
		for (var prop in obj)
			if (Math.random() < 1/++count)
				result = prop;
		return result;
	}


}

function QcformbuilderFormsAdminClippys(elId, config, $){
	return new QcformbuilderFormsAdminClippys2( elId, config, $ );
}