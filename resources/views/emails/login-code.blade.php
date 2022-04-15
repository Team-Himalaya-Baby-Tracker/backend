@component('mail::message')
# Your Login code is:
## {{$code}}
Use it to reset your code.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
