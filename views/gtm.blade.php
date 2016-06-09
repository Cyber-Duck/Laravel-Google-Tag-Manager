@inject('gtm', 'GTM')

@if (Auth::check())
    {{ $gtm->data('UserID', Auth::user()->id) }}
@endif

{!! $gtm->code() !!}