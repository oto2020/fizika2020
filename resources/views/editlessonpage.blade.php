@extends('layouts.app')

@section('content')
    <div class="page-content">
        <h1>Редактирование урока " {{$lesson->name}} "</h1>

        <!--Содержимое страницы по ДОБАВЛЕНИЮ СТАТЬИ!-->
        <div class="form-row">
            <form name="test" method="post" action="/edit_lesson.php" class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="user" value="{{$user->name}}">
                <input type="hidden" name="lesson_id" value="{{$lesson->id}}">
                <div class="col-xl-6">
                    <div class="form-group">
                        <b>Название урока:</b>
                        <input value="{{$lesson->name}}" name="lesson_name" id="lesson_name" class="form-control"
                               type="text" size="40">
                    </div>
                    <div class="form-group">
                        <b>URL статьи:</b> <a href="#" onclick="translit('lesson_name', 'uri')">транслитерировать</a>
                        <input value="{{$lesson->uri}}" name="lesson_uri" id="uri" class="form-control" type="text">
                    </div>

                    <div class="form-group">
                        <b>В какой раздел будет добавлена статья:</b>
                        <div class="mt-2"></div>
{{--                        @if(dd($sections)) @endif--}}
                        @foreach($sections as $s)
                            <input type="radio" name="section_id" value="{{$s->id}}" id="s_{{$s->id}}" @if($lesson->section_id == $s->id) checked @endif>
                            <label for="s_{{$s->id}}" class="w-50"> {{$s->name}} </label>
                            <br>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <b>К какой теме относится статья:</b>
                        <br>
                        @foreach($themes as $t)
                            <input type="radio" name="themes_id" value="{{$t->id}}" id="t_{{$t->id}}" @if($lesson->themes_id == $t->id) checked @endif>
                            <label for="t_{{$t->id}}" class="w-50"> {{$t->name}} </label>
                            <br>
                        @endforeach

                    </div>
                    <div class="form-group">
                        <b>Текст превью:</b>
                        <textarea name="lesson_preview_text" class="form-control" cols="40" rows="3">
                            {{$lesson->preview_text}}
                        </textarea>
                    </div>
                </div>
                <div class="form-group col-12">
                    <b>HTML-содержимое самой статьи:<br></b>
                    <a href="/upload_img" target="_blank">Добавить картинку</a>
                    <textarea name="lesson_content" id="html_content" class="form-control">
                        {{$lesson->content}}
                    </textarea>
                </div>
                <div class="form-group col-12">
                    <input type="submit" value="Сохранить" class="btn btn-primary btn-lg btn-block">
                </div>

            </form>


        </div>
        <!-- КОНЕЦ Содержимого страницы!-->


    </div>
@endsection


