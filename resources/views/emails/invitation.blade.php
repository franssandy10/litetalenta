@extends('layouts.email')
@include('layouts.headers.email')
@include('layouts.footers.email')
<!-- ONE COLUMN SECTION -->
@section('content')
<!-- ONE COLUMN SECTION -->
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom:2px solid rgba(165, 165, 165, 0.2)">
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 20px 15px 70px 15px;" class="section-padding">
            <table border="0" cellpadding="0" cellspacing="0" width="500" class="responsive-table">
                <tr>
                    <td>
                        <!-- HERO IMAGE -->
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
                                    <!-- COPY -->
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td align="center" style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #910111; padding-top: 30px;font-weight: bold" class="padding-copy">{{$user['user_company']['name']}} has started using Talenta</td>
                                        </tr>
                                        <tr>
                                            <td align="center" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">The administrator, <strong>{{$user['admin']['name']}}</strong> has invited you to join. <br><br>
                                            Your sign in email is: <br>
                                            <a style="color:#910111"><strong><u>{{$user['email']}}</u></strong></a><br><br>
                                            Once you’ve activated your account, you can sign in at <strong><u>{{config('app.url')}}</u></strong>
                                            </td>
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
                                                        <td align="center"><a href="{{route('resetpassword',['id'=>$code])}}" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #910111; border-top: 15px solid #910111; border-bottom: 15px solid #910111; border-left: 25px solid #910111; border-right: 25px solid #910111; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;" class="mobile-button">Activate Your Account &rarr;</a></td>
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
                                            <td align="center" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">If that button won't works, copy paste this links to your browser:<br/>  <a style="color:blue">{{route('resetpassword',['id'=>$code])}}</a></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                            	<td align="center" style="padding: 20px 0 0 0; font-size: 10px; line-height: normal; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                            		Talenta is a HR management software that will help simplify your company’s HR processes. You can view your attendance record, request and track your time-off & overtime, view and download your payroll slip, and more. Find out more: <strong><u><a href="{{config('app.url')}}">{{config('app.url')}}</a></u></strong>
        							<br><br>
        							If you have any feedback for us, please get in touch with us through <a class="linkred4"><strong>support@talenta.co</strong>
                            	</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
