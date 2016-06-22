@extends('emails.template')
@section('message')
<!-- HERO IMAGE -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <!-- COPY -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #910111; padding-top: 30px;font-weight: bold" class="padding-copy">{{$receiver}}, you have a new message !</td>
                </tr>
                <tr>
                    <td align="center" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">{{$sender}} has sent you a message. <br/>  To read your message, click the button below:</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center">
            <!-- BULLETPROOF BUTTON -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-button-container">
                <tr>
                    <td align="center" style="padding: 25px 0 0 0;" class="padding-copy">
                        <table border="0" cellspacing="0" cellpadding="0" class="responsive-table">
                            <tr>
                                <td align="center"><a href="{{route('readfromemail', ['hashString' => $code])}}" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #910111; border-top: 15px solid #910111; border-bottom: 15px solid #910111; border-left: 25px solid #910111; border-right: 25px solid #910111; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;" class="mobile-button">VIEW MESSAGE</a></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>
            <!-- COPY 2 -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">If that button won't works, copy paste this links to your browser:<br/>  <a style="color:blue; font-size:12px;">{{route('readfromemail', ['hashString' => $code])}}</a></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
