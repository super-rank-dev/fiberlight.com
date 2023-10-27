<div>	
		<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>" style="float: left;width: 62%;background: #fff;padding: 10px;border-radius: 10px;">
		<table class="form-table">

			<tbody>
			
			<tr valign="top">
				<th scope="row">Image Url</th>
				<td>
					<input type="text" class="form-control" style="width:300px" id="qc_fb_bc_image" name="broadcast[image]" required />
					<button id="qc_fb_get_image_url" class="button">Add Image</button>
					<i>Please add a image url</i>
				</td>
			</tr>
			
            <tr valign="top">
                <th scope="row">Button Label</th>
                <td>
                    
                    <input type="text" class="form-control" style="width:300px;" name="broadcast[button][title]" required />
                    <i></i>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row">Button Link</th>
                <td>
                    
                    <input type="text" class="form-control" style="width:300px;" name="broadcast[button][link]" required />
                    <i></i>
                </td>
            </tr>
			
		</tbody></table>
		<p class="submit">
		<input type="hidden" name="pageurl" id="pageurl" value="<?php echo admin_url( 'admin.php?page=wpbot-fb-private-replies&sub=broadcast&fbpage='.$pageId); ?>">
		<input type="hidden" name="pageid" id="pageid" value="<?php echo $pageId; ?>">
		<input type="hidden" name="template" id="template" value="media">
		<input type="hidden" name="action" id="action" value="qc_fb_broadcast">
		<input type="submit" name="fbbroadcastsubmit" id="submit" class="button button-primary" value="Send Broadcast Message" onclick="return confirm('Are you sure you want to send this broadcast?');"></p>	</form>
		<div class="qc_template_preview" style="float: right;background: #fff;padding: 10px;box-sizing: border-box;width: 36%;border-radius: 10px;">
			<img style="width: 100%;" src="https://scontent.fcgp17-1.fna.fbcdn.net/v/t39.2365-6/23065701_1942345712696886_5686788878908784640_n.png?_nc_cat=100&ccb=1-5&_nc_sid=ad8a9d&_nc_eui2=AeHDjLfDmDuHdyQ3wYTi9uQ6eSBFuMIY0aZ5IEW4whjRpgQT2HKHj1ptZf3QtxzaZcPUiY0JA2Lyml6yyHUz2ixD&_nc_ohc=950sgKLQW50AX9GaanJ&_nc_ht=scontent.fcgp17-1.fna&oh=192f8ba9ce70055a6235acc845dc63c0&oe=617FB8DF" alt="Generic Template" />
		</div>
	</div>