@extends('emails.template')
@section('message')
<!-- HERO IMAGE -->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <!-- COPY -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #910111; padding-top: 30px;font-weight: bold" class="padding-copy">Reimbursement Request {{$var[2]}}</td>
                </tr>
                <tr>
                    <td align="center" style="text-align:center;padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">
                            {{$receiver}}, Your Reimbursement Request for<br>
                            <strong>{{$var[0]}}</strong><br><br>
                            has been <strong>{{$var[2]}}</strong>.<br>
                    </td>
                </tr>
                <tr style="box-sizing:border-box; background-color:#e0e0e0; margin:10px;padding:20px; text-align:center; font-size:15px; font-family:'lato-italic';">
                    <td>
                      <p style="font-weight:bolder"><br>{{$var[3]}}<br></p>
                      <p style="line-height:1.4"></p>
                    </td>
                </tr>
            </table>
        </td>
</table>
@endsection
