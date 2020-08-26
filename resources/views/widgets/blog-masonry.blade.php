
@foreach($posts as $post)
    <!-- Blog Post -->
    <div class="card mb-4">
        @if($post->featured_image)
        <img class="card-img-top" src="{{url('storage/'.$post->featured_image)}}" alt="{{$post->title}}">
        @elseif($post->featured_video ?? null)  
            <video class="d-block rounded-top" width="100%" controls>
                <source src="{{url('storage/'.$post->featured_video)}}">
                {{ __('Video not supported by browser') }}
            </video> 
         @endif
        <div class="card-body">
            <h2 class="card-title">{{$post->title}}</h2>
            <p class="card-text">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 200, '...') }}</p>
            <a href="{{url('post/'.$post->slug)}}" class="btn btn-primary">{{ __('Read More →') }}</a>
        </div>
        <div class="card-footer text-muted">
            {{ __('Posted on') }} {{$post->created_at->format('d.m.Y')}} by
            <b>{{$post->user->name}}</b>
        </div>
    </div>
@endforeach

@if(method_exists($posts, 'links'))
<!-- Pagination -->
<ul class="pagination justify-content-center mb-4">
    {{$posts->links()}}
</ul>
@endif



