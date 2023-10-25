<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Email Verification </title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
		<style type="text/css">
			body {
				font-family: Poppins;
			}
			* {
				-ms-text-size-adjust:100%;
				-webkit-text-size-adjust:none;
				-webkit-text-resize:100%;
				text-resize:100%;
				font-family: Poppins;
			}
			a{
				outline:none;
				color:#40aceb;
				text-decoration:underline;
			}
			a:hover{text-decoration:none !important;}
			.nav a:hover{text-decoration:underline !important;}
			.title a:hover{text-decoration:underline !important;}
			.title-2 a:hover{text-decoration:underline !important;}
			.btn:hover{opacity:0.8;}
			.btn a:hover{text-decoration:none !important;}
			.btn{
				-webkit-transition:all 0.3s ease;
				-moz-transition:all 0.3s ease;
				-ms-transition:all 0.3s ease;
				transition:all 0.3s ease;
			}
			table td {border-collapse: collapse !important;}
			.ExternalClass, .ExternalClass a, .ExternalClass span, .ExternalClass b, .ExternalClass br, .ExternalClass p, .ExternalClass div{line-height:inherit;}
			table[class="flexible"]{width: 600px;}
			@media only screen and (min-width:501px) {
				.table-tr-td { border: none; border-collapse: collapse; border-collapse: collapse; padding: 5px 25px 5px 0px !important; }
			}
			@media only screen and (max-width:500px) {
				table[class="flexible"]{width: 400px !important; padding: 10px 40px;}
				table[class="table-tx-body"]{font-family: 'Poppins', sans-serif;font-size: 95%;}
				table[class="center"]{
					float:none !important;
					margin:0 auto !important;
				}
				*[class="hide"]{
					display:none !important;
					width:0 !important;
					height:0 !important;
					padding:0 !important;
					font-size:0 !important;
					line-height:0 !important;
				}
				td[class="img-flex"] img{
					width:100% !important;
					height:auto !important;
				}
				td[class="aligncenter"]{text-align:center !important;}
				th[class="flex"]{
					display:block !important;
					width:100% !important;
				}
				td[class="wrapper"]{padding:0 !important;}
				td[class="holder"]{padding:30px 15px 20px !important;}
				td[class="nav"]{
					padding:20px 0 0 !important;
					text-align:center !important;
				}
				td[class="h-auto"]{height:auto !important;}
				td[class="description"]{padding:30px 20px !important;}
				td[class="i-120"] img{
					width:120px !important;
					height:auto !important;
				}
				td[class="footer"]{padding:5px 20px 20px !important;}
				td[class="footer"] td[class="aligncenter"]{
					line-height:25px !important;
					padding:20px 0 0 !important;
				}
				tr[class="table-holder"]{
					display:table !important;
					width:100% !important;
				}
				th[class="thead"]{display:table-header-group !important; width:100% !important;}
				th[class="tfoot"]{display:table-footer-group !important; width:100% !important;}
				.table-tr-td { border: none; border-collapse: collapse; border-collapse: collapse; padding: 5px 25px 5px 5px !important; }
				
			}
		</style>
	</head>
	<body style="margin:0; padding:0; font-family:Poppins, sans-serif;" bgcolor="#eaeced">
		<table style="min-width:300px;" width="100%" cellspacing="0" cellpadding="0" bgcolor="#eaeced">
			<!-- fix for gmail -->
			<tr>
				<td class="wrapper" style="padding:0 10px;">
					<!-- module 1 -->
					
					<!-- module 2 -->
					<table data-module="module-2" data-thumb="thumbnails/02.png" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td data-bgcolor="bg-module" bgcolor="#eaeced">
								<table class="flexible" width="600" align="center" style="margin:0 auto;" cellpadding="0" cellspacing="0">
									<tr>
										<td class="" style="padding-bottom: 10px; padding-top: 20px; text-align: left;"> 
											<a href="<?=$header_image_url?>"><img src="<?=base_url('assets/images/logo/logo.png')?>" style="width: 60px; height: auto; " alt="Shortly"></a>
										</td>
									</tr>

									<tr>
										<td data-color="text" data-size="size text" data-min="10" data-max="26" data-link-color="link text color" style="color: #363636; font:normal 16px/25px Poppins, Helvetica, sans-serif; color: #363636; font-weight: 600;">
											Hello,
										</td>
									</tr>
									<tr>
										<td data-color="text" data-size="size text" data-min="10" data-max="26" data-link-color="link text color" data-link-style="font-weight:bold; text-decoration:underline; color:#40aceb;"  style="font:normal 16px/26px Poppins, Helvetica, sans-serif; color:#363636; padding:0 0 20px;">
											<p style="color:#515151;">
												You received this email for your account recovery. Click and access the URL below or copy and paste it on your browser for you to login.<br><br>
                                                We recommend you to generate a new secret key and save it on a safe place as its the only way for you to login to your account.<br>

                                                <a href="<?=$login_url?>"><?=$login_url?></a>
											</p>
                                            <p style="color:#515151; margin-top: 20px;">
                                                Notice: If you did not perform this action, please contact us to immediately or request to delete your records to us.
											</p>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					
					<!-- module 7 -->
					<table data-module="module-7" data-thumb="thumbnails/07.png" width="100%" cellpadding="0" cellspacing="0">
						<tr>
							<td data-bgcolor="bg-module" bgcolor="#eaeced">
								<table class="flexible" width="600" align="center" style="margin:0 auto;" cellpadding="0" cellspacing="0">
									<tr>
										<td class="footer" style="padding:0 0 10px;">
											<table width="100%" cellpadding="0" cellspacing="0">
												<tr class="table-holder">
													<th class="tfoot" width="400" align="left" style="vertical-align:top; padding:0;">
														<table width="100%" cellpadding="0" cellspacing="0">
															<tr>
																<td data-color="text" data-link-color="link text color" data-link-style="text-decoration:underline; color:#797c82;" class="aligncenter" style="font:12px/16px Arial, Helvetica, sans-serif; color:#797c82; padding:0 0 10px; padding-top: 5px; text-align: left;">
																	<a href="<?=$header_image_url?>"><img src="<?=$header_image?>" style="width: 130px; height: auto; " alt="Shortly"></a>
																</td>
															</tr>
															<tr>
																<td data-color="text" data-link-color="link text color" data-link-style="text-decoration:underline; color:#797c82;" class="aligncenter" style="font:12px/16px Arial, Helvetica, sans-serif; color:#797c82; padding:0 0 10px; padding-top: 5px;">
																	&copy; <?=date('Y')?> <?=$website_settings['website_name']?> All Rights Reserved. 
																</td>
															</tr>
														</table>
													</th>
												</tr>
											</table>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<!-- fix for gmail -->
			<tr>
				<td style="line-height:0;"><div style="display:none; white-space:nowrap; font:15px/1px courier;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div></td>
			</tr>
		</table>
	</body>
</html>