@extends('layouts.email')
@include('layouts.headers.email')
@include('layouts.footers.email')
<!-- ONE COLUMN SECTION -->
@section('content')
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-bottom:2px solid rgba(165, 165, 165, 0.2)">
    <tr>
        <td bgcolor="#ffffff" align="center" style="padding: 20px 15px 70px 15px;" class="section-padding">
            <table border="0" cellpadding="0" cellspacing="0" width="500" class="responsive-table">
                <tr>
                    <td>
                        @yield('message')
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
@endsection
