@extends('master')

@section('content')
<main class="py-4 container">
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

            

            @if($post->featured_image)
            <hr>
            <img class="card-img-top" src="{{url('storage/'.$post->featured_image)}}" alt="{{$post->title}}">
            @endif

            @if($post->featured_video ?? null)  
            <hr>
            <video class="d-block my-2" width="100%" controls>
                <source src="{{url('storage/'.$post->featured_video)}}">                
                {{ __('Your browser does not support the video tag.') }}
            </video> 
            @endif
            <hr>

            <!-- Post Content -->
            {!! $post->content !!}
            <hr>

            <!-- Comments -->

           

            <h4>{{ __('Comments') }}</h4>

            @include('messages')

            <form method="post" action="{{ route('comment.store') }}">
                @csrf
                <div class="form-group">
                    <textarea class="form-control" name="content"></textarea>
                    <input type="hidden" name="post_id" value="{{ $post->id }}" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="{{ __('Add comment') }}" />
                </div>
            </form>

            <hr />

            @foreach($comments as $comment)
                <div class="display-comment">
                    @if($comment->user_id)
                        <strong>{{ $comment->user->name }}</strong>
                    @else
                        <strong class="text-muted">{{ __('Guest') }}</strong>
                    @endif

                    <p>{!! nl2br(e($comment->content)) !!}</p>                
                </div>
            @endforeach

        </div>

        @include('widgets.sidebar')

    </div>
</main>
@endsection