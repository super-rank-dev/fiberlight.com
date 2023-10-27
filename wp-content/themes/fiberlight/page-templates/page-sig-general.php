<?php
/*
Template Name: General Signature
*/

if( isset($_POST['firstName']) ) :

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $title = $_POST['title'];
    $address1 = $_POST['address1'];
    $address2 = $_POST['address2'];
    $officeDisplay = $_POST['officeDisplay'];
    $cellDisplay = $_POST['cellDisplay'];
    $linkedIn = $_POST['linkedIn'];
    $twitter = $_POST['twitter'];
?>
<html><head>


</head>

<body padding="0" margin="0" data-gr-c-s-loaded="true">

	<style type="text/css">
		.ii a[href] {color: #333F48; text-decoration: none;}
		.gt a {color: #333F48; text-decoration: none;}
		a {color: #333F48; text-decoration: none;}
		a:any-link {color: inherit; text-decoration: none;}
	</style>

	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tbody><tr>
			<td align="left" style="padding-right: 20px;"><!-- Ensures spacing if wrapping on mobile -->

				<table border="0" cellpadding="0" cellspacing="0" width="100%">

					<!-- Logo -->
					<tbody><tr>
						<td>
							<a href="https://www.fiberlight.com" style="text-decoration: none; border: none;"><img src="https://www.fiberlight.com/wp-content/uploads/2022/02/fiberlight-logo-web-325x72@2x.png" alt="Fiberlight Logo" style="width: 170px; height: 40px;" width="170" height="40"></a>
						</td>
					</tr>
					<!-- Name -->
					<tr>
						<td align="left" valign="baseline" style="font-family: verdana, sans-serif; font-size: 14px; line-height: 18px; color: #333F48; font-weight: bold; padding-top: 12px; padding-left: 39px;">
							<?= $firstName; ?> <?= $lastName; ?>
						</td>
					</tr>
					<!-- Title -->
					<tr>
						<td align="left" valign="baseline" style="font-family: verdana, sans-serif; font-size: 11px; line-height: 18px; color: #97D91A; text-transform: uppercase; letter-spacing: 0.5px; font-weight: bold; padding-left: 39px;">
							<?= $title; ?>
						</td>
					</tr>
					<!-- Address -->
          <? if($address1 && $address2) : ?>
  					<tr>
  						<td align="left" valign="baseline" style="font-family: verdana, sans-serif; font-size: 10px; line-height: 18px; color: #333F48; text-transform: uppercase; letter-spacing: 0.5px; padding-top: 6px; padding-left: 39px;">
  							<?= $address1; ?><br>
  							<?= $address2; ?>
  						</td>
  					</tr>
          <? endif; ?>
					<!-- Phone Numbers -->
					<tr>
						<td align="left" style="padding-top: 9px; padding-left: 39px;">
							<table border="0" cellpadding="0" cellspacing="0">
								<tbody><tr>
										<td align="left" valign="baseline" style="font-family: verdana, sans-serif; font-size: 10px; line-height: 12px; color: #333F48; text-transform: uppercase; letter-spacing: 0.5px; padding-right: 10px;">
										<? if ( $officeDisplay ) : ?>
											<span style="color: #97D91A; font-weight: bold;">O</span>&nbsp;&nbsp;<a href="tel:<?= $officeDisplay; ?>" target="_blank" style="color: #333F48; text-decoration: none;"><?= $officeDisplay; ?></a>
										<? endif; ?>
                    <? if ( $officeDisplay && $cellDisplay ) : ?>
										</td>
										<td align="left" valign="baseline" style="font-family: verdana, sans-serif; font-size: 10px; line-height: 12px; color: #333F48; text-transform: uppercase; letter-spacing: 0.5px; padding-left: 10px; border-left: 1px solid #333F48;">
                    <? endif; ?>
										<? if ( $cellDisplay ) : ?>
											<span style="color: #97D91A; font-weight: bold;">M</span>&nbsp;&nbsp;<a href="tel:<?= $cellDisplay; ?>" target="_blank" style="color: #333F48; text-decoration: none;"><?= $cellDisplay; ?></a>
										<? endif; ?>
										</td>
								</tr>
							</tbody></table>
						</td>
					</tr>
					<!-- Website -->
					<tr>
						<td align="left" style="padding-top: 10px; padding-left: 39px;">
							<table border="0" cellpadding="0" cellspacing="0">
								<tbody><tr>
									<td align="left" valign="baseline" style="font-family: verdana, sans-serif; font-size: 11px; line-height: 18px; color: #333F48; text-transform: uppercase; letter-spacing: 0.5px; font-weight: bold; padding-right: 10px;" link="#333F48" vlink="#333F48">
										<a href="https://fiberlight.com" target="_blank" style="color: #333F48; text-decoration: none;">fiberlight.com</a>
									</td>
									<td align="left" valign="center" style="padding-right: 4px;">
										<? if ( $linkedIn ) : ?>
											<a href="<?= $linkedIn; ?>" target="_blank"><img src="https://46bpr041z4z5qpge43ag4kb5-wpengine.netdna-ssl.com/wp-content/themes/fiberlight/img/linkedin.png" width="18" height="18" style="width: 15px; height: 15px;"></a>
										<? endif; ?>
									</td>
									<td align="left" valign="center">
										<? if ( $twitter ) : ?>
											<a href="<?= $twitter; ?>" target="_blank"><img src="https://46bpr041z4z5qpge43ag4kb5-wpengine.netdna-ssl.com/wp-content/themes/fiberlight/img/twitter.png" width="18" height="18" style="width: 15px; height: 15px;"></a>
										<? endif; ?>
									</td>
								</tr>
							</tbody></table>
						</td>
					</tr>
					<!-- Footer / Disclaimer -->
					<tr>
						<td align="left" valign="baseline" style="font-family: verdana, sans-serif; font-size: 11px; line-height: 18px; color: #97D91A; text-transform: uppercase; letter-spacing: 0.5px; font-weight: bold; padding-top: 12px; padding-left: 39px;">
							/
						</td>
					</tr>
					<tr>
						<td align="left" valign="baseline" style="font-family: verdana, sans-serif; font-size: 9px; line-height: 12px; color: #A4ABAF; text-transform: uppercase; letter-spacing: 0.5px; padding-top: 6px; padding-left: 39px;">
							<span style="font-weight: bold;">Fiberlight NOC</span><br>
							<a href="mailto:NOC@fiberlight.com" target="_blank" style="color: #A4ABAF; text-decoration: none;">NOC@fiberlight.com</a>&nbsp;&nbsp;|&nbsp;&nbsp;800.672.0181
						</td>
					</tr>
					<tr>
						<td align="left" valign="baseline" style="font-family: verdana, sans-serif; font-size: 9px; line-height: 12px; color: #A4ABAF; padding-top: 6px; padding-left: 39px;">
							This message and its contents are only for the personal and confidential use of the individuals to which it is addressed. If you have received this message in error, do not use, rely upon, distribute, or disclose this message. Instead, please notify the sender immediately and delete this message. PLEASE NOTE: NO EMPLOYEE OR AGENT IS AUTHORIZED TO CONCLUDE ANY BINDING AGREEMENT ON BEHALF OF FIBERLIGHT, LLC WITH THE RECIPIENT OF THIS EMAIL WITHOUT EXPRESS WRITTEN APPROVAL BY AN OFFICER OF FIBERLIGHT, LLC. IN NO EVENT WILL THIS EMAIL OR ITS CONTENT BE CONSTRUED AS WRITTEN APPROVAL.
						</td>
					</tr>
				</tbody></table>

			</td>
		</tr>
	</tbody></table>

</body>

<?

else :

get_template_part( 'includes/header' ); ?>

<section class="section-wrap pb-mainstage_area light-gray-bg"><div class="mainstage-wrap gunmetal-bg">
    <div class="row expanded align-middle align-center">
        <div class="small-12 medium-11 large-10 columns content" style="margin-top: 0px; min-height: 0px; max-height: 0px">

        </div>


    </div>
</div>
</section>
<section class="signature">
    <div class="row">
        <div class="column small-12 title">
            <h2>
                Corporate Signature Creator
            </h2>
            <p>Star (*) indicates required field.</p>
        </div>
        <form action="<?= get_the_permalink(); ?>" method="post">
            <div class="column small-12">
                <h6>First Name*</h6>
                <input type="text" name="firstName" placeholder="Eg: John" required>
            </div>
            <div class="column small-12">
                <h6>Last Name*</h6>
                <input type="text" name="lastName" placeholder="Eg: Doe" required>
            </div>
            <div class="column small-12">
                <h6>Title*</h6>
                <input type="text" name="title" placeholder="Eg: President" required>
            </div>
            <div class="column small-12">
                <h6>Address Line 1</h6>
                <input type="text" name="address1" value="3000 Summit Place, Suite 200,">
            </div>
            <div class="column small-12">
                <h6>Address Line 2</h6>
                <input type="text" name="address2" value="Alpharetta, GA 30009">
            </div>
            <div class="column small-12">
                <h6>Office Phone</h6>
                <p>Enter your office number in the following format, with decimals: 555.555.5555</p>
                <input type="text" name="officeDisplay" placeholder="Eg: 555.555.5555">
            </div>
            <div class="column small-12">
                <h6>Cell Phone</h6>
                <p>Enter your cell number in the following format, with decimals: 555.555.5555</p>
                <input type="text" name="cellDisplay" placeholder="Eg: 555.555.5555">
            </div>
            <div class="column small-12">
                <h6>LinkedIn URL</h6>
                <p>Enter your LinkedIn URL (with the https://)</p>
                <input type="text" name="linkedIn" placeholder="Eg: https://www.linkedin.com/in/example/">
            </div>
            <div class="column small-12">
                <h6>Twitter URL</h6>
                <p>Enter your Twitter URL (with the https://)</p>
                <input type="text" name="twitter" placeholder="Eg: https://www.twitter.com/">
            </div>
            <div class="column small-12">
                <input type="submit" class="button secondary">
                <p>Click the above button to generate your signature. After you submit, if there's an issue with the signature and you need to change these values, simply click your back button.</p>
            </div>
        </form>
    </div>
</section>


<?php

get_template_part( 'includes/footer' );

endif;

?>
