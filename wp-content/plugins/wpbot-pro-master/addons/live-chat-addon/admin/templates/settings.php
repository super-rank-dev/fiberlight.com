<div class="ui padded grid">
    <div class="column row">
        <div class="column">
            <div class="ui card" style="width:100%">
                <div class="content">
                    <div class="header">Live Chat setting</div>
                </div>
                <div class="content ">
                    <div class="ui stackable form">
                        <div class="two fields">
                            <div class="field">
                                <div class="ui toggle checkbox">
                                    <input type="checkbox" name="enable_livechat_salone" id="enable_livechat_salone" <?php echo (get_option('enable_livechat_salone') == 'true') ? 'checked' : '';?>>
                                    <label>Enable Stand along live chat</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui toggle checkbox">
                                    <input type="checkbox" name="enable_livechat_floating" id="enable_livechat_floating" <?php echo (get_option('enable_floating') == 'true') ? 'checked' : '';?>>
                                    <label>Enable floating button</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui stackable form">
                        <div class="two fields">
                            <div class="field">
                                <div class="ui toggle checkbox">
                                    <input type="checkbox" name="lc_right_position" id="lc_right_position" <?php echo (get_option('enable_right') == 'true') ? 'checked' : '';?>>
                                    <label>Enable Live Chat Bar Position in Right</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui toggle checkbox">
                                    <input type="checkbox" name="lc_bottom_position" id="lc_bottom_position" <?php echo (get_option('enable_bottom') == 'true') ? 'checked' : '';?>> 
                                    <label>Enable Live Chat Bar Position in Bottom</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui column grid">
                        <div class="column">
                            <h5>Override Icon's Position</h5>
                        </div>
                    </div>
                    <?php $img_url = get_option('wp_chatbot_custom_icon_path') ;?>
                    <div class="ui stackable form">
                        <div class="two fields">
                        <div class="field">
                             <div class="ui labeled input">
                                <div class="ui label">
                                   Right
                                </div>
                                <input type="number" placeholder="50px" name="position_right" id="position_right" value="<?php echo get_option('position_right'); ?>">
                            </div>
                        </div>
                        <div class="field">
                            <div class="ui labeled input">
                                <div class="ui label">
                                   Bottom
                                </div>
                                <input type="number" placeholder="50px" name="position_bottom" id="position_bottom" value="<?php echo get_option('position_bottom'); ?>">
                            </div>
                        </div>
                        </div>
                    <div>
                    <div class="ui column grid">
                        <div class="column">
                            <h5>Override Icon's Position</h5>
                        </div>
                    </div>
                    <div class="ui form">
                        <div class="equal width fields">
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="agent_icon" <?php echo  ($img_url == WBCA_URL.'images/icon/icon-0.png') ? 'checked' : ''; ?>>
                                    <label><img src="<?php echo  WBCA_URL;?>images/icon/icon-0.png"/> icon-0</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="agent_icon" <?php echo  ($img_url == WBCA_URL.'images/icon/icon-1.png') ? 'checked' : ''; ?>>
                                    <label><img src="<?php echo  WBCA_URL;?>images/icon/icon-1.png"/> icon-1</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="agent_icon" <?php echo  ($img_url == WBCA_URL.'images/icon/icon-2.png') ? 'checked' : ''; ?>>
                                    <label><img src="<?php echo  WBCA_URL;?>images/icon/icon-2.png"/> icon-2</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="agent_icon" <?php echo  ($img_url == WBCA_URL.'images/icon/icon-3.png') ? 'checked' : ''; ?>>
                                    <label> <img src="<?php echo  WBCA_URL;?>images/icon/icon-3.png"/> icon-3</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="agent_icon" <?php echo  ($img_url == WBCA_URL.'images/icon/icon-5.png') ? 'checked' : ''; ?>>
                                    <label><img src="<?php echo  WBCA_URL;?>images/icon/icon-5.png"/> icon-5</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="agent_icon" <?php echo  ($img_url == WBCA_URL.'images/icon/icon-6.png') ? 'checked' : ''; ?>>
                                    <label><img src="<?php echo  WBCA_URL;?>images/icon/icon-6.png"/> icon-6</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="agent_icon" <?php echo  ($img_url == WBCA_URL.'images/icon/icon-7.png') ? 'checked' : ''; ?>>
                                    <label><img src="<?php echo  WBCA_URL;?>images/icon/icon-7.png"/> icon-7</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="agent_icon" <?php echo  ($img_url == WBCA_URL.'images/icon/icon-8.png') ? 'checked' : ''; ?>>
                                    <label><img src="<?php echo  WBCA_URL;?>images/icon/icon-8.png"/> icon-8</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="agent_icon" <?php echo  ($img_url == WBCA_URL.'images/icon/icon-9.png') ? 'checked' : ''; ?>> 
                                    <label><img src="<?php echo  WBCA_URL;?>images/icon/icon-9.png"/> icon-9</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="agent_icon" <?php echo  ($img_url == WBCA_URL.'images/icon/icon-10.png') ? 'checked' : ''; ?>>
                                    <label><img src="<?php echo  WBCA_URL;?>images/icon/icon-10.png"/> icon-10</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="agent_icon" <?php echo  ($img_url == WBCA_URL.'images/icon/icon-11.png') ? 'checked' : ''; ?>>
                                    <label><img src="<?php echo  WBCA_URL;?>images/icon/icon-11.png"/> icon-11</label>
                                </div>
                            </div>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="agent_icon" <?php echo  ($img_url == WBCA_URL.'images/icon/icon-12.png') ? 'checked' : ''; ?> >
                                    <label><img src="<?php echo  WBCA_URL;?>images/icon/icon-12.png"/> icon-12</label>
                                </div>
                            </div>
                            <?php
                                if (get_option('wp_chatbot_custom_icon_path') != "") {
                                    $wp_chatbot_custom_icon_path = get_option('wp_chatbot_custom_icon_path');
                                } else {
                                    $wp_chatbot_custom_icon_path = WBCA_URL . 'images/icon/custom.png';
                                }
                            ?>
                            <div class="field">
                                <div class="ui radio checkbox">
                                    <input type="radio" name="agent_icon">
                                    <label><img id="wp_chatbot_custom_icon_src" src="<?php echo esc_url($wp_chatbot_custom_icon_path); ?>" style="width:65px;border-radius:50%" />Custom icon</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ui form">
                        <div class="col-xs-12">
                          <h4 class="qc-opt-title"><?php echo esc_html__(' Upload custom Icon ', 'wpchatbot'); ?></h4>
                          <div class="cxsc-settings-blocks">
                            <input type="hidden" name="wp_custom_icon_livechat"
																   id="wp_custom_icon_livechat"
																   value="<?php echo (get_option('wp_custom_icon_livechat') != '' ? get_option('wp_custom_icon_livechat') : ''); ?>" />
                            <div id="wp_custom_icon_livechat_src">
                              <?php if(get_option('wp_custom_icon_livechat')!=''): ?>
                              <img src="<?php echo get_option('wp_custom_icon_livechat'); ?>" alt="" width="50" height="50" />
                              <?php endif; ?>
                            </div>
                            <button type="button" class="wp_custom_icon_livechat button"><?php echo esc_html__('Upload Icon', 'wpchatbot'); ?> </button>
                            <?php if(get_option('wp_custom_icon_livechat')!=''): ?>
                            <button type="button" class="wp_custom_icon_livechat_remove button"><?php echo esc_html__('Remove Icon', 'wpchatbot'); ?> </button>
                            <?php endif; ?>
                          </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
                <div class="extra content">
                    <div class="ui grid">
                        <div class="column">
                            <button class="ui button teal save_lc_setting">Save settings</button>
                        </div>
                    </div>
                </div>
        </div>
        </div>
    </div>
</div>