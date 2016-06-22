{!! Form::open(array('route' => 'getstarted.one','id'=>'getting-started-form')) !!}
<?= Form::text('name','',array('id'=>'name','class'=>'validate enter')) ?>
<?= Form::password('password',array('id'=>'password','class'=>'validate enter')) ?>
<!-- for number  -->
<?= Form::input('number','holiday','12',array('id'=>'holiday','class'=>'center-align')) ?>
<?= Form::radio('payroll_flag','yes',true, ['id' => 'yes','class'=>'choices']) ?>
<?= Form::select('company_jkk', BaseService::getDataJkk(),'',['id'=>'company_jkk','class'=>'validate']); ?>
<?= Form::checkbox('unlimited_flag', 'unlimited', true, ['class' => 'filled-in','id'=>'unlimited_flag']) ?>
<?= Form::hidden('approver_list',Sentinel::getUser()->id.',',array('id'=>'approver_list')) ?>
<input type="hidden" name="_method" value="PUT">
<!-- tergantung dengan apa methodnya karena html tidak mengenal ini -->
{!! Form::close()!!}
