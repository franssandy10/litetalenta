@section('companyDetailHtml')
<!-- Company Detail -->
<div id="company-detail" class="col l12 pad-20 tab-content">
  <div class="row">
    <p class="titleB01">Company Detail</p>
    <hr class="mt10 mb20">
    {!! Form::model($company_detail,array('url' => route('setting.update.company-detail'))) !!}
    <div class="col l12">
      <img src="{{asset(config('param.url_uploads').'blank.jpg')}}" class="circle" width="100">
    </div>
    <div class="col l12 mb20">
      <a class="linkB01 mt10" href="#!" id="changePicture">Change Logo</a>
    </div>
    <div class="col l7 input-field">
      <?= Form::text('name',null,array('id'=>'name','class'=>'validate enter')) ?>
      <label for="name">Company Name</label>
    </div>
    <div class="col l5 input-field">
      <?= Form::email('email',null,array('id'=>'email','class'=>'validate enter')) ?>
      <label for="email">Email</label>
    </div>
    <div class="col l12 input-field">
      <?= Form::textarea('address',null,array('id'=>'address','class'=>'validate materialize-textarea enter')) ?>
      <label for="address">Address</label>
    </div>
    <div class="col l4 input-field">
      <?= Form::select('province_id_fk', UserService::getProvince(),null,['id'=>'province_id_fk','class'=>'validate enter']); ?>
      <label>State/Province</label>
    </div>
    <div class="col l4 input-field">
      <?= Form::text('city',null,['id'=>'city','class'=>'validate enter']); ?>
      <label for="city">City</label>
    </div>
    <div class="col l4 input-field">
      <?= Form::text('postcode',null,array('id'=>'postcode','class'=>'validate enter')) ?>
      <label for="postcode">Postal Code</label>
    </div>
    <div class="col l4 input-field">
      <?= Form::text('phone',null,array('id'=>'phone','class'=>'validate enter')) ?>
      <label for="phone">Phone</label>
    </div>
    <div class="clearfix"></div>
    <div class="col l12 right-align mt30">
      <a href="#!" class="btn btnB01 submitButton">save</a>
    </div>
    <input class="text_success" type="hidden" value="Update Detail Successfull"/>

    {!! Form::close()!!}
  </div>
</div>
@endsection


@section('detailjs')
<script>
$(document).ready(function(){

  $("#province_id_fk").trigger('change');
});
</script>
@endsection
