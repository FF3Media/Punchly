<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Punchly.io')
<img src="{{asset('backend-images/sidebar-logo.png')}}" class="logo"> 
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
