/** globals Vue **/

Vue.component( 'wfb-status-indicator', {
	template: '<div class="wfb-alert-wrap wfb-hide"><p class="wfb-alert wfb-alert-success" v-if="show && success">{{message}}</p><p class="wfb-alert wfb-alert-warning" v-if="show && ! success">{{message}}</p></div>',
	props: [
		'success',
		'message',
		'show'
	],
	watch : {
		show: function () {
			if( this.show ){
				this.$el.className = "wfb-alert-wrap wfb-show";
			}else{
				this.$el.className = "wfb-alert-wrap wfb-hide";
			}
		}
	}
});

