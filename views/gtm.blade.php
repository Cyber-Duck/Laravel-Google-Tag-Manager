@if (Auth::check())
    {{ $GTM->data('UserID', Auth::user()->id) }}
@endif
{!! $GTM->code() !!}