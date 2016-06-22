@extends('emails.template')
@section('message')
<!-- HERO IMAGE -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <!-- COPY -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #910111; padding-top: 30px;font-weight: bold" class="padding-copy">Reimbursement Request</td>
                </tr>
                <tr>
                    <td align="center" style="text-align:center;padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy"> <strong>{{$name}}</strong> would like to request reimbursement on this date:<br><br>
                    <strong>Amount: {{$datedesc}}</strong><br><br>
                    <strong>Description:</strong><br>
                    {{$reason}}<br><br>
                    </td>
                </tr>
                <tr>
                	<td style="text-align: center;">
                        @if ($ess_email_setting == 0)
                            <a href="{{route('access.token',['token'=>$code])}}" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #910111; border-top: 15px solid #910111; border-bottom: 15px solid #910111; border-left: 25px solid #910111; border-right: 25px solid #910111; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;" class="mobile-button">
                                View
                            </a>
                        @else
                            <a href="{{route('access.token',['token'=>$code,'status'=>1])}}" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #910111; border-top: 15px solid #910111; border-bottom: 15px solid #910111; border-left: 25px solid #910111; border-right: 25px solid #910111; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;" class="mobile-button">
                                Approve
                            </a>
                            <a href="{{route('access.token',['token'=>$code,'status'=>2])}}" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: #910111; border-top: 15px solid #910111; border-bottom: 15px solid #910111; border-left: 25px solid #910111; border-right: 25px solid #910111; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;" class="mobile-button">
                                Reject
                            </a>
                        @endif
                	</td>
                </tr>
            </table>
        </td>
</table>
@endsection
