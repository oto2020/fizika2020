@extends('layouts.app', ['title'=>$section->name])

@section('content')
    <div class="row row-full-width">
        <!-- ЛЕВОЕ МЕНЮ !-->
        <div class="col-xs-12 col-sm-2">
            @include('layouts.left.auth')
            @include('layouts.left.menu')
        </div>
        <!-- КОНЕЦ ЛЕВОГО МЕНЮ!-->

        <!--Содержимое страницы!-->
        <div class="col-xs-12 col-sm-10 pt-4" >
            <?php// dd($lessons);?>
            <h1>{{$section->name}}</h1>
            @if(count($lessons)==0)
                Уроки пока не добавлены.
            @else
                <ul class="list-group list-group-flush">
                    @foreach($lessons as $l)
                        <li class="list-group-item">
                            <h2>{{$l->name}}</h2>
{{--                            TODO:разработать страницу темы--}}
                            <a class="alert-light" href="/themes/{{$l->themes_uri}}">
                                <h5>
                                    {{$l->themes_name}}
                                </h5>
                            </a>
                            <h6>
                                @if(isset($l->updated_at))
                                    Дата обновления урока: {{explode(' ', $l->updated_at)[0]}}
                                @else
                                    Дата добавления урока: {{explode(' ', $l->created_at)[0]}}
                                @endif
                                | Автор урока: {{$l->author_name}}
                            </h6>

                            {{$l->preview_text}}
                            <a class="nav-link" href="/{{$school->uri}}/{{$section->uri}}/{{$l->uri}}">
                                Подробнее ->
                            </a>
                        </li>
                    @endforeach
                </ul>

            @endif
        </div>
        <!-- КОНЕЦ Содержимого страницы!-->
    </div>
@endsection
