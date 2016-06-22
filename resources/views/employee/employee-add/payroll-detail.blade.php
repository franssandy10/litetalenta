@section('payrollDetailHtml')
<!-- Company Detail -->
<!-- Payroll -->
<li id="payroll">
  <div class="container">
    <div class="row">
      {!! Form::open(array('url' => 'employee/create/validatePayrollDetail')) !!}
      <div class="col l12 s12 hide-on-small-only">
        <p class="lato-light red1-text f25">Payroll</p>
      </div>

      <div class="col l6 m6 s12 input-field">
        <?= Form::text('salary','',array('id'=>'salary','class'=>'validate money')) ?>
        <label for="salary">Salary*</label>
      </div>
      <!-- <div class="col l6 m6 s12 input-field">
        <select>
          <option value="eligible">Eligible</option>
          <option value="noteligible">Not Eligible</option>
        </select>
        <label>Overtime Status</label>
      </div> -->

      <div class="col l6 m6 s12 input-field">
        <?= Form::text('bpjstk_number','',array('id'=>'bpjstk_number','class'=>'validate')) ?>
        <label for="bpjstk_number">BPJSTK (Ketenagakerjaan)</label>
      </div>
      <div class="col m6 s12 input-field">
        <?= Form::text('bpjsk_number','',array('id'=>'bpjsk_number','class'=>'validate')) ?>
        <label for="bpjsk_number">BPJS Kesehatan</label>
      </div>

       <div class="col m6 s12 input-field">
        <?= Form::select('bank_id', BaseService::getBankName(),'',['id'=>'bank_id_fk','class'=>'validate']);?>
        <label for="bank_id_fk">Bank Name</label>
      </div>
      <div class="col m6 s12 input-field">
        <?= Form::text('bank_account','',array('id'=>'bank_account','class'=>'validate')) ?>
        <label for="bank_account">Bank Account Number</label>
      </div>

      <div class="col m6 s12 input-field">
        <?= Form::text('bank_holder','',array('id'=>'bank_holder','class'=>'validate')) ?>
        <label for="bank_holder">Bank Account Holder</label>
      </div>

      <div class="col s12 mt35">
        <p class="lato-black f18">Salary Configuration</p>
      </div>
      <div class="col s12 input-field mt0">
        <?= Form::radio('salary_config','non_taxable',false,array('id'=>'non-taxable','class'=>'with-gap')) ?>
        <label for="non-taxable">Non Taxable</label>
      </div>
      <div class="col s12 input-field">
        <?= Form::radio('salary_config','taxable',true,array('id'=>'taxable','class'=>'with-gap')) ?>
        <label for="taxable">Taxable</label>
      </div>
      <div id="taxableSalaryDiv" class="displayNone">
        <div class="col s12 input-field mb20">
          <?= Form::checkbox('no_npwp','true',false,array('id'=>'noNPWP','class'=>'filled-in')) ?>
          <label for="noNPWP">This employee has no NPWP</label>
        </div>

        <div id="noNPWPDiv">
          <div class="col l6 m6 s12 input-field">
            <?= Form::text('npwp_number','',array('id'=>'npwp_number','class'=>'validate npwp_format')) ?>
            <label for="npwp">NPWP</label>
          </div>
          <div class="col m6 s12 input-field">
            <?= Form::text('npwp_date','',array('id'=>'npwp_date','class'=>'validate datepicker')) ?>
            <label for="npwp_date">NPWP Date</label>
          </div>
        </div>
        <div class="col m6 s12 input-field">
          <?= Form::select('tax_config', ['gross'=>'Gross','net'=>'Netto'],'net',['id'=>'tax_config','class'=>'validate']);?>
          <label for="tax_config">Tax Config</label>
        </div>
        <div class="col m6 s12 input-field">
          <?= Form::select('employment_tax_status', BaseService::getEmploymentTaxStatus(),'',['id'=>'employment_tax_status','class'=>'validate']);?>
          <label for="employment_tax_status">Employee Tax Status</label>
        </div>
        <div class="col m6 s12 input-field">
          <?= Form::select('tax_status', BaseService::getPtkpStatus(),'',['id'=>'tax_status','class'=>'validate']);?>
          <label for="tax_status">PTKP Status*</label>
        </div>
      </div>
      <div class="col s12 mt30">
        <p class="lato-black f18">Payroll Component</p>
      </div>
      <div class="col l6 s12 displayNone" id="componentDiv">
        <table id="tableComponent" class="tableHover">
          <thead class="grey lighten-3">
            <tr>
              <th>Component Name</th>
              <th width="130">Amount</th>
              <th width="150"></th>
            </tr>
          </thead>
          <tbody>
            <tr class="template">
              <td class="componentName">
                Tunjangan Makan
                <input type="hidden" name="component_name" class="componentName">
              </td>
              <td class="componentAmount">
                600.000
                <input type="hidden" name="component_amount" class="componentAmount">
              </td>
              <td>
                <a href="#!" class="mr5 editComponent red1-text"><i class="fa fa-edit mr5"></i>Edit</a>
                <a href="#!" class="mr5 removeComponent red1-text"><i class="fa fa-times mr5"></i>Delete</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="col s12 mt15">
        <a href="#!" id="btnAddNewComponent" class="btn btn02">add new component</a>
      </div>
      {!! Form::close() !!}
      <div class="col l12 s12 mt30 right-align">
        <a href="#!" class="btn btnB01 prevStep mr5">Prev</a>
        <a href="#!" class="btn btnB01 nextStep">Next</a>
      </div>

    </div>
  </div>
</li>



@endsection
