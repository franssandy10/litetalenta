<div class="input-field searchEmployeeWrapper">
	<input type="text" class="searchEmployee" placeholder="Search employee">
</div>
<div>
	<ul>
		<?php foreach (UserService::userAccessList() as $list) { ?>
			<li>
				<div class="input-field">
					<input type="checkbox" class="filled-in" name="employees[]" id="searchEmployee_{{$list->employee_id_fk}}_emp" value="{{$list->employee_id_fk}}">
					<label for="searchEmployee_{{$list->employee_id_fk}}_emp">{{$list->userEmployee->first_name . ' ' . $list->userEmployee->last_name}}</label>
				</div>
			</li>
		<?php }  ?>
	</ul>
</div>