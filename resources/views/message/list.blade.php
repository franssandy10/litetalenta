@extends('message.messagelayout')
@section('msgcontent')
        <!-- tab-content -->
        <div class="col l9 m12 s12 white pad-l-n">
            <div id="inbox" class="col l12 m12 s12 pad-20 tab-content">
            <!-- Search Bar -->
                <div class="row bBottom">
                    <div>
                        <div id="checkregion" class="col input-field l3 s6 mtm15 bRight lineHeight35px pad-b-20">
                            <input type="checkbox" class="filled-in" id="checkAllInbox">
                            <label  id="checkAllInboxLabel" class="dropdown-button displayInlineBlock" data-constrainwidth="false" data-activates="dropdownInbox" data-beloworigin="true" data-toggle="true">
                                <span class="lineHeight20px valign-middle">Select</span>
                                <i class="mdi-navigation-arrow-drop-down f20 hide-on-small-and-down"></i>
                            </label>
                            <ul id="dropdownInbox" class="dropdown-content mt20">
                                <li><a id="selectAll" href="#!">Select All</a></li>
                                <li><a id="selectUnread" href="#!" value="admin">Select Unread</a></li>
                                <li><a id="selectRead" href="#!" value="user">Select Read</a></li>
                                <li><a id="unselectAll" href="#!" value="user">Unselect All</a></li>
                            </ul>
                        </div>
                        <div class="col l2 s6 input-field bRight lineHeight35px pad-b-10 mtm15">
                            <a href="#!" class="black-text mt10 displayBlock center-align" id="deleteInboxSelected">
                                <i class="fa fa-times displayInline mr5"></i>
                                <span class="mtm10">Delete</span>
                            </a>
                        </div>
                    </div>

            <!-- Search -->
                    <div class="row mb0">
                        <div class="col l3 s12 input-field right-align right mt0 searchMessageDiv mb10">
                            <input type="search" id="searchMessage" placeholder="Search"> 
                        </div>
                    </div>
                </div>
            <!-- /Search -->
            <!-- /Search Bar -->

                <div class="row" id="forAjax">
                    <form>
                        <ul id="MessageContainer" class="collection"> </ul>
                    </form>
                </div>
            </div>
        </div>
@stop
