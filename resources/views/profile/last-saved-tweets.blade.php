@extends('layout')

@section('content')
    <main class="bg-gray-50">
        <div class="pt-10 sm:pt-16 lg:pt-8 lg:pb-14 lg:overflow-hidden">
            <h1 class="mt-4 text-center text-2xl tracking-tight font-extrabold text-dark sm:text-4xl xl:text-4xl mb-4">
                <span class="block">Son Kaydedilen Tweetler</span>
            </h1>
            <div style="border-radius: 10px">
                <div class="max-w-sm mx-auto py-12 px-4 sm:px-0 md:py-16">

                    <div>
                        <div class="flow-root mt-6">
                            @foreach($tweets as $tweet)
                                <div class="relative focus-within:ring-2 focus-within:ring-indigo-500 mb-5">
                                    <a href="{{ route('tweets.show', ['tweet' => $tweet->tweet_id]) }}">
                                    @include('layouts.partials.tweet_card', ['tweet' => $tweet])
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        @if ($tweets->hasPages())
                            <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between flex-column">
                                {{-- Previous Page Link --}}
                                @if ($tweets->onFirstPage())
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                        {!! __('pagination.previous') !!}
                                    </span>
                                @else
                                    <a href="{{ $tweets->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                        {!! __('pagination.previous') !!}
                                    </a>
                                @endif

                                {{-- Next Page Link --}}
                                @if ($tweets->hasMorePages())
                                    <a href="{{ $tweets->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                                        {!! __('pagination.next') !!}
                                    </a>
                                @else
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
                                        {!! __('pagination.next') !!}
                                    </span>
                                @endif
                            </nav>
                        @endif

                        <div class="mt-6">
                            <a href="{{ route('home') }}" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-900 bg-white hover:bg-blue-50">
                                Yeni Bir Tweet Kaydet
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection
