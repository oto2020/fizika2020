@extends('layouts.app')

@section('content')
    <div class="page-content">
        <h1>Редактирование содержимого главной страницы школы " {{$school->name}} "</h1>


        <!--Содержимое страницы по ДОБАВЛЕНИЮ СТАТЬИ!-->
        <div class="form-row">
            <div class="col-12">
                <form method="post" action="/edit_main_page.php">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="school_id" value = "{{$school->id}}">
                    <input type="hidden" name="back_url" value="{{url()->previous()}}">

                    <div class="form-group col-12">
                        <b>HTML-содержимое:<br></b>
                        <a href="/img_upload" target="_blank">Добавить картинку</a>
                        <textarea name="html_content" id="html_content" class="form-control">{{$school->content}}</textarea>

                    </div>
                    <div class="form-group col-6">
                        <input type="submit" value="Отправить">
                    </div>
                </form>
            </div>

        </div>
        <!-- КОНЕЦ Содержимого страницы!-->



    </div>
@endsection


