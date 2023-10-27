<?php

?>

<script type="text/html" id="tmpl--qcformbuilder-help-clippy">
	<div class="qcformbuilder-forms-clippy-zone" style="background-image: url( '<?php echo esc_url( WFBCORE_URL . 'assets/images/qcformbuilder-globe-logo-sm.png' ); ?>' );">
		<div class="qcformbuilder-forms-clippy-zone-inner-wrap">
			<div class="qcformbuilder-forms-clippy">
				<h2><?php esc_html_e( 'Documentation', 'qcformbuilder-forms' ); ?></h2>
				<div>
					<ul v-for="result in important">
						<li>
							<a v-bind:href="link( result, 'docs' )" target="_blank">
								<span v-html="result.title"></span>
							</a>
						</li>
					</ul>
				</div>
				<a href="https://quantumcloud.com/documentation/qcformbuilder-forms-documentation?utm-source=wp-admin&utm_campaign=clippy&utm_term=docs" target="_blank" class="bt-btn btn btn-green">
					<?php esc_html_e( 'All Documentation', 'qcformbuilder-forms' ); ?>
				</a>
			</div>
		</div>
	</div>
</script>


<script type="text/html" id="tmpl--qcformbuilder-extend-clippy">
	<div class="qcformbuilder-forms-clippy-zone" style="background-image: url( '<?php echo esc_url( WFBCORE_URL . 'assets/images/qcformbuilder-globe-logo-sm.png' ); ?>' );">
		<div class="qcformbuilder-forms-clippy-zone-inner-wrap">

			<div class="qcformbuilder-forms-clippy" >
				<h2>{{title}}</h2>
				<h4 v-if="product.name != 'Chatbot Form Builder Pro'">{{product.name}}</h4>
				<p v-html="product.excerpt"></p>
				<a v-bind:href="link( product, 'extend' )" target="_blank" class="bt-btn btn btn-orange">
					<?php esc_html_e( 'Learn More', 'qcformbuilder-forms' ); ?>
				</a>
			</div>

		</div>
	</div>

</script>
