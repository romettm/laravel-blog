@extends('master')

@section('content')

<main class="py-4 container">
    <div class="row">
    <!-- Blog Entries Column -->
    <div class="col-md-8">

    <h1 class="h3 my-4">{{ __('Home page') }}</h1>

        @include('widgets.blog-masonry')

    </div>
        @include('widgets.sidebar')
    </div>
</main>

@endsection