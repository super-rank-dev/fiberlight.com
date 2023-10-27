<?php

/**
 * Handling actions
 * @since 0.0.9
 * @package WPBot Pro
 */
class WPBot_Telegram_Actions {
    
    public function __construct(){

        add_action( 'ml_render_start_menu_tg', array( $this, 'start_menu' ) );
    }

    /**
     * Render start menu
     *
     * @return void
     */
    public function start_menu() {
        
        $languages = qcld_wpbotml()->languages;
        ?>
        <div class="qcld_multilan_manu_area" style="margin-top:20px" >
            <label for="qcld_wpbot_start_lan_select"> <?php echo __( 'Change Langauges', 'wpbot' ); ?> </label>
            <select class="qcld_wpbot_start_lan_select" id="qcld_wpbot_start_lan_select">
                <?php 
                    foreach( $languages as $language ){
                        echo '<option value="'.$language.'">'.qcld_wpbotml()->lanName( $language ).'</option>';
                    }
                ?>
            </select>
        <?php
        $cnt = 0;
        foreach( $languages as $language ) {
            $cnt++;
        ?>
            <div class="qcld_wpbot_startmenu_area qcld_startarea_<?php echo $language ?>" <?php echo ( ( $cnt != 1 )?'style="display:none;width: 900px;"':'style="width: 900px;"' ); ?>>
                <?php 
                    $menu_order = maybe_unserialize( get_option('qc_wpbot_tg_menu_order') );
                    if( $menu_order && isset( $menu_order[$language] )){
                        $menu_order = $menu_order[$language];
                    }else{
                        $menu_order = $menu_order[get_locale()];
                    }
                ?>
                <h2>Menu Sorting & Customization Area - <?php echo qcld_wpbotml()->lanName( $language ); ?></h2>
                <p style="color:red">*After making changes in the settings, please clear browser cache and cookies before reloading the page or open a new Incognito window (Ctrl+Shit+N in chrome).</p>
                <p>In this section you can control the UI of the menu.<br>
To adjust the Active Menu ordering just drag it up or down. To add a menu item in Active Menu simply drag a menu item from Available Menu and drop it to Active Menu . To remove a menu item from Active Menu simple drag the menu item and drop it to Available Menu.</p>

                <p style="color:red">* After making any changes to buttons label, You must have to remove the button from "Menu Area" and add it back from "Menu list".</p>
                <div class="qc_menu_setup_area">

                    <div class="qc_menu_area">
                        <h3>Active menu</h3>
                        
                        <div class="qc_menu_area_container qc_menu_area_sort" id="qc_menu_area">

                            <?php echo stripslashes($menu_order); ?>

                        </div>
                    </div>

                    <div class="qc_menu_list_area" >
                        <h3>Available Menu items</h3>
                        
                        <div class="qc_menu_list_container">
                            <p>Predefined Intents</p>
                        
                            <?php qcld_wpbot()->helper->render_start_menu($language); ?>

                        </div>

                    </div>

                </div>
                
                <input class="qc_wpbot_menu_order" type="hidden" name="qc_wpbot_tg_menu_order[<?php echo $language; ?>]" value='<?php echo stripslashes($menu_order); ?>' />
            </div>
        <?php
        }
        ?>
        </div>
        <?php
    }
}

new WPBot_Telegram_Actions();