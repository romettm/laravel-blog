@extends('master')

@section('content')
<main class="py-4 container">
    <div class="row">
        <!-- Blog Entries Column -->
        <div class="col-md-8">

            <h1 class="my-4">{{ __('You are searching for:') }}
                <small>{{$key}}</small>
            </h1>

            @include('widgets.blog-masonry')

        </div>
        @include('widgets.sidebar')
    </div>
</main>
@endsection