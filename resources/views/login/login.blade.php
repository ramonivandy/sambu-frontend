@extends('layouts.app')

@section('content')
<div class="flex flex-row">
    <div class="w-2/3">
        <div class="justify-items-center">
            <img src="{{ asset('img/bg1.png') }}" class="w-2/3">
        </div>
    </div>
    <div class="w-1/3">
        <h2 class="text-2xl font-bold mb-4">Log in to CompanyBrand</h2>
        <p class="mb-4">Enter your details below</p>
        <div>
            @if($errors->any())
            {!! implode('', $errors->all('
            <div role="alert" class="rounded border-s-4 border-red-500 bg-red-50 p-4 mb-3">
                <div class="flex items-center gap-2 text-red-800">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                        <path fill-rule="evenodd" d="M9.401 3.003c1.155-2 4.043-2 5.197 0l7.355 12.748c1.154 2-.29 4.5-2.599 4.5H4.645c-2.309 0-3.752-2.5-2.598-4.5L9.4 3.003zM12 8.25a.75.75 0 01.75.75v3.75a.75.75 0 01-1.5 0V9a.75.75 0 01.75-.75zm0 8.25a.75.75 0 100-1.5.75.75 0 000 1.5z" clip-rule="evenodd" />
                    </svg>

                    <strong class="block font-medium"> Something went wrong </strong>
                </div>

                <p class="mt-2 text-sm text-red-700">
                    :message
                </p>
            </div>
            ')) !!}
            @endif
        </div>
        <form action="{{url('/login')}}" method="post">
            @csrf
            <div class="mb-4">
                <input type="email" name="email" placeholder="Email or Phone Number" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            <div class="mb-4">
                <input type="password" name="password" placeholder="Password" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">Log In</button>
        </form>
    </div>
</div>
@endsection