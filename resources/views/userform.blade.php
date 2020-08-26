@extends('master')

@section('content')
<main class="py-4 container">
    <div class="row">
        <!-- user Content Column -->
        <div class="col-lg-12">

            @include('messages')

            @if(Route::currentRouteName() != 'user.list')
            <div class="d-flex justify-content-between mb-4">
                <h4>{{Route::currentRouteName() == 'user.add' ? __('Add user') : __('Edit user') }}</h4>
                <a class="btn btn-primary" href="{{ route('user.list') }}">{{ __('To list') }}</a>
            </div>

            <form method="post" action="{{ route('user.store') }}">
                <input type="hidden" name="id" value="{{ $user->id ?? '' }}">
                @csrf
                <div class="form-group">
                    <input type="text" class="form-control" name="name" placeholder="{{ __('Name') }}" value="{{ $user->name ?? '' }}">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="email" placeholder="{{ __('Email') }}" value="{{ $user->email ?? '' }}">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" placeholder="{{ __('Password') }}" value="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Password confirmation') }}" value="">
                </div>
               
                <div class="form-group">
                    <input type="submit" class="btn btn-success" value="{{ __('Submit') }}" />
                </div>
                
            </form>
           

            @else

             <div class="d-flex justify-content-between align-items-start mb-4">
                <h4>{{ __('All users') }}</h4>
                <a class="btn btn-sm btn-success" href="{{ route('user.new') }}">{{ __('New') }}</a>
            </div>

            <table class="table table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Created or updated') }}</th>
                        <th width="1"></th>
                    </tr>
                </thead>    
                <tbody>  
                    @foreach($ds as $r)
                    <tr>
                        <td>{{$r->name}}</td>
                        <td>{{$r->updated_at ? $r->updated_at->format('d.m.Y') : $r->created_at->format('d.m.Y')}}</td>
                        <td class="text-nowrap">
                            @if(Auth::user()->id == $r->id)
                            <a class="btn btn-sm btn-primary" href="{{ route('user.edit', $r->id) }}">{{ __('Edit') }}</a>
                            <a class="btn btn-sm btn-danger" href="{{ route('user.delete', $r->id) }}" onClick="return confirm('Confirm delete')">{{ __('Delete') }}</a>
                            @endif
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