@extends('layouts.app')

@section('content')
    <div class="page-content  pt-4">
        <h1>Редактирование урока " {{$lesson->name}} "</h1>

        <!--Содержимое страницы по ДОБАВЛЕНИЮ СТАТЬИ!-->
        <div class="form-row">
            <form name="test" method="post" action="/edit_lesson.php" class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="lesson_id" value="{{$lesson->id}}">
                <div class="col-xl-6">
                    <div class="form-group">
                        <b>Название урока:</b>
                        <input
                            {{--Если есть ошибка, значит пользователя вернуло на эту страницу и лучше вывести плоды его трудов, чем то, что было до редактирования--}}
                            value="{{Session::has('session_error') ? Session::get('old')['lesson_name'] : $lesson->name}}"
                            name="lesson_name"
                            id="lesson_name"
                            class="form-control"
                            type="text"
                            size="40"
                        >
                    </div>
                    <div class="form-group border rounded pl-2">
                        <b>Адрес урока: </b> <a href="#" onclick="translit('lesson_name', 'uri')">[сгенерировать]</a>
                        <div class="mt-1"></div>
                        <div class="h3">
                            <span class="badge badge-success">{{$school->uri}}</span> /
                            <span class="badge badge-success" id="section_uri">{{$lesson->section_uri}}</span> /
                            <input
                                value="{{Session::has('session_error') ? Session::get('old')['lesson_uri'] : $lesson->uri}}"
                                name="lesson_uri"
                                id="uri"
                                class="form-control"
                                style="display:initial;
                                width: auto"
                                type="text">
                        </div>
                    </div>

                    <div class="form-group border rounded pl-2">
                        <b>В какой раздел будет добавлена статья:</b>
                        <div class="mt-2"></div>
                        {{--                        @if(dd($sections)) @endif--}}
                        @foreach($sections as $s)
                            <input
                                onclick="document.getElementById('section_uri').innerText='{{$s->uri}}'"
                                type="radio"
                                name="section_id"
                                value="{{$s->id}}"
                                id="s_{{$s->id}}"
                                {{--Если была ошибка, значит пользователя вернуло на эту страницу и отмечаем тот пункт, который был выбран до ошибки--}}
                                @if(Session::has('session_error'))
                                    @if ($s->id == Session::get('old')['section_id']) checked @endif
                                    {{--Если ошибки не было, то отмечаем пункт, который был изначально до редактирования--}}
                                @else
                                    @if ($s->id == $lesson->section_id) checked @endif
                                @endif
                            >
                            <label for="s_{{$s->id}}" class="w-50"> {{$s->name}} </label>
                            <br>
                        @endforeach
                    </div>
                    <div class="form-group border rounded pl-2">
                        <b>К какой теме относится статья:</b>
                        <div class="mt-2"></div>
                        @foreach($themes as $t)
                            <input
                                type="radio"
                                name="themes_id"
                                value="{{$t->id}}"
                                id="t_{{$t->id}}"
                                {{--Если была ошибка, значит пользователя вернуло на эту страницу и отмечаем тот пункт, который был выбран до ошибки--}}
                                @if(Session::has('session_error'))
                                    @if ($t->id == Session::get('old')['themes_id']) checked @endif
                                    {{--Если ошибки не было, то отмечаем пункт, который был изначально до редактирования--}}
                                @else
                                    @if ($t->id == $lesson->themes_id) checked @endif
                                @endif
                            >
                            <label for="t_{{$t->id}}" class="w-50"> {{$t->name}} </label>
                            <br>
                        @endforeach

                    </div>
                    <div class="form-group">
                        <b>Текст превью:</b>
                        <textarea
                            name="lesson_preview_text"
                            class="form-control"
                            cols="40"
                            rows="3">{{Session::has('session_error') ? Session::get('old')['lesson_preview_text'] : $lesson->preview_text}}
                        </textarea>
                    </div>
                </div>
                <div class="form-group col-12">
                    <b>HTML-содержимое самой статьи:<br></b>
                    <a href="/img_upload" target="_blank">Добавить картинку</a>
                    <textarea
                        name="lesson_content"
                        id="html_content"
                        class="form-control">{{Session::has('session_error') ? Session::get('old')['lesson_content'] : $lesson->content}}
                    </textarea>
                </div>
                <div class="form-group col-12">
                    <input type="submit" value="Сохранить" class="btn btn-success btn-lg btn-block">
                </div>

            </form>


        </div>
        <!-- КОНЕЦ Содержимого страницы!-->


    </div>
@endsection


