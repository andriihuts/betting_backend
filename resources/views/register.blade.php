@extends('layouts.layouts')

@section('content')

<div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
    <h3 class="text-2xl font-bold text-center text-gray-800 mb-6 flex flex-row items-center"><img src="{{ asset('img/logo.png') }}" class="h-10 w-auto me-4" alt="main_logo"> Stepper Betting</h3>

    <form action="{{ route('store') }}" method="post">
        @csrf

        <div class="mb-4">
            <input type="text" id="name" name="name" value="{{ old('name') }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('name') border-red-500 @enderror"
                    placeholder="Name">
            @if ($errors->has('name'))
                <span class="text-sm text-red-500">{{ $errors->first('name') }}</span>
            @endif
        </div>

        <div class="mb-4">
            <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('email') border-red-500 @enderror"
                    placeholder="Email Address">
            @if ($errors->has('email'))
                <span class="text-sm text-red-500">{{ $errors->first('email') }}</span>
            @endif
        </div>

        <div class="mb-4">
            <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none @error('password') border-red-500 @enderror"
                    placeholder="Password">
            @if ($errors->has('password'))
                <span class="text-sm text-red-500">{{ $errors->first('password') }}</span>
            @endif
        </div>

        <div class="mb-4">
            <input type="password" id="password_confirmation" name="password_confirmation"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Confirm Password">
        </div>

        <div class="flex justify-center">
            <input type="submit" value="Register"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg cursor-pointer transition-all">
        </div>
    </form>
    <p class="mt-4 text-center text-gray-600">
        Already have an account?  <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Sign in</a>
    </p>
</div>
    
@endsection