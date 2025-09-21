@extends('home.home_master')
@section('home')

@include("home.home_layout.slider")
<!-- end hero -->

@include("home.home_layout.features")
<!-- end content -->

@include("home.home_layout.clarify")
<!-- end content -->

@include("home.home_layout.get_all")

<div class="lonyo-content-shape3">
    <img src="{{ asset('frontend/assets/images/shape/shape2.svg') }}" alt="">
</div>
<!-- end content -->

@include("home.home_layout.usability")

<div class="lonyo-content-shape1">
    <img src="{{ asset('frontend/assets/images/shape/shape3.svg') }}" alt="">
</div>
<!-- end video -->

@include("home.home_layout.reviews")
<!-- end reviews -->

@include("home.home_layout.answers")

<div class="lonyo-content-shape3">
    <img src="{{ asset('frontend/assets/images/shape/shape2.svg') }}" alt="">
</div>
<!-- end faq -->

@include("home.home_layout.apps")

@endsection