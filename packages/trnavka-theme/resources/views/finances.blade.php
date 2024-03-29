{{--
  Template Name: Finančné štatistiky
--}}

@extends('layouts.app')

@section('content')
    @if(isset($dajnato_stats))
        @include('partials.finances.dajnato')
    @endif
    {{--    @include('partials.campaign.modal')--}}
    @include('partials.finances.header')
    @include('partials.finances.services')
    @include('partials.finances.footer')

    <div id="chcem-prispiet">
        @include('partials.finances.donate-widget')
    </div>
@endsection
