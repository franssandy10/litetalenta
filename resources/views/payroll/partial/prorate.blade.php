<div class="col l8 input-field">
	<select>
		<option>--Select Prorate Setting--</option>
		<option>Based on Working Day</option>
		<option>Based on Calendar Day</option>
		<option>Custom on Working Day</option>
		<option>Custom on Calendar Day</option>
	</select>
	<label>Pro-Rate Setting</label>
</div>
<div class="col l8 input-field mt0">
	<input type="checkbox" class="filled-in" id="countNational">
	<label for="countNational">Count national holiday as a working day</label>
</div>
<div class="col l8 mt40">
	<img src="{{asset(config('param.url_images').'workingdayrumus.png')}}">
	<img src="{{asset(config('param.url_images').'baseoncalender-rumus.png')}}">
	<img src="{{asset(config('param.url_images').'cusworkingcal.png')}}">
	<img src="{{asset(config('param.url_images').'cusworkingday.png')}}">
</div>