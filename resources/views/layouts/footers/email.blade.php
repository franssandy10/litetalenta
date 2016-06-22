
@section('footer')
<!-- FOOTER -->
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 20px 0px;">
            <!-- UNSUBSCRIBE COPY -->
            <table width="500" border="0" cellspacing="0" cellpadding="0" align="center" class="responsive-table">
                <tr>
                    <td align="center" style="font-size: 10px; line-height: 18px; font-family: Helvetica, Arial, sans-serif; color:#666666;">
                        <span class="appleFooter" style="color:#666666;">{{date('Y')}} © {{config('param.company_name')}}  <br> {{config('param.company_address')}}</span><br><a class="original-only" style="color: #666666; text-decoration: none;" href="{{config('app.url')}}">{{config('app.url')}}</a><span class="original-only" style="font-family: Arial, sans-serif; font-size: 12px; color: #444444;">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span><a style="color: #666666; text-decoration: none;font-weigth:bold">THE BEST WAY TO MANAGE YOUR TALENT</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
