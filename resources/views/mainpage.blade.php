@extends('layouts.app')

@section('content')
    <div >
        <h1>{{$school->name}}, главная страница</h1>
        @if($user!=null)
            <p>Здравствуйте, {{$user->name}}, вы находитесь на обучающем портале, посвящённому школьному курсу физики.</p>
            @if($role->level == 100)
                <p>Вы являетесь <b>Администратором сайта</b>, вам доступно всё и немного больше.</p>
            @elseif ($role->level == 60)
                <p>Вы являетесь <b>Учителем и администратором</b> всего того, что относится в Вашей школе. Наслаждайтесь властью над учениками и коллегами.</p>
            @elseif ($role->level == 40)
                <p>Вы являетесь <b>Учеником</b> {{$class->name}} класса. Учитесь хорошо!</p>
            @elseif ($role->level == 20)
                <p>Вы являетесь Непризнанным ни одной школой учеником (анонимом), однако это не всегда плохо. Вам доступны все учебные ресурсы базового курса. Учитесь хорошо!</p>
            @endif
        @else
            <span class="alert-danger md-4">Для прохождения курсов пожалуйста, войдите или зарегистрируйтесь</span>
            <br>
            <br>
        @endif
        @if ($user!==null && $role->level >= 60)
            <a href="/{{$school->uri}}/edit_main_page">
                [редактировать]
            </a>
            <br>
        @endif
        {!!$school->content!!}
        <br>
        <p>Выбирайте интересующий вас урок исходя из школьной программы или интересующего раздела физики:</p>
        <div class="row">
            <div class="col-4">
                <ul class="list-group">
                    @foreach($sections as $section)
                        <li class="list-group-item">{{$section->name}}</li>
                    @endforeach
                </ul>
            </div>
            <div class="col-4">
                <ul class="list-group">
                    @foreach($themes as $theme)
                        <li class="list-group-item">{{$theme->name}}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
