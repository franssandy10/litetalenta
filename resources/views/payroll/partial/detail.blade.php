{!! Form::model($tax_person,array('route' => 'payrollconfigure.payrolldetail','id'=>'getting-started-form')) !!}
	<div class="col l6 input-field">
		<?= Form::text('tax_person_name',null,array('id'=>'tax_person_name','class'=>'validate enter')) ?>
		<label for="tax_person_name">Tax Person Name</label>
	</div>
	<div class="col l6 input-field">
		<?= Form::text('tax_person_npwp',null,array('id'=>'tax_person_npwp','class'=>'validate enter')) ?>
		<label for="tax_person_npwp">Tax Person NPWP</label>
	</div>
	<div class="col l6 input-field">
		<?= Form::text('company_npwp',null,array('id'=>'company_npwp','class'=>'validate enter')) ?>
		<label for="company_npwp">Company NPWP</label>
	</div>
	<div class="col l6 input-field">
		<?= Form::text('npwp_date',null,array('id'=>'npwp_date','class'=>'validate enter datepicker')) ?>
		<label for="npwp_date">NPWP Date</label>
	</div>
	<div class="col l6 input-field">
		<?= Form::text('bpjstk_number',null,array('id'=>'bpjstk_number','class'=>'validate enter')) ?>
		<label for="bpjstk_number">BPJS Ketenagakerjaan</label>
	</div>
	<div class="col l6 input-field">
		<?= Form::select('jkk_type', BaseService::getDataJkk(),null,['id'=>'jkk_type','class'=>'validate']); ?>
		<label>JKK</label>
	</div>
</form>
