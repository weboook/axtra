@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel' || trim($slot) === 'Axtra')
<img src="{{ asset('images/brand/axtra-full-dark.png') }}" class="logo" alt="Axtra Logo" style="height: 50px; max-width: 200px; object-fit: contain;">
@else
{!! $slot !!}
@endif
</a>
</td>
</tr>
