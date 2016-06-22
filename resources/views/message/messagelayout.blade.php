@extends('layouts.app')

@section('navbar')
  <!-- This is the position navbar. -->
  @include('layouts.navbars.logged-in')
 @stop

@section('css')
    @include('layouts.css') 
    {!! Html::style('assets/css/inboxStyle.css')!!}
    {!! Html::style('assets/plugins/magicsuggest/magicsuggest-min.css')!!}
@stop

@section('content')
<!-- Message -->
<div class="container">
    <div class="row mt50 mb30">
        <div class="col l9 m7 s12">
            <h1 class="titleB01 center-align-down">Messages</h1>
        </div>
        <div class="col l3 m5 s12 center-align-down right-align-med right-align-large">
            <!-- New Message Trigger -->
            <a id="buttonNewMessage" href="#modalNewMessage" class="btn btnB01 modal-trigger">
                <i class="fa fa-edit left mr5 mtm3"></i>
                NEW MESSAGE
            </a> <!-- --------- LINK -------- -->
        </div>
    </div>


<!-- -------------------------- dialog modal --------------------- -->
      <div id="deleteDialog" class="modal modal-confirm modal-fixed-footer">
          <div class="modal-content">
            <h4 class="titleB01">Delete</h4>
            <p>Are you sure you want to delete this message(s)?</p>
          </div>
          <div class="modal-footer">
            <a href="#!" class=" modal-action modal-close btn btnB01">Cancel</a>
            <a id='deleteDialogButton' href="#!" class="btn btnB01">Delete</a>
          </div>
      </div>
<!-- -------------------------- /dialog modal --------------------- -->

<!-- ----------------- MODAL: READ MESSAGE -------------- -->
      <div id="messageModal" class="modal col l9 white pad-l-n">
          <a href="#!" class="modal-action modal-close grey-text closeModal"><i class="fa fa-times"></i></a>
          <!-- Content -->
        <div id="inbox" class="modal-content col l12 pad-20">
          <div class="row">
              <!-- Colom atas -->
              <div class="row bBottom pad-b-10">
                <div class="col l2 hide-on-med-and-down w90">
                  <img id="inboxImage" src="https://talenta.co/uploads/avatar/blank.jpg" class="circle inboxImage" width="64" alt="">
                </div>
                <div class="col l5 m5 s12">
                  <p id="readName" class="lato-regular black-text f22 mt0 mb0 truncate center-align-down"></p>
                  <p id="readSubject" class="ls2 f13 text-uppercase lato-black bold mt10 mb0 red1-text truncate center-align-down"></p>
                </div>
                <div class="col l5 m7 right s12 right-align center-align-down">
                  <p id="readButtonArea" class="mb0 mt0 mt30-small">
                    <a id="readReplyButton"  class="btn btnB01 mr5"><i class="fa fa-reply left mtm3"></i> <span class="left">Reply</span></a>
                    <a id="readDeleteButton" class="btn btnB01"><i class="fa fa-trash left mr5 mtm3"></i><span class="left">Delete</span></a>
                  </p>
                  <p id="readTime" class="italic mt10 mb0"></p>
                </div>
              </div>
              <!-- /Colom atas -->
              <div class="col l12 m12 s12 pad-20">
                <p id='messageContent' class="lato-italic"></p>
              </div>
          <!-- reply  -->
          <form>
              <input id="readid" type="hidden" value="">
              <input type="hidden" name="_csrf" value="VGhVdHNrSFcRLQwwChoyei4dBzgDAzIvMBgNEQoceCEABAYeFAcsJA==">
              <input id="readSenderID" name="receiver_id_fk" type="hidden" value="">
              <input id="readReplySubject" name="subject" type="hidden" value="">
              <div id="replyPopup" style="display:none" class="row pad-10 mb0">
              <div class="row bBottom">
              </div>
                <div class="col l2">
                  <p class="f13 grey-text ls2 text-uppercase bold">Reply</p>
                </div>
                <div class="col l10">
                  <div class="form-group field-inbox-message required">
                        <textarea id="inbox-message" class="form-control" name="message" rows="6" style="resize:none;overflow:auto;"></textarea>
                        <a href="#!" class="btn btnB01 right mr5" id="sendMessage">Send</a>
                        <div class="help-block"></div>
                  </div>           
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit. 

                  Quidem dignissimos voluptate voluptatibus nostrum, ex doloremque magni placeat eos. 

                  Culpa, facilis. 
                </div>
            </div>
          </form>
          <!-- /reply -->
          </div>
        </div>
      </div>
<!-- ----------------- /END OF MODAL: READ MESSAGE -------------- -->

 <!-- Modal Trigger -->
 <!--  <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Modal</a> -->

  <!-- Modal Structure : New Message -->
      <div id="modalNewMessage" class="modal maxHeightNone modal-fixed-footer" style="z-index: 1005; opacity: 1; transform: scaleX(1); top: 10%;">
          <div class="modal-content">
              <h4 class="titleB01">New Message</h4>

              <form id="w0" class="form-vertical" action="" method="post">
                  <input type="hidden" name="_csrf" value="VGhVdHNrSFcRLQwwChoyei4dBzgDAzIvMBgNEQoceCEABAYeFAcsJA==">
                  <!-- tab-content -->
                  <div class="col l12 white pad-l-n">
                      <div id="inbox" class="col l12">
                          <div class="row bBottom pad-20 pad-l-n mb0">
                              <div class="col l2">
                                  <p class="f13 ls2 text-uppercase bold">Recipient</p>
                              </div>
                              <div class="col l10">
                                <div class="form-group field-inbox-recipient required">
                                  <input id="inbox-recipient" class="form-control" name="receiver_id_fk">
                                </div>  
                              </div>
                          </div>

                          <div class="row bBottom pad-20 pad-l-n mb0">
                              <div class="col l2">
                                  <p class="f13 ls2 text-uppercase bold">subject</p>
                              </div>
                              <div class="col l10">
                                  <div class="form-group field-inbox-subject required">
                                      <input type="text" id="inbox-subject" class="form-control pull-left w95p" name="subject" maxlength="100">
                                      <div class="help-block"></div>
                                  </div>
                              </div>
                          </div>

                          <div class="row pad-20 pad-l-n mb0">
                              <div class="col l2">
                                  <p class="f13 ls2 text-uppercase bold">message</p>
                              </div>
                              <div class="col l10">
                                  <div class="form-group field-inbox-message required">
                                      <textarea id="inbox-message" class="form-control" name="message" rows="9" style="resize:none;overflow:auto;"></textarea>
                                      <div class="help-block"></div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div><!-- tab-content -->
              </form>
          <input type="hidden" id="getListRecipientURL" value="{{route('getmessagerecipient')}}">
          <input type="hidden" id="avatarPictureURL" value="http://talenta.co/uploads/">
          <input type="hidden" id="urlSubmit" value="{{route('sendmessage')}}">  
      </div>
      <div class="modal-footer">
          <a href="#!" class="btn btnB01 right modal-action modal-close">Cancel</a>
          <a href="#!" class="btn btnB01 right mr5" id="sendMessage">Send</a>
      </div>
  </div>

  <!-- /Modal Structure : New Message -->
  

    <!-- tab INBOX | SENT item -->
    <div class="row h-tabRow ml0 mr0">
          <input type="hidden" id="tabmessagenotifURL" value="{{route('countmessagenotif')}}" >
          <input type="hidden" id="tabInboxURL" value="{{route('loadmessages')}}" >
          <input type="hidden" id="readMessageURL" value="{{route('readmessage')}}" >
          <input type="hidden" id="deleteInboxURL" value="{{route('deletemessage')}}">
          <input type="hidden" id="triggerOpen" value="{{ $triggerOpen or 'none' }}">
          <input type="hidden" id="approveRequestURL" value="{{route('approverequest')}}">
          <input type="hidden" id="rejectRequestURL" value="{{route('rejectrequest')}}">
          <div class="col l3 s12 pad-r-n pad-l-n">
            <ul class="tabs tab-horizontal unbindClick" style="width: 100%;">
              <li id="1" class="messagebox tab col hide-on-small-only" style="width: 10%;">
                <a class="active">
                  <i class="fa fa-inbox fa-2x valign-middle displayInlineBlock w25"></i>
                  Inbox
                  <span class="new badge lato-bold mtm3 bgRed1 hide-on-med-and-down displayNone">0</span> <!-- notif -->
                </a>
              </li>
              <li id="2" class="messagebox tab col hide-on-small-only" style="width: 10%;">
                <a>
                  <i class="talenta-kalender-8 fa-2x displayInlineBlock w25"></i>
                  Time Off
                  <span  class="new badge lato-bold mtm3 bgRed1 displayNone">0</span>
                </a>
              </li>
              <li id="3" class="messagebox tab col hide-on-small-only" style="width: 10%;">
                <a>
                  <i class="talenta-reimbursement fa-2x displayInlineBlock w25"></i>
                  Reimbursement
                  <span  class="new badge lato-bold mtm3 bgRed1 displayNone">0</span>
                </a>
              </li>
              <li id="0" class="messagebox tab col hide-on-small-only" style="width: 10%;">
                <a>
                  <i class="fa fa-upload displayInlineBlock valign-middle fa-2x w25"></i>
                  Sent Item
                </a>
              </li>
              <div class="indicator" style="right: 0px; left: 0px;"></div>

            </ul>
            <div class="row hide-on-med-and-up">
              <div class="col s12 input-field">
                <select id="selectMessage" class="browser-default default3">
                  <option value="1">Inbox</option>
                  <option value="2">Time Off</option>
                  <option value="3">Reimbursement</option>
                  <option value="0">Sent Item</option>
                </select>
              </div>
            </div>
          </div>

            <!-- Dropdown Trigger -->

    <!-- /tab INBOX | SENT item -->
    @yield('msgcontent')
    </div>
</div>

@stop

@section('customjs')
  {!! Html::script('assets/plugins/magicsuggest/magicsuggest.js')!!}
  {!! Html::script('assets/js/scriptInbox.js')!!} 
@stop