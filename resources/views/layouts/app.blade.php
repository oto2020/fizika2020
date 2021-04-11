<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>
        @if(isset($title))
            {{ $title }}
        @else
            Обучающий портал по физике
        @endif
    </title>

    <!-- Icon -->
    <link rel="icon" href="/storage/img/main/favicon.ico" type="image/x-icon">


{{--    <!-- Fonts -->--}}
{{--    <link rel="dns-prefetch" href="//fonts.gstatic.com">--}}
{{--    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">--}}

<!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

{{--    TODO: добавить условие на calc--}}
    <script src="/js/myPolishNotation.js"></script>
    <script src="/js/myReverseFunction.js"></script>
{{--    <link href="{{ asset('/css/bootstrap.css') }}" rel="stylesheet">--}}
{{--    <link href="{{ asset('/css/main.css')}}" rel="stylesheet" type="text/css">--}}

<!-- Katex -->
    {{--    <link href="/katex/katex.css" rel="stylesheet" type="text/css"/>--}}
    {{--    <script src="/katex/katex.js" type="text/javascript"></script>--}}

    {{--    <script>--}}
    {{--        // при загрузке изображения со стороннего ресурса -- включается в работу katex. Нужно лишь навесить событие и в качестве обработчика указать этот метод--}}
    {{--        function onLoadLatexImg(img) {--}}
    {{--            // формируем динамически новый div--}}
    {{--            var newDiv = document.createElement('div');--}}
    {{--            // katex берет latex-код из img.alt и формирует наш новый div--}}
    {{--            katex.render(img.alt, newDiv);--}}
    {{--            // заменим img на div--}}
    {{--            img.parentElement.replaceChild(newDiv, img);--}}
    {{--        }--}}
    {{--    </script>--}}
</head>


<body>

<div class="wrapper">
    <div class="container" id="app">
        @include('layouts.messages.message')

        <top_menu
            :sections='@json(isset($sections)?$sections:null)'
            :school='@json(isset($school)?$school:null)'
            :user='@json(isset($user)?$user:null)'
            :role='@json(isset($role)?$role:null)'
            login-route="{{route('login')}}"
            register-route="{{route('register')}}"
            logout-route="{{route('logout')}}"
        ></top_menu>

        <main>
            @yield('content')
        </main>


    </div>
    <div class="push"></div>
</div>

<div class="footer">КФУ им. В.И. Вернадского, Симферополь, 2020</div>
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>


