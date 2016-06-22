<!-- Modal Time Off Balance -->
<div id="modalBalance" class="modal modal2">
	<div class="modal-content">
		<a href="#!" class="modal-action modal-close grey-text closeModal"><i class="fa fa-times"></i></a>
		<input type='hidden' id='modalBalance-id'>
		<div class="row">
			<div class="col l7 m6 s12">
				<p class="red1-text lato-black f20 mt20">Time Off Balance By Employee</p>
			</div>
	      	<div class="col l3 m6 s12 right">
	        	<input type="text" class="search searchLive" placeholder="Search">
	      	</div>
	    </div>
		<div class="row">
	      <div class="col l12 positionRelative">
	        <div class="w100p maxHeight370 overflowAuto">
	          <table class="table responsive-table">
	            <thead class="grey lighten-3 bold">
					<tr>
		              	<th class="no-sort">Photo</th>
		              	<th>Full Name</th>
		              	<th>Employee ID</th>
						<th>Quota</th>
						<th>Taken</th>
						<th>Balance</th>
						<th width="100"></th>
					</tr>
	            </thead>
	            <tbody id="tbody-balance">
	            	{{--  put clones of employee balance row here  --}}
	            </tbody>
	          </table>
	        </div>
	      </div>
	    </div>
	</div>
</div>