
@foreach($posts as $post)
    <!-- Blog Post -->
    <div class="card mb-4">
        <img class="card-img-top" src="{{url('storage/'.$post->featured_image)}}" alt="Card image cap">
        <div class="card-body">
            <h2 class="card-title">{{$post->title}}</h2>
            <p class="card-text">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 200, '...') }}</p>
            <a href="{{url('post/'.$post->slug)}}" class="btn btn-primary">Read More →</a>
        </div>
        <div class="card-footer text-muted">
            Posted on {{$post->created_at->format('d.m.Y')}} by
            <b>{{$post->user->name}}</b>
        </div>
    </div>
@endforeach



