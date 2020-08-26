@extends('master')

@section('content')
<main class="py-4 container">
    <div class="row">
        <!-- Post Content Column -->
        <div class="col-lg-12">

           @include('messages')

            @if(Route::currentRouteName() != 'post.list')

            <div class="d-flex justify-content-between mb-4">

                <h4>{{ Route::currentRouteName() == 'post.new' ? __('Add post') : __('Edit post') }}</h4>
                <a class="btn btn-primary" href="{{ route('post.list') }}">{{ __('To list') }}</a>
            </div>
            <form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
                
                @csrf
                <input type="hidden" name="id" value="{{ $post->id ?? '' }}">
                <div class="form-group">
                    <input type="text" class="form-control" name="title" placeholder="{{ __('Title') }}" value="{{ $post->title ?? '' }}">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="slug" placeholder="{{ __('Slug') }}" value="{{ $post->slug ?? '' }}">
                </div>

                <div class="form-group">
                    <input type="text" class="form-control" name="tags" placeholder="{{ __('Tags') }}" value="{{ $tags ?: '' }}">
                </div>
                <div class="form-group">
                    {{ Form::select('category_id', $categoryList, $post->category_id ?? null, ['class' => 'form-control'] )}}
                </div>
                <div class="form-group">
                    <textarea class="form-control tinymce" name="content" placeholder="{{ __('Content') }}">{{ $post->content ?? '' }}</textarea>
                </div>
                <div class="form-group">
                    {{ __('Image') }} <input type="file" name="featured_image">  

                    @if($post->featured_image ?? null)           
                    <img class="d-block my-2 img-thumbnail" style="max-height:200px;width:auto;" src="{{url('storage/'.$post->featured_image)}}">
                    @endif

                </div>
                <div class="form-group">
                    {{ __('Video') }} <input type="file" name="featured_video">
                     @if($post->featured_video ?? null)  
                        <video class="d-block my-2 img-thumbnail" width="320" height="240" controls>
                            <source src="{{url('storage/'.$post->featured_video)}}">
                            {{ __('Video not supported by browser') }}
                        </video> 
                     @endif                   
                </div>
                <div class="form-group mt-4">
                    <input type="submit" class="btn btn-success" value="{{ __('Submit') }}" />
                </div>
                
            </form>
            <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
            <script>
                tinymce.init({
                  selector: '.tinymce',
                  height: 500,
                  menubar: false,
                  statusbar: false,
                  plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount media'
                  ],
                  toolbar: 'undo redo | formatselect media | ' +
                  'bold italic backcolor | alignleft aligncenter ' +
                  'alignright alignjustify | bullist numlist outdent indent | ' +
                  'removeformat | help',
                  content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
                });

            </script>

            @else

             <div class="d-flex justify-content-between align-items-start mb-4">
                <h4>{{ __('All posts') }}</h4>
                <a class="btn btn-sm btn-success" href="{{ route('post.new') }}">{{ __('New') }}</a>
            </div>

            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>{{ __('Title') }}</th>
                        <th>{{ __('Created or updated') }}</th>
                        <th width=1></th>
                    </tr>
                </thead>    
                <tbody>  
                    @foreach($ds as $r)
                    <tr>
                        <td>{{$r->title}}</td>
                        <td>{{$r->updated_at ? $r->updated_at->format('d.m.Y') : $r->created_at->format('d.m.Y')}}</td>
                        <td class="text-nowrap">
                            <a class="btn btn-sm btn-primary" href="{{ route('post.edit', $r->id) }}">{{ __('Edit') }}</a>
                            <a class="btn btn-sm btn-danger" href="{{ route('post.delete', $r->id) }}" onClick="return confirm('Confirm delete')">{{ __('Delete') }}</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>  
            </table>

            @endif

        </div>
    </div>
</main>


@endsection