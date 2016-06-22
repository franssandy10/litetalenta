<div class="input-field searchEmployeeWrapper">
	<input type="text" class="searchEmployee" placeholder="Search employee">
</div>
<div>
	<ul>
		<?php foreach ($users as $user) { ?>
			<li>
				<div class="input-field">
					<input type="checkbox" class="filled-in" name="" id="searchEmployee_{{$user->id}}">
					<label for="searchEmployee_{{$user->id}}">{{$user->name}}</label>
				</div>
			</li>
		<?php }  ?>
	</ul>
</div>