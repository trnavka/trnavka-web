{{--
  Template Name: Daj na to
--}}

@extends('layouts.app')

@section('content')
    @include('partials.campaign.header')
    @include('partials.campaign.donate')
    @include('partials.campaign.active-campaigns')
    @include('partials.campaign.services')
    @include('partials.campaign.donate-widget')
    @include('partials.campaign.archived-campaigns')

    <div class="collections">
            <div class="thank-you">
                <div>Ďakujeme</div>
            </div>
        </div>
    </div>
@endsection
