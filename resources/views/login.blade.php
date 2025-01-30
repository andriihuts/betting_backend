@extends('layouts.layouts')

@section('content')

<div class="w-full max-w-md bg-white rounded-lg shadow-lg p-6">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6 flex flex-row items-center"><img src="{{ asset('img/logo.png') }}" class="h-10 w-auto me-4" alt="main_logo"> Stepper Betting</h2>
    <form action="{{ route('authenticate') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
        </div>
        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
            Login
        </button>
    </form>
</div>
    
@endsection