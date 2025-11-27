@extends('layouts.app')

@section('content')
    <div class="flex flex-col justify-center items-center h-[80vh] text-center">
        <h1 class="text-5xl font-bold mb-6 bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-pink-600">
            DevBossMail
        </h1>
        <p class="text-xl text-gray-400 mb-8 max-w-2xl">
            Professional mailbox management for DevBossPanel clients. Secure, private, and easy to use.
        </p>

        <div class="flex space-x-4">
            <a href="{{ route('user.login') }}"
                class="btn-primary font-bold py-3 px-8 rounded-lg text-lg transition transform hover:scale-105">
                Client Login
            </a>
            <a href="{{ route('admin.login') }}"
                class="bg-gray-700 hover:bg-gray-600 text-white font-bold py-3 px-8 rounded-lg text-lg transition transform hover:scale-105">
                Admin Access
            </a>
        </div>
    </div>
@endsection