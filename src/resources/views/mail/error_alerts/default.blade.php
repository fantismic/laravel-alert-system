@component('mail::message')
# {{ $type }} Alert

{{ $message }}

@isset($details)
@component('mail::panel')
<pre>{{ json_encode($details, JSON_PRETTY_PRINT) }}</pre>
@endcomponent
@endisset

Thanks,<br>
{{ config('app.name') }}
@endcomponent
