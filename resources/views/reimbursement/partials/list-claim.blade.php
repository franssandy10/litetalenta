<!-- Approved -->
<div class="row">
  <div class="col l3 m6 s12">
    <p class="red1-text lato-black f20 mt20">Approved Claims</p>
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
          @foreach($taken_list as $data)
            <tr id="{{$data->id}}" class="modal-trigger-history cursorPointer" href="#modalDetailClaim">
              <td>{{$data->policyName()}}</td>
              <td>{{$data->employeeName()}}</td>
              <td value="{{$data->date_reimburse}}">{{Carbon\Carbon::parse($data->date_reimburse)->format('d F Y')}}</td>
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
