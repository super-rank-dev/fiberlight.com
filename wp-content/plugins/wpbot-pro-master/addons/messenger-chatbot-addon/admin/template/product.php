<div>	
		<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>" style="float: left;width: 62%;background: #fff;padding: 10px;border-radius: 10px;">
		<table class="form-table">

			<tbody><tr valign="top">
				<th scope="row">Title</th>
				<td>
					
					<input type="text" class="form-control" style="width:300px;" name="broadcast[title]" required />
						
					<i></i>
				</td>
			</tr>
            <tr valign="top">
				<th scope="row">Price</th>
				<td>
                    <input type="text" class="form-control" style="width:300px;" name="broadcast[price]" required /> <i> Add price with currency symbol. Ex: $100</i>
				</td>
			</tr>
			
			<tr valign="top">
				<th scope="row">Image Url</th>
				<td>
					<input type="text" class="form-control" style="width:300px" id="qc_fb_bc_image" name="broadcast[image]" required />
					<button id="qc_fb_get_image_url" class="button">Add Image</button>
					<i>Please add a image url</i>
				</td>
			</tr>
			
            <tr valign="top">
                <th scope="row">Link</th>
                <td>
                    
                    <input type="text" class="form-control" style="width:300px;" name="broadcast[link]" required />
                    <i></i>
                </td>
            </tr>
			
		</tbody></table>
		<p class="submit">
		<input type="hidden" name="pageurl" id="pageurl" value="<?php echo admin_url( 'admin.php?page=wpbot-fb-private-replies&sub=broadcast&fbpage='.$pageId); ?>">
		<input type="hidden" name="pageid" id="pageid" value="<?php echo $pageId; ?>">
		<input type="hidden" name="template" id="template" value="product">
		<input type="hidden" name="action" id="action" value="qc_fb_broadcast">
		<input type="submit" name="fbbroadcastsubmit" id="submit" class="button button-primary" value="Send Broadcast Message" onclick="return confirm('Are you sure you want to send this broadcast?');"></p>	</form>
		<div class="qc_template_preview" style="float: right;background: #fff;padding: 10px;box-sizing: border-box;width: 36%;border-radius: 10px;">
			<img style="width: 100%;" src="https://scontent.fcgp17-1.fna.fbcdn.net/v/t39.8562-6/116583093_583752462321305_2442326060634183872_n.png?_nc_cat=106&ccb=1-5&_nc_sid=6825c5&_nc_ohc=L4EdBQi-eX4AX9v8lfV&_nc_ht=scontent.fcgp17-1.fna&oh=ad2b21ee13d84de21db63c81c0004aa7&oe=617F1DDE" alt="Generic Template" />
		</div>
	</div>