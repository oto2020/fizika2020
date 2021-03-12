@extends('layouts.app')

@section('content')
    <div class="page-content">
        <h1>Калькулятор физических величин</h1>
        <units_calc
            :calculators='@json(isset($calculators)?$calculators:null)'
        ></units_calc>
    </div>
@endsection
