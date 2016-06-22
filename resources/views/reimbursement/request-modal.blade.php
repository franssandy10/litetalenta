
<!-- Modal Request Reimbursement -->
<div id="modalRequestReimbursement" class="modal modal-fixed-footer modal2">
  {!! Form::open(array('url' => route('reimbursement.request'),'class' => 'formJobDep', 'data-type' => 'departement')) !!}
    <div class="modal-content">
        <h4 class="titleB01">Request Reimbursement</h4>
        <hr class="mb20">
        <div class="row">
            <div class="col l12 m12 s12 input-field">
                <?= Form::select('policy_id_fk', UserService::getReimbursement(),null,['id'=>'policy_id_fk','class'=>'validate enter']); ?>
                <label for="policy_id_fk">Policy Name</label>
            </div>
            <div class="col l12 m12 s12 input-field">
                <?= Form::text('amount',null,array('id'=>'amount','class'=>'validate enter money')) ?>
                <label for="start_date">Amount</label>
            </div>
            <div class="col l12 m12 s12 input-field">
                <span class="mr10">Attachment :</span>
                <a href="#!" class="btn btnB06 fileBtn">upload file</a>
                <div class="hide">
                      <input type="file" id="fileupload">
                      <input type="hidden" id="fileExt" name="fileExt" class="form_clear">
                </div>
                <div id="displayFileName" class="html_clear" style="display:inline">
                </div>
                <input type="hidden" name="attachment" id="attachment" class="form_clear">
            </div>
            <div class="col l12 m12 s12 input-field mt30">
                <?= Form::textarea('reason',null,array('id'=>'reason','class'=>'materialize-textarea')) ?>
                <label for="reason">Reason</label>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close btn btnB01">Cancel</a>
        <a href="#!" class="btn btnB01 submitButton">Request</a>
        <!-- <button type="submit" value="test"/> -->
    </div>
    <input class="text_success" type="hidden" value="Request Sent" >
    {!! Form::close() !!}
</div>


@section('requestjs')
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $("#attachment").val(e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}


$(document).ready(function(){
  $('#fileupload').change(function(){
      var filename = $(this).val();
      if (filename!=''){
        $selector=this;
        $form=$(this).parents('form');
        readURL($selector);
        var x = filename.indexOf("fakepath");
        if (x>0) filename = filename.slice(x+9);
        $('#displayFileName').html(filename);
        $('#fileExt').val(filename.slice(filename.lastIndexOf(".")));
      }
  });

});
</script>
@endsection