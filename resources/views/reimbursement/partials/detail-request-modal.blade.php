<!-- Modal Detail Claim -->
<div id="modalDetailClaim" class="modal modal-fixed-footer modal1">
  <input id="reimbursementRequestDetailURL" type="hidden" value="{{route('reimbursement.request.detail')}}">
  <input id="reimbursementHistoryDetailURL" type="hidden" value="{{route('reimbursement.history.detail')}}">
  <input id="modalDC-id" type="hidden" >
  <div class="modal-content">
    <a href="#!" class="modal-action modal-close grey-text closeModal"><i class="fa fa-times"></i></a>
    <div class="row">
      <p class="titleB01">Claim Details</p>
      <p id="modalDC-policy" class="f18 grey-text text-darken-3 lato-bold">Travel Allowances</p>
      <input type='hidden' id='modalDC-id' value=''>
    </div>
    <div class="row">
      <div class="bBottom pad-b-20">
        <div class="clearfix mb5">
          <p class="col l4 pad-l-n">Requested by</p>
          <p id="modalDC-name" class="col l8 bold">Cheryl Cyrilla</p>
        </div>

        <div class="clearfix mb5">
          <p class="col l4 pad-l-n">Amount</p>
          <p id="modalDC-amount" class="col l8 bold">250,000</p>
        </div>

        <div class="clearfix mb5 ">
          <p class="col l4 pad-l-n">Applied on</p>
          <p id="modalDC-requestdate" class="col l8 bold">20 November 2012</p>
        </div>

        <div class="clearfix mb5">
          <p class="col l4 pad-l-n">Status</p>
          <p id="modalDC-status" class="col l8 bold">Approved by Fandy Wie on 21 November 2016</p>
        </div>
      </div>

      <div class="bBottom clearfix pad-b-20 pad-t-20">
        <p class="col l4 pad-l-n">Notes</p>
        <div class="col l8 bold">
          <p id="modalDC-reason" class="col l12 mb15 pad-l-n">Bayar kereta ke Bandung pulang pergi</p>
          <p class="col l2"><i class="talenta-peniti-attachment-clip fa-2x"></i></p>
          <div class="col l10 pad-l-7">
            <p>Attachment</p>
            <a id="modalDC-attachment" href="#!" class="linkB01 red1-text text-lowercase">download attachment</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer center-align">
    <input type="hidden" id="reimbursementApproveURL" value="{{route('reimbursement.approve')}}">
    <input type="hidden" id="reimbursementRejectURL" value="{{route('reimbursement.reject')}}">
    <a href="#!" class="approvalButton floatNone btn btnB01 mr5">Approve</a>
    <a href="#!" class="approvalButton floatNone btn btnB01">Reject</a>
  </div>
</div>
