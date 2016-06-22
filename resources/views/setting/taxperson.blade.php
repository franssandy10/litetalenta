<div class="col l6 input-field">
  <?= Form::text('tax_person_name',$tax_person['tax_person_name'],array('id'=>'tax_person_name','class'=>'validate enter')) ?>
  <label for="tax_person_name">Tax Person Name</label>
</div>
<div class="col l6 input-field">
  <?= Form::text('tax_person_npwp',$tax_person['tax_person_npwp'],array('id'=>'tax_person_npwp','class'=>'validate')) ?>
  <label for="tax_person_npwp">Tax Person NPWP</label>
</div>
<div class="col l6 input-field">
  <?= Form::text('company_npwp',$tax_person['company_npwp'],array('id'=>'company_npwp','class'=>'validate')) ?>
  <label for="company_npwp">NPWP</label>
</div>
<div class="col l6 input-field">
  <?= Form::text('npwp_date',$tax_person['npwp_date'],array('id'=>'npwp_date','class'=>'validate datepicker')) ?>
  <label for="npwp_date">NPWP Date</label>
</div>
<div class="col l6 input-field">
  <?= Form::text('bpjstk_number',$tax_person['bpjstk_number'],array('id'=>'bpjstk_number','class'=>'validate')) ?>
  <label for="bpjstk_number">BPJS Ketenagakerjaan</label>
</div>
<div class="col l6 input-field">
  <?= Form::select('jkk_type', BaseService::getDataJkk(),$tax_person['jkk_type'],['id'=>'jkk_type','class'=>'validate']); ?>
  <label for="jkk_type">JKK</label>
</div>
