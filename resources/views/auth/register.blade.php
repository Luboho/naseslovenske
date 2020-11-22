@extends('layouts.app')

@section('content')
<div class="mx-auto h-full flex justify-center items-center bg-gray-300">
    <div class="w-96 bg-indigo-500 rounded-lg shadow-xl p-8 mt-2">
    
        <div class="justify-center text-indigo-100 w-96">
                
            <div class="flex">
                <div class="w-32 pr-6">
                    <img src="{!! asset('storage/svgs/SRflag.svg') !!}" >
                </div>
                <div class="spacer px-4"></div>
                <div class="w-24">
                    <img src="{!! asset('storage/svgs/grocery_basket.svg') !!}" >
                </div>
            </div>
            <h1 class="text-sm pt-2 font-bold">Naše slovenské</h1>
            
        </div>

        <h1 class="text-indigo-100 text-2xl pt-6 pb-2">Vítajte</h1>
        <h2 class="text-indigo-100 ">Zaregistrujte sa</h2>

        <form method="POST" action="{{ route('register') }}" class="pt-1">
            @csrf

                <div class="relative">
                    <label for="name" class="uppercase text-blue-500 text-xs font-bold absolute pl-3 pt-2">
                        Meno
                    </label>

                    <div>
                        <input id="name" 
                               type="text" 
                               class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none border-none focus:bg-blue-700
                               @error('name') is-invalid @enderror" 
                               name="name" 
                               value="{{ old('name') }}" 
                               autocomplete="name" autofocus>

                        @error('name')
                            <span class="text-red-600 text-sm pt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                



                <div class="relative pt-3">
                    <label for="email" class="absolute uppercase text-blue-500 text-xs font-bold pl-3 pt-2">
                        E-mail
                    </label>

                        <div>
                            <input id="email" 
                               type="email" 
                               class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none border-none focus:bg-blue-700
                               @error('email') is-invalid @enderror"
                               name="email" 
                               value="{{ old('email') }}" 
                               autocomplete="email"
                               placeholder="imejl@email.sk">

                        @error('email')
                            <span class="text-red-600 text-sm pt-1" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="relative pt-3">
                    <label for="password" class="absolute uppercase text-blue-500 text-xs font-bold pl-3 pt-2">
                       Heslo
                    </label>

                    <input id="password" 
                           type="password" 
                           class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none border-none focus:bg-blue-700
                           @error('password') is-invalid @enderror" 
                           name="password" 
                           autocomplete="new-password">

                    @error('password')
                        <span class="text-red-600 text-sm pt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>


                <div class="relative pt-3">    
                    <label for="password-confirm" class="absolute uppercase text-blue-500 text-xs font-bold pl-3 pt-2">
                           Potvrdiť heslo
                    </label>

                        <input id="password-confirm" 
                               type="password" 
                               class="pt-8 w-full rounded p-3 bg-blue-800 text-gray-100 outline-none border-none focus:bg-blue-700" 
                               name="password_confirmation" 
                               autocomplete="new-password">

                    <div class="pt-8">
                        <button type="submit" class="w-full focus:outline-none hover:shadow-xl focus:bg-indigo-700 bg-gray-400 hover:bg-gray-200 py-2 px-3 uppercase rounded text-indigo-700 focus:text-gray-400 font-bold">
                            Registrovať
                        </button>
                    </div>
                </div>
            
        </form>
    </div>
</div>
@endsection
