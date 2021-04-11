<div name = "layouts.messages.message" id="layouts.messages.message" style="margin-top:3px; margin-bottom:3px">

    @if(Session::has('message'))
        <p class="alert alert-info">
            {{ Session::get('message') }}
        </p>
    @endif

    @if(Session::has('messages'))
        @foreach (Session::get('messages') as $message)
                <p class="alert alert-info">
                    {{$message}}
                </p>
        @endforeach
    @endif


    @if(Session::get('session_error'))
        <p class="alert alert-danger">
            {{ Session::get('session_error') }}
        </p>
    @endif

    @if(Session::has('session_errors'))
        @foreach (Session::get('session_errors') as $error)
            <p class="alert alert-danger">
                {{$error}}
            </p>
        @endforeach
    @endif
</div>
