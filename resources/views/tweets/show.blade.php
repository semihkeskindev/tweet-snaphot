@extends('layout')

@section('content')
    <div class="lg:overflow-hidden">
        <div class="min-w-screen min-h-screen bg-gray-200 flex items-center justify-center px-5 py-5">
            @include('layouts.partials.tweet_card', ['tweet' => $tweet])
        </div>
    </div>
@endsection
