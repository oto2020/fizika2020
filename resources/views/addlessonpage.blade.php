@extends('layouts.app')

@section('content')
    <div class="page-content">
        <h1>Добавление урока</h1>

        <!--Содержимое страницы по ДОБАВЛЕНИЮ СТАТЬИ!-->
        <div class="form-row">
            <form name="test" method="post" action="/add_lesson.php" class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="author_id" value="{{$user->id}}">
                <div class="col-xl-6">
                    <div class="form-group">
                        <b>Название урока:</b>
                        <input
                            name="lesson_name"
                            id="lesson_name"
                            class="form-control"
                            type="text"
                            size="40"
                            value="{{Session::get('old')['lesson_name']}}"
                        >
                    </div>
                    <div class="form-group border rounded pl-2">
                        <b>Адрес урока: </b> <a href="#" onclick="translit('lesson_name', 'uri')">[сгенерировать]</a>
                        <div class="mt-1"></div>
                        <div class="h3">
                            <span class="badge badge-success">{{$school->uri}}</span> /
                            <span class="badge badge-success" id="section_uri">{{$sections[0]->uri}}</span> /
                            <input
                                value="{{Session::get('old')['lesson_uri']}}"
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
                        @foreach($sections as $s)
                            <input
                                onclick="document.getElementById('section_uri').innerText='{{$s->uri}}'"
                                type="radio"
                                name="section_id"
                                value="{{$s->id}}"
                                id="s_{{$s->id}}"
                                @if (Session::get('old')['section_id'] == $s->id) checked @endif
                                {{--checked, если юзер выбирал ранее этот пункт и записывал в сессию в начале метода LessonController@addLessonPOST--}}
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
                                {{--checked, если юзер выбирал ранее этот пункт и записывал в сессию в начале метода LessonController@addLessonPOST--}}
                                @if (Session::get('old')['themes_id'] == $t->id) checked @endif
                            >
                            <label for="t_{{$t->id}}" class="w-50"> {{$t->name}} </label>
                            <br>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <b>Текст превью:</b>
                        <textarea name="lesson_preview_text" class="form-control" cols="40"
                            rows="3">{{Session::get('old')['lesson_preview_text']}}</textarea>
                    </div>
                </div>
                <div class="form-group col-12">
                    <b>HTML-содержимое самой статьи:<br></b>
                    <a href="/img_upload" target="_blank">Добавить картинку</a>
                    <textarea name="lesson_content" id="html_content"
                              class="form-control">{{Session::get('old')['lesson_content']}}</textarea>
                </div>
                <div class="form-group col-12">
                    <input type="submit" value="Сохранить" class="btn btn-success btn-lg btn-block">
                </div>

            </form>


        </div>
        <!-- КОНЕЦ Содержимого страницы!-->


    </div>
@endsection


