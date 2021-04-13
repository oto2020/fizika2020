<div name="layouts.left.menu" style="min-width: 130px">
    <hr>
    <!--Уроки (для страницы раздела)!-->
    @if(count($lessons) == 0)
        Уроки пока не добавлены.
    @else
        {{$section->name}}. Уроки:
        <nav class="navbar  navbar-light bg-light">
            <ul class="navbar-nav mr-auto">
                @foreach($lessons as $counter => $currentLesson)
                    <li class="nav-item active">
                        <a class="nav-link" href="/{{$school->uri}}/{{$section->uri}}/{{$currentLesson->uri}}">
                            Урок {{$counter + 1}}. {{$currentLesson->name}}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    @endif
    @if ($user!==null && $role->level >= 60)
        <a href="/{{$school->uri}}/{{$section->uri}}/add_lesson"> [добавить урок]</a>
    @endif
    <br>
    <!-- Тесты (для страницы урока) !-->
    @if (isset($tests) && count($tests) > 0)
        <hr/>
        Тесты по текущему уроку:
        @if (($user!==null && $role->level>=20))
            <nav class="navbar  navbar-light bg-light">
                <ul class="navbar-nav mr-auto">
                    @foreach($tests as $counter => $test)
                        <li class="nav-item active">
                            <a class="nav-link"
                               href="/{{$school->uri}}/{{$section->uri}}/{{$lesson->uri}}/{{$test->uri}}">
                                Тест {{$counter + 1}}. {{$test->name}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </nav>
        @else
            <div class="alert alert-danger" role="alert">
                Зарегистрируйтесь, чтобы проходить тесты
            </div>
        @endif
    @endif
    @if (isset($lesson) && $user!==null && $role->level >= 60)
        <a href="/{{$school->uri}}/{{$section->uri}}/{{$lesson->uri}}/add_test">[добавить тест]</a>
    @endif
</div>
