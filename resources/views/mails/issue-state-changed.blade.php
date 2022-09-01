@component('mail::message')
### Hello, {{ $name }}

{!! $message !!}.

{!! $message2 ?? '' !!}.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
