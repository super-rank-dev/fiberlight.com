<div class="row">
    <div  class="col-md-12">
        <div class="alert alert-danger my-4">
            <?php esc_html_e('Fine tuning will not work yet if you select GPT 3 Turbo (ChatGPT) and GPT 4 Turbo as engine. We will add this feature as soon as OpenAI API supports it'); ?>
        </div>
        <form class="file_form">
            <div class="success-message alert alert-info"></div>
            <div class="error-message alert alert-danger"></div>
            <input type="file" (change)="fileEvent($event)" class="inputfile" id="openfileinput" style="display:none"/>
            <label for="openfileinput" class="huge ui grey button">
                <i class="fa fa-upload"></i> 
                Upload JSONL
            </label>
        </form>
        </br>
        <a href="https://wpbot.pro/myfile.jsonl" download><?php esc_html_e( 'Right click and Save the Example jsonl file','openai_addon');?></a>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead><tr><td> <?php esc_html_e( 'File name','openai_addon'); ?></td><td><?php esc_html_e( 'File id','openai_addon');?></td><td><?php esc_html_e( 'Action','openai_addon');?></td></tr></thead>
                <tbody id="openaiFileList">
                    
                </tbody>
            </table>
        </div>
        <div class="my-5">
            <h2><?php esc_html_e( 'Fine Tuned Models List','openai_addon');?></br></h2>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead><tr><td><?php esc_html_e( 'FT id','openai_addon');?></td><td><?php esc_html_e( 'FT Model','openai_addon');?></td><td><?php esc_html_e( 'Status','openai_addon');?> </td><td><?php esc_html_e( 'File Name','openai_addon');?></td><td> <?php esc_html_e( 'File Id','openai_addon');?></td></tr></thead>
                <tbody id="openaiFTList">
                    
                </tbody>
            </table>
        </div>
    </div>
</div>


    <div id="qcld-ft-modal" class="modal bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Create your Fine Tune</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="qcld_openai_suffix" class="form-label"><?php esc_html_e( 'Suffix for custom model','openai_addon');?></label>
                        <input id="qcld_openai_ft_suffix" class="form-control" type="text" name="qcld_openai_ft_suffix" value="<?php echo get_option( 'qcld_openai_suffix'); ?>">
                        <input id="qcld_openai_ft_fileid" class="form-control" type="hidden" name="qcld_openai_ft_fileid" value="">
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Fine tune model</label>
                        <select class="form-select" aria-label="Default select example" name="qcld_openai_ft_engines" id="qcld_openai_ft_engines">
                            <option <?php echo ((get_option( 'openai_engines') == '') ? 'selected' : '') ; ?>><?php esc_html_e( 'Please select Engines','openai_addon');?></option>
                            <option value="text-davinci-003" <?php echo ((get_option( 'openai_engines') == 'text-davinci-003') ? 'selected' : '') ; ?>><?php esc_html_e( 'Davinci (GPT-3 model)','openai_addon');?></option>
                            <option value="text-davinci-001" <?php echo ((get_option( 'openai_engines') == 'text-davinci-001') ? 'selected' : '') ; ?>><?php esc_html_e( 'Davinci','openai_addon');?></option>
                            <option value="text-ada-001" <?php echo ((get_option( 'openai_engines') == 'text-ada-001') ? 'selected' : '') ; ?>><?php esc_html_e( 'Ada','openai_addon');?></option>
                            <option value="text-curie-001" <?php echo ((get_option( 'openai_engines') == 'text-curie-001') ? 'selected' : '') ; ?>><?php esc_html_e( 'Curie','openai_addon');?></option>
                            <option value="text-babbage-001" <?php echo ((get_option( 'openai_engines') == 'text-babbage-001') ? 'selected' : '' ); ?>><?php esc_html_e( 'Babbag','openai_addon');?></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary create_ft_model">Create Fine tune</button>
                </div>
            </div>
         </div>
    </div>

