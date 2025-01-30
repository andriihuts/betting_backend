@extends('layouts.layouts')

@section('content')

<h3 class="text-center mt-3 mb-3">Log In</h3>
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('authenticate') }}" method="post">
                    @csrf
                    <div class="mb-3 row">
                        <div class="col-md-12">
                          <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Email Address">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-12">
                          <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Login">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>    
</div>
    
@endsection