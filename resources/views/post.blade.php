@extends('master')

@section('content')
    <div class="row">

        <!-- Post Content Column -->
        <div class="col-lg-8">

            <!-- Title -->
            <h1 class="mt-4">{{$post->title}}</h1>

            <!-- Author -->
            <p class="lead">
                by
                <b>{{$post->user->name}}</b>
            </p>

            <hr>

            <!-- Date/Time -->
            <p>Posted on {{$post->created_at->format('d.m.Y')}}</p>

            <hr>

            <!-- Preview Image -->
            <img class="img-fluid rounded" src="{{url('storage/'.$post->featured_image)}}" alt="">

            <hr>

            <!-- Post Content -->
            {!! $post->content !!}
            <hr>

            <!-- Comments -->


        </div>


        @include('widgets.sidebar')

    </div>
@endsection