@extends('layouts.app')

@section('content')
    <div class="page-content">
        <h1>Добавление урока в раздел " {{$section->name}} "</h1>

        <!--Содержимое страницы по ДОБАВЛЕНИЮ СТАТЬИ!-->
        <div class="form-row">
            <form name="test" method="post" action="/add_lesson.php" class="row">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="author_id" value="{{$user->id}}">
                <div class="col-xl-6">
                    <div class="form-group">
                        <b>Название урока:</b>
                        <input name="lesson_name" id="lesson_name" class="form-control"
                               type="text" size="40">
                    </div>
                    <div class="form-group">
                        <b>URL статьи:</b> <a href="#" onclick="translit('lesson_name', 'uri')">транслитерировать</a>
                        <input name="lesson_uri" id="uri" class="form-control" type="text">
                    </div>

                    <div class="form-group">
                        <b>В какой раздел будет добавлена статья:</b>
                        <div class="mt-2"></div>
                        {{--                        @if(dd($sections)) @endif--}}
                        @foreach($sections as $s)
                            <input type="radio" name="section_id" value="{{$s->id}}" id="s_{{$s->id}}">
                            <label for="s_{{$s->id}}" class="w-50"> {{$s->name}} </label>
                            <br>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <b>К какой теме относится статья:</b>
                        <div class="mt-2"></div>
                        @foreach($themes as $t)
                            <input type="radio" name="themes_id" value="{{$t->id}}" id="t_{{$t->id}}">
                            <label for="t_{{$t->id}}" class="w-50"> {{$t->name}} </label>
                            <br>
                        @endforeach

                    </div>
                    <div class="form-group">
                        <b>Текст превью:</b>
                        <textarea name="lesson_preview_text" class="form-control" cols="40" rows="3"></textarea>
                    </div>
                </div>
                <div class="form-group col-12">
                    <b>HTML-содержимое самой статьи:<br></b>
                    <a href="/img_upload" target="_blank">Добавить картинку</a>
                    <textarea name="lesson_content" id="html_content" class="form-control">
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


