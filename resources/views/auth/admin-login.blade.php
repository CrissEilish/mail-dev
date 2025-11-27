@extends('layouts.app')

@section('content')
    <div class="flex justify-center items-center h-full mt-20">
        <div class="w-full max-w-md bg-card p-8 rounded-lg shadow-lg">
            <h2 class="text-2xl font-bold mb-6 text-center text-white">Admin Login</h2>

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-400 text-sm font-bold mb-2" for="username">Username</label>
                    <input class="w-full px-3 py-2 text-gray-900 rounded focus:outline-none focus:shadow-outline"
                        id="username" type="text" name="username" required autofocus>
                    @error('username')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-gray-400 text-sm font-bold mb-2" for="password">Password</label>
                    <input class="w-full px-3 py-2 text-gray-900 rounded focus:outline-none focus:shadow-outline"
                        id="password" type="password" name="password" required>
                </div>

                <div class="flex items-center justify-between">
                    <button class="btn-primary font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full"
                        type="submit">
                        Sign In
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection