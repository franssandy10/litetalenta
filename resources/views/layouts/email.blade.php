<!DOCTYPE html>
<html lang="en">
<head>
<title>A Responsive Email Template</title>
<!--

    An email present from your friends at Litmus (@litmusapp)

    Email is surprisingly hard. While this has been thoroughly tested, your mileage may vary.
    It's highly recommended that you test using a service like Litmus (http://litmus.com) and your own devices.

    Enjoy!

 -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<style type="text/css">
		#outlook a{
			padding:0;
		}
		.ReadMsgBody{
			width:100%;
		}
		.ExternalClass{
			width:100%;
		}
		.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{
			line-height:100%;
		}
		body,table,td,a{
			-webkit-text-size-adjust:100%;
			-ms-text-size-adjust:100%;
		}
		table,td{
			mso-table-lspace:0pt;
			mso-table-rspace:0pt;
		}
		img{
			-ms-interpolation-mode:bicubic;
		}
		body{
			margin:0;
			padding:0;
		}
		img{
			border:0;
			height:auto;
			line-height:100%;
			outline:none;
			text-decoration:none;
		}
		table{
			border-collapse:collapse !important;
		}
		body{
			height:100% !important;
			margin:0;
			padding:0;
			width:100% !important;
		}
		.appleBody a{
			color:#68440a;
			text-decoration:none;
		}
		.appleFooter a{
			color:#999999;
			text-decoration:none;
		}
	@media screen and (max-width: 525px){
		table[class=wrapper]{
			width:100% !important;
		}

}	@media screen and (max-width: 525px){
		td[class=logo]{
			text-align:left;
			padding:20px 0 20px 0 !important;
		}

}	@media screen and (max-width: 525px){
		td[class=logo] img{
			margin:0 auto!important;
		}

}	@media screen and (max-width: 525px){
		td[class=mobile-hide]{
			display:none;
		}

}	@media screen and (max-width: 525px){
		img[class=mobile-hide]{
			display:none !important;
		}

}	@media screen and (max-width: 525px){
		img[class=img-max]{
			max-width:100% !important;
			width:100% !important;
			height:auto !important;
		}

}	@media screen and (max-width: 525px){
		table[class=responsive-table]{
			width:100%!important;
		}

}	@media screen and (max-width: 525px){
		td[class=padding]{
			padding:10px 5% 15px 5% !important;
		}

}	@media screen and (max-width: 525px){
		td[class=padding-copy]{
			padding:10px 5% 10px 5% !important;
			text-align:center;
		}

}	@media screen and (max-width: 525px){
		td[class=padding-meta]{
			padding:30px 5% 0px 5% !important;
			text-align:center;
		}

}	@media screen and (max-width: 525px){
		td[class=no-pad]{
			padding:0 0 20px 0 !important;
		}

}	@media screen and (max-width: 525px){
		td[class=no-padding]{
			padding:0 !important;
		}

}	@media screen and (max-width: 525px){
		td[class=section-padding]{
			padding:50px 15px 50px 15px !important;
		}

}	@media screen and (max-width: 525px){
		td[class=section-padding-bottom-image]{
			padding:50px 15px 0 15px !important;
		}

}	@media screen and (max-width: 525px){
		td[class=mobile-wrapper]{
			padding:10px 5% 15px 5% !important;
		}

}	@media screen and (max-width: 525px){
		table[class=mobile-button-container]{
			margin:0 auto;
			width:100% !important;
		}

}	@media screen and (max-width: 525px){
		a[class=mobile-button]{
			width:80% !important;
			padding:15px !important;
			border:0 !important;
			font-size:16px !important;
		}

}</style></head>
  <body style="margin: 0; padding: 0;">
    @yield('header')
    @yield('content')
    @yield('footer')
  </body>
</html>
