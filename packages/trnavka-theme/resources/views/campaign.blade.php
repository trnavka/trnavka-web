{{--
  Template Name: Daj na to
--}}

@extends('layouts.app')

@section('content')
    @include('partials.campaign.header')
    @include('partials.campaign.donate')
    @include('partials.campaign.services')
    @include('partials.campaign.donate-widget')
    @include('partials.campaign.campaigns')
@endsection
