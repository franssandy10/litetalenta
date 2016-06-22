
	{!! Form::model($payroll_cutoff,array('route' => 'payrollconfigure.payrollcutoff','class'=>'col l12')) !!}

	<table class="bordered">
		<tr>
			<td width="200"><p class="bold">Payroll will be scheduled on</p></td>
			<td colspan="2">
				<div class="col l12">
					<?= Form::text('payroll_schedule',null
						,['id'=>'payroll_schedule','class'=>'validate enter w50 ml10'
							,'maxlength'=>2
							,'max'=>31
							]) ?>

				</div>
			</td>
		</tr>
		<tr>
			<td width="200"><p class="bold">Attendance</p></td>
			<td colspan="2">
				<div class="col l12">
					<?= Form::text('attendance_from',null,['class'=>'validate enter input1 w50 mr10'
						,'maxlength'=>2
						,'max'=>31
					]); ?>to
						<?= Form::text('attendance_to',null,['class'=>'validate enter input1 w50 ml10'
							,'maxlength'=>2
							,'max'=>31
						]); ?>
				</div>
			</td>
		</tr>
		<tr>
			<td><p class="bold">Payroll</p></td>
			<td colspan="2">
				<div class="col l12">
					<?= Form::text('payroll_from',null,['class'=>'validate enter input1 w50 mr10'
						,'maxlength'=>2
						,'max'=>31
					]); ?>to
						<?= Form::text('payroll_to',null,['class'=>'validate enter input1 w50 ml10'
							,'maxlength'=>2
							,'max'=>31
						]); ?>
				</div>
			</td>
		</tr>
		<tr>
			<td height="66"><p class="bold">Tax Setting</p></td>
			<td>
				<div class="col l12 input-field mtm20">
					<?= Form::radio('tax_type',1,($payroll_cutoff->tax_type==1)? true:false,['id' => 'gross','class'=>'with-gap']) ?>
					<label for="gross">Paid by employee</label>
    			</div>
			</td>
			<td>
				<div class="col l12 input-field mtm20">
					<?= Form::radio('tax_type',2,($payroll_cutoff->tax_type==2)? true:false, ['id' => 'netto','class'=>'with-gap']) ?>
					<label for="netto">Paid by company (gross up)</label>
    			</div>
			</td>
		</tr>
		<tr>
			<td height="66"><p class="bold">Salary Setting</p></td>
			<td>
				<div class="col l12 input-field mtm20">
					<?= Form::radio('salary_config',1,($payroll_cutoff->salary_config==1)? true:false,['id' => 'taxable','class'=>'with-gap']) ?>
					<label for="taxable">Taxable</label>
    			</div>
			</td>
			<td>
				<div class="col l12 input-field mtm20">
					<?= Form::radio('salary_config',2,($payroll_cutoff->salary_config==2)? true:false,['id' => 'non_taxable','class'=>'with-gap']) ?>
					<label for="non_taxable">Non Taxable</label>
    			</div>
			</td>
		</tr>
		<tr>
			<td height="66"><p class="bold">JHT Setting</p></td>
			<td>
				<div class="col l12 input-field mtm20">
					<?= Form::radio('company_paid_bpjstk',1,($payroll_cutoff->company_paid_bpjstk==1)? true:false,['id' => 'jhtByEmployee','class'=>'with-gap']) ?>
					<label for="jhtByEmployee">Paid by employee</label>
    			</div>
			</td>
			<td>
				<div class="col l12 input-field mtm20">
					<?= Form::radio('company_paid_bpjstk',2,($payroll_cutoff->company_paid_bpjstk==2)? true:false,['id' => 'jhtByCompany','class'=>'with-gap']) ?>
					<label for="jhtByCompany">Paid by company</label>
    			</div>
			</td>
		</tr>
		<tr>
			<td height="66"><p class="bold">BPJS Kesehatan Setting</p></td>
			<td>
				<div class="col l12 input-field mtm20">
					<?= Form::radio('company_paid_bpjsk',1,($payroll_cutoff->company_paid_bpjsk==1)? true:false,['id' => 'bpjskByEmployee','class'=>'with-gap']) ?>
					<label for="bpjskByEmployee">Paid by employee</label>
    			</div>
			</td>
			<td>
				<div class="col l12 input-field mtm20">
					<?= Form::radio('company_paid_bpjsk',2,($payroll_cutoff->company_paid_bpjsk==2)? true:false,['id' => 'bpjskByCompany','class'=>'with-gap']) ?>
					<label for="bpjskByCompany">Paid by company</label>
    			</div>
			</td>
		</tr>
		<tr>
			<td height="66"><p class="bold">Jaminan Pensiun Setting</p></td>              <input type="hidden" value="Success update cutoff" class="text_success" />

			<td>
				<div class="col l12 input-field mtm20">
					<?= Form::radio('company_paid_jp',1,($payroll_cutoff->company_paid_jp==1)? true:false,['id' => 'jpByEmployee','class'=>'with-gap']) ?>
					<label for="jpByEmployee">Paid by employee</label>
    			</div>
			</td>
			<td>
				<div class="col l12 input-field mtm20">
					<?= Form::radio('company_paid_jp',2,($payroll_cutoff->company_paid_jp==2)? true:false,['id' => 'jpByCompany','class'=>'with-gap']) ?>
					<label for="jpByCompany">Paid by company</label>
    			</div>
			</td>
		</tr>
	</table>
	<input type="hidden" value="Success update cutoff" class="text_success" />

	{!! Form::close()!!}
