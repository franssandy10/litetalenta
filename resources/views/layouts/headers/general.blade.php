<?php
	$url = preg_match("/[^\/]+$/", Request::path(), $matches);
	$address = $matches[0];
?>

<div class="generalHeader valign-wrapper">
	<div class="container">
		<div class="row mb0 valign">
			<div class="col l6 mr s12">
				<h1 class="f24 mt0 mb10 lato-black text-capitalize">
					{!! $generalHeaderTitle1 or $address !!}
				</h1>

				<!-- <h2 class="subtitleA01 mb0">
					{!! $generalHeaderTitle2 or 'PT. Talenta Digital Indonesia' !!}
				</h2> -->

			</div>
			<div class="col l6 s12 right-align right-header-general">
				{!! $generalHeaderButton or '' !!}
			</div>
		</div>
	</div>
</div>
