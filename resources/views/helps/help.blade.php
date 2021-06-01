@extends('layouts.app')

@section('content')
<div class="info-container">
    <h2>More information</h2>
    <hr>
    <div class="policy-container">
        <div class="info-question">
            <h5>Do you want to know more about the privacy policy?</h5>
            <a class="" href="{{ route('privacy') }}"> Privacy policy</a>
        </div>

    </div>
    <div class="policy-container">
        <div class="info-question">
            <h5>Do you want to know more about cookies?</h5>
            <a class="" href="{{ route('cookies') }}">Cookies</a>
        </div>
    </div>
</div>
@endsection

@extends('layouts.footer')