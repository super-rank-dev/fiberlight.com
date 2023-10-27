<div class="wrap swpm-admin-menu-wrap">
    <h1>Bot - WhatsApp Settings</h1>

    <h2 class="nav-tab-wrapper sld_nav_container wppt_nav_container">
        <a class="nav-tab sld_click_handle nav-tab-active" href="#general_settings">General Settings</a>
        <!--<a class="nav-tab sld_click_handle" href="#url_based_default_language">URL Based Default Language</a>-->
    </h2>
    <p>You can follow this tutorial to setup the twilio account for WhatsApp Chatbot Addon. <a href="https://dev.quantumcloud.com/wpbot-pro-demo/setting-up-whatsapp-chatbot-addon/" target="_blank">Click Here</a></p>
    <form method="post" action="options.php">
        <?php settings_fields( 'qc-wpbotwa-settings-group' ); ?>
        <?php do_settings_sections( 'qc-wpbotwa-settings-group' ); ?>
        <div class="wppt-settings-section" id="general_settings">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Twilio Account SID</th>
                    <td>
                        <input style="width:400px" type="text" name="wa_account_sid" id="wa_account_sid" value="<?php echo get_option( 'wa_account_sid' ); ?>" /><br>
                        <i> Please provide twilio Account SID. You can get it from <a href="https://www.twilio.com/whatsapp" target="_blank">here</a></i>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Twilio Auth Token</th>
                    <td>
                        <input style="width:400px" type="text" name="wa_auth_token" id="wa_auth_token" value="<?php echo get_option( 'wa_auth_token' ); ?>" /><br>
                        <i> Please provide twilio Auth Token. <a href="https://www.twilio.com/whatsapp" target="_blank">here</a></i>

                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Twilio WhatsApp Number</th>
                    <td>
                        <input style="width:400px" type="text" name="wa_whatsapp_number" id="wa_whatsapp_number" value="<?php echo get_option( 'wa_whatsapp_number' ); ?>" /><br>
                        <i> Please provide twilio whatsApp number. EX: +14155238886</i>
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Webhook URL</th>
                    <td>
                        <input style="width:400px" type="text" disabled name="wa_webhook_url" id="wa_webhook_url" value="<?php echo home_url().'/wp-json/wpbot/v2/whatsapp'; ?>" /><br>
                        <i>Copy the webhook URL and paste it to the twilio configurations</i>
                    </td>
                </tr>


                <tr valign="top">
                    <th scope="row">Disable Start Menu</th>
                    <td>
                        <input type="checkbox" name="wa_disable_start_menu" value="1" <?php echo ( get_option( 'wa_disable_start_menu' ) == '1' ? 'checked="checked"' : '' ); ?> />
                        <i>Language menu item will remain if multilanguage addon installed.</i>
                    </td>
                </tr>

                

            </table>
        </div>

        <?php submit_button(); ?>
    </form>

</div>