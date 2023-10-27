<?php
/**
 * Anti-spam settings panel
 *
 * @package Qcformbuilder_Forms
 * @author    Josh Pollock <Josh@QcformbuilderWP.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2017 QcformbuilderWP LLC
 */
$element = $form = Qcformbuilder_Forms_Forms::get_form( esc_attr( $_GET[ 'edit' ] ) );
if (empty($element['antispam'])) {
    $element['antispam'] = array();
}
if (empty($element['antispam']['enable'])) {
    $element['antispam']['enable'] = '';
}
if (empty($element['antispam']['sender_email'])) {
    $element['antispam']['sender_email'] = '';
}
if (empty($element['antispam']['sender_name'])) {
    $element['antispam']['sender_name'] = '';
}
$wfb_pro_active = qcformbuilder_forms_pro_is_active();
?>
<div id="anti-spam-settings-panel">
    <h3>
        <?php esc_html_e('AntiSpam Settings', 'qcformbuilder-forms'); ?>
    </h3>

    <div class="qcformbuilder-config-group">
        <fieldset>
            <legend>
                <?php esc_html_e('Basic', 'qcformbuilder-forms'); ?>
            </legend>
            <div class="qcformbuilder-config-field">
                <input
                        id="wfb-honey"
                        type="checkbox"
                        class="field-config"
                        name="config[check_honey]"
                        value="1" <?php if (!empty($element['check_honey'])){ ?>checked="checked"<?php } ?>
                        aria-describedby="wfb-honey-desc"
                />
                <label for="wfb-honey">
                    <?php esc_html_e('Enable', 'qcformbuilder-forms'); ?>
                </label>

                <p class="description" id="wfb-honey-desc">
                    <?php esc_html_e('Uses an anti-spam honeypot', 'qcformbuilder-forms'); ?>
                </p>
            </div>
        </fieldset>
    </div>
    <div class="qcformbuilder-config-group">
        <fieldset>
            <legend>
                <?php esc_html_e('Advanced', 'qcformbuilder-forms'); ?>
            </legend>
            <div class="qcformbuilder-config-field">
                <input
                        id="wfb-pro-anti-spam"
                        type="checkbox"
                        class="field-config"
                        name="config[antispam][enable]"
                        value="1"
                        <?php if ($wfb_pro_active && !empty($element['antispam']['enable'])){ ?>checked="checked"<?php } ?>
                        <?php if (!$wfb_pro_active) { ?>disabled<?php } ?>
                />
                <label for="wfb-pro-anti-spam">
                    <?php esc_html_e('Enable'); ?>
                </label>
                <p class="description" id="wfb-pro-anti-spam-desc">
                    <?php
                    esc_html_e('Uses Chatbot Form Builder Pro for spam scan and email address blacklist check.',
                        'qcformbuilder-forms');
                    if (!$wfb_pro_active) {
                        esc_html_e('Requires Chatbot Form Builder Pro', 'qcformbuilder-forms');
                    }
                    ?>
                </p>

            </div>
        </fieldset>
    </div>

    <div class="qcformbuilder-config-group" id="qcformbuilder-anti-spam-settings-wrap">
        <div class="qcformbuilder-config-group">
            <label for="wfb-pro-anti-spam-sender-name">
                <?php echo __('Sender Name', 'qcformbuilder-forms'); ?>
            </label>
            <div class="qcformbuilder-config-field">
                <input
                        type="text"
                        id="wfb-pro-anti-spam-sender-name"
                        class=" field-config magic-tag-enabled"
                        name="config[antispam][sender_name]"
                        value="<?php echo esc_attr($element['antispam']['sender_name']); ?>"
                        aria-describedby="wfb-pro-anti-spam-sender-name-desc"
                />

                <p
                        id="wfb-pro-anti-spam-sender-name-desc"
                        class="description"
                >
                    <?php esc_html_e('Field with the form submitter\'s name.', 'qcformbuilder-forms'); ?>
                </p>
            </div>
        </div>
        <div class="qcformbuilder-config-group">
            <label for="wfb-pro-anti-spam-sender-name-email">
                <?php echo __('Email', 'qcformbuilder-forms'); ?>
            </label>
            <div class="qcformbuilder-config-field">
                <input
                        type="text"
                        id="wfb-pro-anti-spam-sender-name-email"
                        class="field-config magic-tag-enabled qcformbuilder-field-bind"
                        name="config[antispam][sender_email]"
                        value="<?php echo esc_attr($element['antispam']['sender_email']); ?>"
                        aria-describedby="wfb-pro-anti-spam-sender-name-email-desc" ,
                />
                <p
                        id="wfb-pro-anti-spam-sender-name-email-desc"

                        class="description"
                >
                    <?php esc_html_e('Field with the form submitter\'s email address', 'qcformbuilder-forms'); ?>
                </p>
            </div>
        </div>
    </div>

</div>

<script>
    jQuery(function ($) {
        var $wrap = $('#qcformbuilder-anti-spam-settings-wrap');
        var $enable = $('#wfb-pro-anti-spam');
        var $inputs = $wrap.find( 'input' );
        var hideShow = function () {
            if ($enable.prop('checked') && !$enable.prop('disabled')) {
                $wrap
                    .show()
                    .attr('aria-hidden', false);
                $inputs.prop('required', true)
                    .addClass('required');

            } else {
                $wrap
                    .hide()
                    .attr('aria-hidden', true);
                $inputs
                    .prop('required', false)
                    .removeClass('required');
            }
        };

        $enable.change(function () {
            hideShow();
        });

        hideShow();
    });
</script>




