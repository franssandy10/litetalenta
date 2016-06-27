<?php 
	$i = intval(substr(Request::url(), -1));
	$prev = $i - 1;
?>
<div class="col s12" id="getting-started-footer">
	<?php if ($i != 1) { ?>
    	<a href="{{route('index') . '/get-started-' . $prev}}" class="btn btnB01 clearfix mt40 mr5" >prev</a>
    <?php } ?>
    <button id="submitButton" class="btn btnB01 clearfix mt40" name="submitButton">
    	<?php if ($i == 7) {
    		echo 'Finish';
    	} else if ($i == 2) {
    		echo 'Skip';
    	} else {
    		echo 'next';
    	} ?>
    </button>
</div>