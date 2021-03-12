@extends('layouts.app')

@section('content')
    <div class="page-content">
        <h1>СТРАНИЦА ШКОЛЫ "{{$school->name}}" ТАК СКАЗАТБ</h1>
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-8">--}}
{{--                <div class="card">--}}
{{--                    <div class="card-header">{{ __('Dashboard') }}</div>--}}

{{--                    <div class="card-body">--}}
{{--                        @if (session('status'))--}}
{{--                            <div class="alert alert-success" role="alert">--}}
{{--                                {{ session('status') }}--}}
{{--                            </div>--}}
{{--                        @endif--}}

{{--                        @if (isset($user))--}}
{{--                            Вы залогинены!--}}
{{--                        @else--}}
{{--                            Вы не залогинены!--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
