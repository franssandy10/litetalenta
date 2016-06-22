<div class="input-field searchEmployeeWrapper">
	<input type="text" class="searchEmployee" placeholder="Search employee">
</div>
<div>
	<ul>
		<?php foreach (UserService::listEmployeeForm() as $list) { ?>
			<li>
				<div class="input-field">
					<input type="checkbox" class="filled-in" name="employees[]" id="searchEmployee_{{$list->id}}" value="{{$list->id}}">
					<label for="searchEmployee_{{$list->id}}">{{$list->first_name . ' ' . $list->last_name}}</label>
				</div>
			</li>
		<?php }  ?>
	</ul>
</div>