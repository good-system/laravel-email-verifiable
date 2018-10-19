@extends('layouts.app')

@section('content')
    <div class="flex items-center">
        <div class="md:w-1/2 md:mx-auto">
            <div class="rounded shadow">
                <div class="font-medium text-lg text-teal-darker bg-teal p-3 rounded-t">
                    {{ __('Your submission for ' . $model . ' (ID: ' . $id . ') has been verified') }}
                </div>
                <div class="bg-white p-3 rounded-b">
                    <p class="text-grey-dark">
                        {{ __('Would you like to ') }}
                        @guest
                            <a href="{{ route('login') }}">{{ __('log in') }}</a>
                        @else
                            <!-- TODO more appropriately -- go to the model page -->
                            <a href="{{ route('home') }}">{{ __('go to account home page') }}</a>
                        @endguest
                        {{ __(' now ?') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
