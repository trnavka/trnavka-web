{{--
  Template Name: 2023
--}}

@extends('layouts.app')

@section('content')

    <div class="header-title">
        <div class="container-fluid">
            <div class="lead-holder">
                <h1>Rok 2023</h1>
                <div class="row">
                    <div class="col-lg-6">
                        <p class="lead">
                            Každý rok sa v Saleziánskom diele na Trnávke deje množstvo aktivít, ktoré spolu so saleziánmi pripravuje veľa ľudí.
                            Ak by ste sa chceli zapojiť aj vy, ozvite sa nám. Hľadáme každého.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.report.services-dicaprio')
    @include('partials.report.events')
@endsection
