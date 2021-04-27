@extends('layouts.app')

@section('content')
<div class="mx-auto h-full flex justify-center items-center bg-gray-200">
    <div class="w-96 bg-white rounded-lg shadow-xl p-2">
        
        <div class="font-extralight text-red-400 text-2xl h-12 p-1">open.b</div>

        <div class="text-gray-400 pt-4 text-center">
            <h1 class="text-3xl">bem vindo</h1>
            <h2 class="text-red-200 text-1xl">Faça log-in para continuar</h2>
        </div>
       
        <form method="POST" action="{{ route('login') }}" class="pt-8">
                        @csrf

                        <div class="relative">
                            <label for="login" class="font-medium text-red-300 absolute pl-3 pt-1">login</label>

                            <div class="">
                                <input id="login" type="login" class="pt-8 w-full rounded pt-4 p-3 bg-gray-100 text-gray-400 outline-none focus:bg-red-100" name="login" 
                                value="{{ old('login') }}"  autocomplete="login" autofocus placeholder="login">

                                @error('email')
                                    <span class="text-red-500 text-sm" role="alert"> <strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="relative pt-2">
                            <label for="password" class="font-medium text-red-300 absolute pl-3 pt-1">senha</label>

                            <div>
                                <input id="password" type="password" class="pt-8 w-full rounded pt-4 p-3 bg-gray-100 text-gray-400 outline-none focus:bg-red-100" name="password" 
                                autocomplete="current-password" placeholder="senha">

                                @error('password')
                                    <span class="text-red-500 text-sm" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>

                        <div class="pt-2 pl-3">
                            <input class="outline-none focus:bg-red-100" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="text-gray-400" for="remember">
                                    Continuar Conectado
                                </label>
                        </div>

                        <div class="pt-8 h-16">
                            <button type="submit" class="rounded text-white font-bold bg-red-300 w-full h-full">
                                Login
                            </button>
                        </div>

                        <div class="flex justify-between pt-8 text-gray-400 font-bold">
                            <a class="hover:text-red-300" href="{{ route('password.request') }}">
                                Esqueceu sua senha?
                            </a>

                            <a class="hover:text-red-300" href="{{ route('register') }}">
                                Cadastro
                            </a>
                        </div>
                    </form>
    </div>
</div>
@endsection
