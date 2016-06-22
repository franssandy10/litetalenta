<div class="col s12">
	<p class="bold mb0 subtitleA01 black-text">Employee less than 1 year</p>
	<p class="left mt30">New Employee can get THR after</p>
	<div class="col l1 input-field">
		<input type="number">
	</div>
	<p class="left mt30">months</p>
	<div class="clearfix"></div>
	<p class="bold mb10">Pro-rate Setting</p>
	<p><img align="middle" class="mr5" src="{{asset(config('param.url_images').'imgprorateset.png')}}">Time : Join time until religious holiday date (in months)</p>

	<p class="bold mt30">Rounding Setting</p>
	<p class="left mt20">Employee who has length of service greater than</p>
	<div class="col l1">
		<input type="number">
	</div>
	<p class="left mt20">will be equal to 1 month</p>
	<div class="col l12 input-field">
		<input type="checkbox" class="filled-in" id="noRoundTHR">
		<label for="noRoundTHR">No Rounding</label>
	</div>

	<div class="clearfix"></div>
	<p class="bold mb0 mt40 subtitleA01 black-text mb20">Employee less than 1 year</p>
	<div class="col l5 input-field">
		<select id="thr-payroll_component" class="form-control initialized" name="Thr[payroll_component]">
			<option>--Select Payroll Component--</option>
			<option value="32">Tunjangan Parkir</option>
			<option value="40">Tunjangan Lain</option>
			<option value="53">Tunjangan Jabatan</option>
			<option value="127">Tunjangan transport</option>
			<option value="445">Tunjangan A</option>
		</select>
		<label>Payroll Component Included</label>
	</div>
	<div class="col l1">
		<a href="#!" class="btn btnB01 mt20">add</a>
	</div>

	<div class="clearfix"></div>
	<p class="bold mt30">Multiplier Setting</p>

	<table>
		<tr>
			<td width="250">For employee who have joined</td>
			<td>
				<input type="text">
			</td>
			<td width="150">Year(s) multiple by</td>
			<td>
				<input type="text">
			</td>
			<td>times</td>
			<td><a href="#!" class="red1-text bold"><i class="fa fa-times"></i></a></td>
		</tr>
	</table>

	<a href="#!" class="btn btnB01 mt20">add</a>
</div>