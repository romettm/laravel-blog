<!-- Sidebar Widgets Column -->
<div class="col-md-4">

    <!-- Search Widget -->
    <div class="card my-4">
        <h5 class="card-header">{{ __('Search') }}</h5>
        <form class="card-body" action="{{url('/search')}}" method="GET" role="search">
            {{ csrf_field() }}
            <div class="input-group">
                <input type="text" class="form-control" placeholder="{{ __('Search for ...') }}" name="q">
                <span class="input-group-append">
                    <button class="btn btn-secondary" type="submit">{{ __('Go!') }}</button>
                </span>
            </div>
        </form>
    </div>

    <!-- Categories Widget -->
    <div class="card my-4">
        <h5 class="card-header">{{ __('Categories') }}</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-unstyled mb-0">
                        @foreach($categories as $category)
                        <li>
                            <a href="{{url('category/'.$category->slug)}}">{{$category->name}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Tags Widget -->
    <div class="card my-4">
        <h5 class="card-header">{{ __('Tags') }}</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <ul class="list-unstyled mb-0">
                        @foreach($tags as $tag)
                            <li>
                                <a href="{{url('tag/'.$tag->slug)}}">{{$tag->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Posts Widget -->
    <div class="card my-4">
        <h5 class="card-header">Recent Posts</h5>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <ul class="list-unstyled mb-0">
                        @foreach($recent_posts as $post)
                            <li>
                                <a href="{{url('post/'.$post->slug)}}">{{$post->title}}</a>
                            </li>
                            <hr>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Side Widget -->
    <div class="card my-4">
        <h5 class="card-header">{{ __('About') }}</h5>
        <div class="card-body">
            {{ __('This blog was created for demo purposes and learning experience.') }}
        </div>
    </div>

</div>