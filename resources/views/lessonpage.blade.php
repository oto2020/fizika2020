@extends('layouts.app', ['title'=>$lesson->name])

@section('content')
    <!--ВСЁ, ЧТО ПОСЛЕ ВЕРХНЕГО МЕНЮ!-->
    <div class="row">
        <!-- ЛЕВОЕ МЕНЮ !-->
        <div class="col-xs-12 col-sm-2">
            @include('layouts.left.auth')
            @include('layouts.left.menu')
        </div>
        <!-- КОНЕЦ ЛЕВОГО МЕНЮ!-->

        <!--Содержимое страницы!-->
        <div class="col-xs-12 col-sm-10 pt-4">
            <h1>{{ $lesson->name }}</h1>
            @if ($user !== null && $role->level >= 60)
                <a href="/{{ $school->uri }}/{{ $section->uri }}/{{ $lesson->uri }}/edit_lesson">
                    [редактировать]
                </a>
                <a href="/{{ $school->uri }}/{{ $section->uri }}/{{ $lesson->uri }}/mark_as_deleted"
                    onclick="return confirm ('Внимание: перед удалением урока необходимо удалить все его тесты! Отправляем урок в удалённые?')">
                    [не отображать на сайте]
                </a>
                <br>
            @endif
            <!-- КОНТЕНТ СТРАНИЦЫ ИБ БД!-->
            <div id="onlyLessonPageContentCSS">
                {!! $lesson->content !!}
            </div>
            <hr>

            {{-- TODO:разработать страницу темы --}}
            Раздел физики:
            <a class="alert-light" href="/themes/{{ $lesson->themes_uri }}">
                <h5>
                    {{ $lesson->themes_name }}
                </h5>
            </a>

            <h6>
                @if (isset($lesson->updated_at))
                    Дата обновления урока: {{ explode(' ', $lesson->updated_at)[0] }}
                @else
                    Дата добавления урока: {{ explode(' ', $lesson->created_at)[0] }}
                @endif
                | Автор урока: {{ $lesson->author_name }}
            </h6>


            <!-- Тесты !-->
            @if ($user !== null && $role->level >= 20)
                @if (isset($tests))
                    <p>
                        <hr />
                    <h1>Тесты по уроку:</h1>
                    <ul class="list-group">
                        @foreach ($tests as $test)
                            <li class="list-group-item">
                                <a
                                    href="/{{ $school->uri }}/{{ $section->uri }}/{{ $lesson->uri }}/{{ $test->uri }}">
                                    {{ $test->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                    </p>
                @else
                    <h2>Тесты по уроку отсутсвуют</h2>
                @endif
            @endif
            @if ($role !== null && $role->level >= 60)
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="/{{ $school->uri }}/{{ $section->uri }}/{{ $lesson->uri }}/add_test">[добавить
                            тест]</a>
                    </li>
                </ul>
            @endif
            <!-- Тесты !-->

            <hr>
            <h3>
                Комментарии к уроку:
            </h3>
            <br>
            @foreach ($comments as $comment)
                <div class="media-block">
                    <div class="media-left">
                        <img class="img-circle img-sm" src="{{ $comment->avatar_src }}"
                            onerror="this.src = '/storage/img/avatars/default_avatar.png'">
                    </div>
                    <div class="media-body">
                        <div class="text-12pt text-color-black">
                            {{ $comment->user_name }}
                        </div>
                        <div class="text-8pt text-color-grey">
                            {{ $comment->created_at }}
                        </div>
                        <div class="">
                            {{ $comment->content }}
                        </div>
                        <hr>
                    </div>
                </div>
            @endforeach
            @if ($user !== null && $role->level > 20)
                <div class="col-md-12">
                    <div class="panel">
                        <div style="width:100%">
                            <form method="post" action="/add_comment.php">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <input type="hidden" name="lesson_id" value="{{ $lesson->id }}">
                                <input name="content" type="text" class="form-control"
                                    placeholder="Добавьте Ваш комментарий">

                                <div class="mar-top clearfix">
                                    <button class="btn btn-sm btn-outline-dark" type="submit"
                                        style="width:160px; float:right; margin-top:10px"> Добавить
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            @else
                <div class="alert alert-warning" role="alert">
                    Только зарегистрированные пользователи могут писать комментарии.
                </div>
            @endif
            <br>
            <br>
        </div>
        <!-- КОНЕЦ Содержимого страницы!-->
    </div>

@endsection
