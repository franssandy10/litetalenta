<!-- Pending -->
<div class="row">
  <div class="col l3 m6 s12">
    <p class="red1-text lato-black f20 mt20">Waiting for approval</p>
  </div>
  <div class="col l3 s12 m6 right">
    <input type="text" class="search searchLive" placeholder="Search">
  </div>
</div>
<div class="row">
  <div class="col l12 positionRelative">
    <div class="w100p maxHeight370 overflowAuto">
      <table class="table responsive-table">
        <thead class="grey lighten-3 bold">
          <tr>
            <th>Policy Name</th>
            <th>Employee</th>
            <th>Applied on</th>
            <th>Amount</th>
            <th width="100"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($list_pending as $data)
            <tr id="{{$data->id}}" class="modal-trigger-request cursorPointer" href="#modalDetailClaim">
              <td>{{$data->policy->name}}</td>
              <td>{{$data->employee->first_name.' '.$data->employee->last_name}}</td>
              <td>{{Carbon\Carbon::parse($data->created_date)->format('d F Y')}}</td>
              <td>{{'Rp. '.number_format($data->amount,2,'.',',')}}</td>
              <td>
                <a href="#!" class="linkB01">see details</a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
