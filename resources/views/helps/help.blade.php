@extends('layouts.app')

@section('content')
<h2>More information</h2>
<h5>Do you want to know more about the privacy policy?</h5>
<a class="" href="{{ route('privacy') }}"> Privacy policy</a>
<h5>Do you want to know more about cookies?</h5>
<a class="" href="{{ route('cookies') }}">Cookies</a>


@endsection

@extends('layouts.footer')
