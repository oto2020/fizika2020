@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Калькулятор физических величин</h1>
        <units_calc
            :units='@json(isset($units)?$units:null)'
{{--            :school='@json(isset($school)?$school:null)'--}}
{{--            :user='@json(isset($user)?$user:null)'--}}
{{--            :role='@json(isset($role)?$role:null)'--}}
{{--            login-route="{{route('login')}}"--}}
{{--            register-route="{{route('register')}}"--}}
{{--            logout-route="{{route('logout')}}"--}}
        ></units_calc>
    </div>
@endsection
