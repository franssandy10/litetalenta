@section('payrollDataHtml')

<!-- Payroll Info -->
<div id="payrollInfo" class="tab-content white">
  {!! Form::model($model,array('url' => route($type.'.payrolldata',['id'=>$model->id]))) !!}
  <input type="hidden" name="_method" value="PUT">
  <div class="col l12 m12">
    <p class="titleC01 mb40 noBold mt30">Payroll Info</p>

    <div class="col l12 s12 m12 mb40">
      <p class="left mr30">
        <span class="f15">Basic Salary</span><br>
        <span class="f22 bold" id="basicSalary">{{number_format($model->getCurrentSalary()->new_salary,0,'.',',')}}</span>
      </p>
      <a href="#modalUpdateSalary" data-salary="20000000" class="btn btnB01 left mt10 modal-trigger" id="updateSalary">Salary adjustment</a>
    </div>

    <div class="col m6 s12 input-field">
      <select>
        <option value="">Eligible</option>
        <option value="">Not Eligible</option>
      </select>
      <label>Overtime Status</label>
    </div>
    <div class="col l6 m6 s12 input-field">
      <?= Form::text('bpjstk_number',null,array('id'=>'bpjstk_number','class'=>'validate')) ?>
      <label for="bpjstk_number">BPJS TK (Ketenagakerjaan)</label>
    </div>

    <div class="col l6 m6 s12 input-field">
      <?= Form::text('bpjsk_number',null,array('id'=>'bpjsk_number','class'=>'validate')) ?>
      <label for="bpsjk_number">BPJS Kesehatan</label>
    </div>
    <div class="col l6 m6 s12 input-field">
      <?= Form::select('bank_id', BaseService::getBankName(),null,['class'=>'validate']);?>
      <label>Bank Name</label>
    </div>

    <div class="col l6 m6 s12 input-field">
      <?= Form::text('bank_account',null,array('id'=>'bank_account','class'=>'validate')) ?>
      <label for="bank_account">Bank Account Number</label>
    </div>
    <div class="col l6 m6 s12 input-field">
      <?= Form::text('bank_holder',null,array('id'=>'bank_holder','class'=>'validate')) ?>
      <label for="bankaccountholder">Bank Account Holder</label>
    </div>


    <!-- <div class="col l3 m3 s6 input-field">
      <?= Form::select('tax_config', BaseService::getTaxConfig(),null,['class'=>'validate']);?>
      <label>Tax Config</label>
    </div> -->
    <!-- <div class="col l6 m6 s12 input-field">
      <?= Form::select('salary_config', BaseService::getSalaryConfig(),null,['class'=>'validate']);?>
      <label>Salary Configuration</label>
    </div> -->

    <!-- <div class="col l6 m6 s12 input-field">
      <?= Form::select('salary_type', BaseService::getTypeSalary(),null,['class'=>'validate']);?>
      <label>Type Salary</label>
    </div> -->
  </div> <!-- col l12 -->
  <div class="col s12">
    <div class="col s12 mt35">
      <p class="lato-black f18">Salary Configuration</p>
    </div>
    <div class="col s12 input-field mt0">
      <?= Form::radio('salary_config','non_taxable',true,array('id'=>'non-taxable','class'=>'with-gap')) ?>
      <label for="non-taxable">Non Taxable</label>
    </div>
    <div class="col s12 input-field mb20">
      <?= Form::radio('salary_config','taxable',false,array('id'=>'taxable','class'=>'with-gap')) ?>
      <label for="taxable">Taxable</label>
    </div>
  </div>
  <div class="col s12 displayNone" id="taxableSalaryDiv">
    <div class="col s12 input-field mb20">
      <input id="noNPWP" class="filled-in" name="no_npwp" type="checkbox" value="true" {{ (!isset($model->npwp_number)) ? 'checked="checked"' : "" }} >
      <label for="noNPWP">This employee has no NPWP</label>
    </div>
    <div id="noNPWPDiv">
      <div class="col l6 m6 s12 input-field">
        <?= Form::text('npwp_number',null,array('id'=>'npwp_number','class'=>'validate')) ?>
        <label for="npwp_number">NPWP</label>
      </div>
      <div class="col l6 m6 s12 input-field">
        <?= Form::text('npwp_date',null,array('id'=>'npwp_date','class'=>'validate datepicker')) ?>
        <label for="npwp_date">NPWP Date</label>
      </div>
    </div>
    <div class="col m6 s12 input-field">
      <?= Form::select('tax_config', ['gross'=>'Gross','net'=>'Netto'],null,['id'=>'tax_config','class'=>'validate']);?>
      <label for="tax_config">Tax Config</label>
    </div>
    <div class="col l6 m6 s12 input-field">
      <?= Form::select('employment_tax_status', BaseService::getEmploymentTaxStatus(),null,['class'=>'validate']);?>
      <label>Employee Tax Status</label>
    </div>
    <div class="col l6 m6 s6 input-field">
      <?= Form::select('tax_status', BaseService::getPtkpStatus(),null,['class'=>'validate']);?>
      <label>PTKP Status</label>
    </div>

  </div><!-- col s12 -->
  <div class="col s12 mt30">
    <p class="lato-black f18">Payroll Component</p>
  </div>
  <div class="col l6 s12" id="componentDiv">
    <table id="tableComponent" class="tableHover">
      <thead class="grey lighten-3">
        <tr>
          <th>Component Name</th>
          <th width="130">Amount</th>
          <th width="150"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($payroll_component as $value)
        <tr>
          <td class="componentName">
            {{$value->component->component_name}}
            <input type="hidden" name="component_id" value="{{$value->id}}" class="component_id">
            <input type="hidden" name="component_ids[]" value="{{$value->component_id_fk}}" class="componentName">
          </td>
          <td class="componentAmount">
            {{$value->component_amount}}
            <input type="hidden" name="component_amounts[]" value="{{$value->component_amount}}" class="componentAmount">
          </td>
          <td>
            <a href="#!" class="mr5 editComponent red1-text"><i class="fa fa-edit mr5"></i>Edit</a>
            <a href="#!" class="mr5 removeComponent red1-text"><i class="fa fa-times mr5"></i>Delete</a>
          </td>
        </tr>
        @endforeach
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
  <input class="component_delete" name="component_id_delete" id="component_id_delete" value=""/>
  <div class="col s12 mt15">
    <a href="#!" id="btnAddNewComponent" class="btn btn02">add new component</a>
  </div>
  <div class="row">
    <div class="col l12 right-align">
      <a href="#!" class="btn btnB01 submitButton">Save Payroll Data</a>
    </div>
  </div>
  <input class="text_success" type="hidden" value="Update Payroll Data Successfull"/>

  {!! Form::close() !!}
</div>

<!-- Modal Update Salary -->
<div id="modalUpdateSalary" class="modal modal-fixed-footer modal-confirm">
  {!! Form::open(array('url' => route('salary.adjust'),'autocomplete'=>'off')) !!}
  <div class="modal-content">
    <h4 class="row titleB01">Update Salary</h4>
    <div class="row">
      <div class="col l12 s12 input-field">
        <?= Form::text('new_salary',null,array('id'=>'new_salary','class'=>'validate enter money')) ?>
        <label for="new_salary">New Salary</label>
      </div>
    </div>
  </div>
  <?= Form::hidden('employee_id_fk',$employee_id_fk) ?>
  <input type="hidden" value="Update New Salary"/>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close btn btnB01">Cancel</a>
    <a href="#!" class="btn btnB01 mr5 submitButton" id="yesUpdateSalary">Save</a>
  </div>
  {!!Form::close()!!}
</div>
@endsection
