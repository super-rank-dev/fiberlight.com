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
		<input type="hidden" name="template" id="template" value="button">
		<input type="hidden" name="action" id="action" value="qc_fb_broadcast">
		<input type="submit" name="fbbroadcastsubmit" id="submit" class="button button-primary" value="Send Broadcast Message" onclick="return confirm('Are you sure you want to send this broadcast?');"></p>	</form>
		<div class="qc_template_preview" style="float: right;background: #fff;padding: 10px;box-sizing: border-box;width: 36%;border-radius: 10px;">
			<img style="width: 100%;" src="https://scontent.fcgp17-1.fna.fbcdn.net/v/t39.2365-6/23204276_131607050888932_1057585862134464512_n.png?_nc_cat=106&ccb=1-5&_nc_sid=ad8a9d&_nc_eui2=AeEr6mNSg_iZ_7c8DRnuLVVXCZgcsBgO6OMJmBywGA7o48amrSIT0mCB2pyRDon4b3FC9O7aKYGor87YdSLd7vD1&_nc_ohc=TvFatHfEZDwAX_tQhzr&_nc_ht=scontent.fcgp17-1.fna&oh=b93c637a611c21cd867c8d7872992547&oe=617FA9B6" alt="Generic Template" />
		</div>
	</div>