@extends('layouts.app')

@section('content')
<div class="container">
    <div class="">
        <h1>Cookies</h1>
        <p>A cookie refers to a file that is sent in order to request permission to be stored on your computer
            , by accepting said file it is created and the cookie then serves to have information regarding web traffic,
            and also facilitates
            future visits to a web recurrent. Another function that cookies have is that with them the web can recognize
            you individually
            and therefore provide you with the best personalized service on its web.
            You can accept or deny the use of cookies, however most browsers automatically accept cookies as it serves
            to have a better web service.
            You can also change your computer settings to decline cookies. If they are declined, you may not be able to
            use some of our services.
           </p>
        <p>Tembi reserves the right to change the terms of this Privacy Policy at any time.</p>
        <p>For more information about the data we use: <a href="{{ route('privacy') }}"> Privacy policy</a></p>
    </div>

</div>
@endsection

@extends('layouts.footer')