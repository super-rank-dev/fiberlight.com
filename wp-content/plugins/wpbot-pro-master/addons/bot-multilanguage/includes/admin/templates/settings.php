<div class="wrap swpm-admin-menu-wrap">
    <h1>WPBot Multi-Language Settings</h1>

    <h2 class="nav-tab-wrapper sld_nav_container wppt_nav_container">
        <a class="nav-tab sld_click_handle nav-tab-active" href="#general_settings">General Settings</a>
        <a class="nav-tab sld_click_handle" href="#url_based_default_language">URL Based Default Language</a>
    </h2>

    <form method="post" action="options.php">
        <?php settings_fields( 'qc-wpbotml-settings-group' ); ?>
        <?php do_settings_sections( 'qc-wpbotml-settings-group' ); ?>

        <div class="wppt-settings-section" id="general_settings">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Select Languages</th>
                    <td>
                        <select multiple name="wpbotml_languages[]" id="wpbotml_languages" style="width:400px">
                            <?php 
                                $locale = get_locale();
                                $hasDefault = false;
                                $current_language = get_option( 'wpbotml_languages' );
                                foreach( qcld_wpbotml()->helper->languages() as $lancode => $landetails ){
                                    if( $locale == $lancode ){
                                        $hasDefault = true;    
                                    }
                                    echo '<option value="'.$lancode.'"  '.( is_array( $current_language ) && in_array( $lancode, $current_language ) ? 'selected="selected"' : '' ).' > '.$landetails['english_name'].' </option>';
                                }

                                if( !$hasDefault ){
                                    if( $locale == 'en_US' ){
                                        echo '<option value="'.$locale.'" selected="selected"> English (United States) </option>';
                                    }
                                } else {
                                    echo '<option value="en_US" '.( is_array( $current_language ) && in_array( 'en_US', $current_language ) ? 'selected="selected"' : '' ).' > English (United States) </option>';
                                }
                                
                            ?>
                        </select>
                        <br><br><i>After adding a new language you need to update the chatbot language settings.</i>
                        
                    </td>
                </tr>

                <tr valign="top">
                    <th scope="row">Default Language</th>
                    <td>
                        <select name="wpbotml_Default_language" id="wpbotml_Default_language" style="width:400px">
                            <?php 
                                $locale = get_locale();
                                $hasDefault = false;
                                $current_language = get_option( 'wpbotml_languages' );
                                
                                $lanlist = qcld_wpbotml()->helper->languages();
                                if( $current_language && ! empty( $current_language ) ){
                                    foreach( $current_language as $lancode ){
                                        if( $locale == $lancode ){
                                            $hasDefault = true;    
                                        }
                                        echo '<option value="'.$lancode.'" '.( get_option( 'wpbotml_Default_language' ) && get_option( 'wpbotml_Default_language' ) == $lancode ? 'selected="selected"' : '' ).' > '.($lancode=='en_US'? 'English (United States)' : $lanlist[$lancode]['english_name'] ).' </option>';
                                    }
                                }

                                if( !$hasDefault ){
                                    if( $locale == 'en_US' ){
                                        echo '<option value="'.$locale.'"> English (United States) </option>';
                                    }
                                }
                                
                            ?>
                        </select>
                        
                    </td>
                </tr>

            </table>
        </div>
        <div class="wppt-settings-section" id="url_based_default_language" style="display:none;">
            <h1>Add URLs for the Language to make it default langauge for that URLs.</h1>
            <p>You can leave this field empty if you do not want to have URL based default langauge</p>
            <hr>
            <table class="form-table">
                <?php if( $current_language && ! empty( $current_language ) ): 
                    $lanlist = qcld_wpbotml()->helper->languages(); 
                      
                ?>
                <?php foreach( $current_language as $lancode ): ?>
                
                <tr valign="top">
                    <th scope="row">Add URLs for - <?php echo ($lancode=='en_US'? 'English (United States)' : $lanlist[$lancode]['english_name']); ?></th>
                    <td>
                    <?php 
                        
                        $existing_data = ( get_option( 'wpbotml_url_urls' ) && !empty( get_option( 'wpbotml_url_urls' ) ) && is_array( get_option( 'wpbotml_url_urls' ) ) ? get_option( 'wpbotml_url_urls' ) : array() );
                        
                    ?>
                        <textarea row="30" cols="80" name="wpbotml_url_urls[<?php echo $lancode; ?>]" style="height: 200px;"><?php echo ( isset( $existing_data[$lancode] ) && $existing_data[$lancode]!=''?$existing_data[$lancode]:'' ); ?></textarea>
                        <br><br><i>The default language would be <b><?php echo ($lancode=='en_US'? 'English (United States)' : $lanlist[$lancode]['english_name']); ?></b> for the URLs you added in this field. One per line. Ex: https://example.com/en</i>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr valign="top">
                        <td>Sorry No Language Found!</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>

        <?php submit_button(); ?>
    </form>
</div>