<!-- Modal Detail Claim -->
<div id="modalDetailPolicy" class="modal modal-fixed-footer modal1">
  <div class="modal-content">
      <a href="#!" class="modal-action modal-close grey-text closeModal"><i class="fa fa-times"></i></a>
      <div class="row">
          <p class="titleB01">Policy Detail</p>
          <p class="f18 grey-text text-darken-3 lato-bold"></p>
      </div>
      <div class="row">
          <input type='hidden' id='modalDP-id' value=''>
          <div class="bBottom pad-b-20">
              <div class="clearfix mb5">
                  <p class="col l4 pad-l-n">Policy Name</p>
                  <p class="col l8 bold" id="name">testing</p>
              </div>
              <div class="clearfix mb5 displayNone" id="unlimited">
                  <p class="col l4 pad-l-n">Unlimited</p>
              </div>
              <div class="displayNone" id="withlimit">
                  <div class="clearfix mb5">
                      <p class="col l4 pad-l-n">Limit</p>
                      <p class="col l8 bold" id="limit"></p>
                  </div>
                  <div class="clearfix mb5">
                      <p class="col l4 pad-l-n">Type</p>
                      <p class="col l8 bold" id="limit_type"></p>
                  </div>
              </div>
              <div class="clearfix mb5 ">
                  <p class="col l4 pad-l-n">Effective Date</p>
                  <p class="col l8 bold" id="effective_date"></p>
              </div>
              <div class="clearfix mb5 ">
                  <p class="col l4 pad-l-n">Expired Date</p>
                  <p class="col l8 bold" id="deleted_at"></p>
              </div>
          </div>
      </div>
  </div>
  <div class="modal-footer center-align">
      <a id="buttonDeleteReimbursement" href="#modalDeleteReimbursement" class="modal-trigger floatNone btn btnB01 mr5">Expire</a>
  </div>
</div>

