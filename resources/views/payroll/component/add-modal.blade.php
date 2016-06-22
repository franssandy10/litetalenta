<!-- Modal Add / Edit -->
	<!-- Ini buat add component untuk employee baru, jadi tinggal add untuk component yg sudah ada.
	Add component dengan Create component berbeda.
	CREATE component membuat component baru di page payroll configure -->
  <div id="modalAddPayrollComponent" class="modal modal-fixed-footer modal1">
  	<form>
	    <div class="modal-content">
	      <h4 class="titleB01"><span class="titleModalComponent">Add</span> Payroll Component</h4>
	      <div class="row">
	      	<div class="col s12 input-field">
	      		<select id="componentSelect">
	      			<option value="" disabled="disabled" selected="selected">--Choose--</option>
	      		  <?=UserService::listComponent(false)?>
	      		</select>
	      		<label>Payroll Component</label>
	      	</div>
	      	<div class="col s12 input-field">
	      		<input type="text" id="componentAmount" class="money" value="0">
	      		<label for="componentAmount">Component Amount</label>
	      	</div>
	      </div>
	    </div>
	    <div class="modal-footer">
			<a href="#!" class="modal-action modal-close btn btnB01">Cancel</a>
	      	<a href="#!" id="confirmAddComponent" class="modal-action modal-close btn btnB01">Confirm</a>
	    </div>
    </form>
  </div>

<!-- Modal Delete -->
<div id="modalDeletePayrollComponent" class="modal modal-fixed-footer modal-confirm">
  <div class="modal-content">
    <h4 class="titleB01">Delete Component</h4>
    <div class="row">
      <div class="col l12 s12">
        <p>Are you sure want to delete this component?</p>
      </div>
    </div>
  </div>

  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close btn btnB01">Cancel</a>
    <a href="#!" class="btn btnB01 mr5 modal-action modal-close" id="yesDeleteComponent">Yes</a>
  </div>
</div>
