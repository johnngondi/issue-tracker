@component('mail::message')
### Hello, {{ $name }}

{!! $message !!} .

Thanks,<br>
{{ config('app.name') }}
@endcomponent
