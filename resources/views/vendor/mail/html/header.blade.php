<tr>
    <td align="center" style="background-color:#fff;"> <img src="{{asset('images/logo.png')}}" width="180px" height="50px" alt=""></td>
</tr>
<tr>
    <td style="height:20px;background-color:#fff;"></td>
</tr>
<tr>
<td class="header" style="background-color:#3bba9c;">
<a href="{{ $url }}" style="display: block;color:#fff;font-size:28px;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
