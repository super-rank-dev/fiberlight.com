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
				<th scope="row">Subtitle</th>
				<td>
					<textarea cols="100" rows="2" name="broadcast[subtitle]" required ></textarea>
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
				<th scope="row">Buttons</th>
				<td>
					
					<table class="form-table">

						<tbody>
							<tr valign="top">
								<th scope="row">Button One Text</th>
								<td>
									
									<input type="text" class="form-control" style="width:300px;" name="broadcast[buttons][1][title]" required />
									<i></i>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">Button One Link</th>
								<td>
									
									<input type="text" class="form-control" style="width:300px;" name="broadcast[buttons][1][link]" required />
									<i></i>
								</td>
							</tr>
							
							<tr valign="top">
								<th scope="row">Button Two Text</th>
								<td>
									
									<input type="text" class="form-control" style="width:300px;" name="broadcast[buttons][2][title]" required />
									<i></i>
								</td>
							</tr>
							<tr valign="top">
								<th scope="row">Button Two Link</th>
								<td>
									
									<input type="text" class="form-control" style="width:300px;" name="broadcast[buttons][2][link]" required />
									<i></i>
								</td>
							</tr>
						</tbody>
					</table>
					
				</td>
			</tr>
			
		</tbody></table>
		<p class="submit">
		<input type="hidden" name="pageurl" id="pageurl" value="<?php echo admin_url( 'admin.php?page=wpbot-fb-private-replies&sub=broadcast&fbpage='.$pageId); ?>">
		<input type="hidden" name="pageid" id="pageid" value="<?php echo $pageId; ?>">
		<input type="hidden" name="template" id="template" value="generic">
		<input type="hidden" name="action" id="action" value="qc_fb_broadcast">
		<input type="submit" name="fbbroadcastsubmit" id="submit" class="button button-primary" value="Send Broadcast Message" onclick="return confirm('Are you sure you want to send this broadcast?');"></p>	</form>
		<div class="qc_template_preview" style="float: right;background: #fff;padding: 10px;box-sizing: border-box;width: 36%;border-radius: 10px;">
			<img style="width: 100%;" src="https://scontent.fdac27-1.fna.fbcdn.net/v/t39.2365-6/22880422_1740199342956641_1916832982102966272_n.png?_nc_cat=107&ccb=1-5&_nc_sid=ad8a9d&_nc_eui2=AeGSB87QwxjRMijsRxuyWtl694l3u-WIK1j3iXe75YgrWC6KJuZn2SaecNpWqrzw2g93ifL2J7PPWUz4j42R5PcP&_nc_ohc=12nWWSyd6VkAX-JoIAC&_nc_ht=scontent.fdac27-1.fna&oh=fd265c90fefdd8f2d66fd64860c0bede&oe=617E4404" alt="Generic Template" />
		</div>
	</div>