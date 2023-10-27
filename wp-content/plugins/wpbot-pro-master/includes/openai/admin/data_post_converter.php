
    <div class="row">
        <div  class="col-md-12">
            <div class="alert alert-danger my-4">
                <?php esc_html_e('This feature is still experimental and development is ongoing because of the difficulties in cleaning up the multitudes of tags added by page builders'); ?>
            </div>
            <form class="file_form my-4">
                <div id="wp-chatbot-post-converter">
                    <ul class="checkbox-list">
                        <?php
                            $get_cpt_args = array(
                                'public'   => true,
                            );
                            $post_types = get_post_types( $get_cpt_args, 'object' );
                            foreach ($post_types as $post_type) {
                                if($post_type->name != "attachment"){
                        ?>
                        <div class="form-check form-check-inline">
                        <input
                                id="wp_chatbot_data_converter_<?php echo $post_type->name; ?>"
                                type="checkbox"
                                name="wp_chatbot_data_converter_list[]"
                                value="<?php echo $post_type->name; ?>" >
                        <label  class="form-check-label" for="wp_chatbot_data_converter_<?php echo $post_type->name; ?>"> <?php echo $post_type->name; ?></label>
                        </div>
                    <?php
                                }
                        } 
                     ?>
                    </ul>
                </div>
                <a class="btn btn-default qcld_convert_data"><?php esc_html_e('Convert Data'); ?></a>
            </form> 
            <h3><?php esc_html_e('Conversions Files'); ?></h3>
            <?php 
            global $wpdb;
                $qcld_openai_files_page = isset($_GET['wpage']) && !empty($_GET['wpage']) ? sanitize_text_field($_GET['wpage']) : 1;
                $qcld_openai_files_per_page = 20;
                $qcld_openai_files_offset = ( $qcld_openai_files_page * $qcld_openai_files_per_page ) - $qcld_openai_files_per_page;
                $qcld_openai_files_count_sql = "SELECT COUNT(*) FROM ".$wpdb->posts." f WHERE f.post_type='qcldopenai_convert' AND f.post_status='publish'";
                $qcld_openai_files_sql = "SELECT f.* FROM ".$wpdb->posts." f WHERE f.post_type='qcldopenai_convert' AND f.post_status='publish' ORDER BY f.post_date DESC LIMIT ".$qcld_openai_files_offset.",".$qcld_openai_files_per_page;
                $qcld_openai_files = $wpdb->get_results($qcld_openai_files_sql);
                
                $qcld_openai_files_total = $wpdb->get_var( $qcld_openai_files_count_sql );
                      
                    ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered qcld_convert_datatable">
                    <thead><tr><td><?php esc_html_e( 'Filename','openai_addon');?></td><td><?php esc_html_e( 'Date of creation','openai_addon');?></td><td><?php esc_html_e( 'Size','openai_addon');?></td><td> <?php esc_html_e( 'Action','openai_addon');?></td></tr></thead>
                    <tbody id="post_conversion_files">
                    <?php
                    if($qcld_openai_files && is_array($qcld_openai_files) && count($qcld_openai_files)):
                    foreach($qcld_openai_files as $qcld_openai_file):
                        $file = wp_upload_dir()['basedir'].'/qcldopenai_site_training/'.$qcld_openai_file->post_title;
                        if(file_exists($file)):
                            ?>
                            <tr>
                                <td><?php echo esc_html($qcld_openai_file->post_title);?></td>
                                <td><?php echo date('d.m.Y H:i',strtotime($qcld_openai_file->post_date));?></td>
                                <td><?php echo date('d.m.Y H:i',strtotime($qcld_openai_file->post_modified));?></td>
                                <td><?php echo size_format(filesize($file));?></td>
                                <td>
                                    <a class="button button-small" href="<?php echo wp_upload_dir()['baseurl'].'/qcldopenai_site_training/'.esc_html($qcld_openai_file->post_title)?>" download><?php esc_html_e('Download'); ?></a>
                                    <a class="button button-small qcld_delete_training_file" data-file="<?php echo wp_upload_dir()['basedir'].'/qcldopenai_site_training/'.esc_html($qcld_openai_file->post_title)?>" ><?php esc_html_e('Delete'); ?></a>
                                    <button class="button button-small qcld_convert_upload" data-lines="<?php echo count(file($file))?>" data-file="<?php echo esc_html($qcld_openai_file->post_title)?>"><?php esc_html_e('Upload As FT Model'); ?></button>
                                </td> 
                            </tr>
                <?php
                        endif;
                    endforeach;
                endif;
                ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


