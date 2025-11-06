@props(['url'])
<tr>
<td class="header">
<a href="https://byjus.com" style="display: inline-block;">
@if(trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
{{--{{ $slot }}--}}
<img src="https://resource.moreideas.ae/prodemailtrackr/public/images/byjus_logo_xxx.png">
@endif
</a>
</td>
</tr>
