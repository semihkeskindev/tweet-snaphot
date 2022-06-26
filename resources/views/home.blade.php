@extends('layout')

@section('content')
    <main class="bg-gray-50">
        <div class="pt-10 sm:pt-16 lg:pt-8 lg:pb-14 lg:overflow-hidden" style="min-height:70vh">
            <div class="mx-auto max-w-7xl lg:px-8">
                <div class="lg:grid lg:grid-cols-2 lg:gap-8">
                    <div class="mx-auto max-w-md px-4 sm:max-w-2xl sm:px-6 sm:text-center lg:px-0 lg:text-left lg:flex lg:items-center">
                        <div class="lg:py-24">
                            <h1 class="mt-4 text-4xl tracking-tight font-extrabold text-dark sm:mt-5 sm:text-6xl lg:mt-6 xl:text-6xl">
                                <span class="block">Twitter History</span>
                            </h1>
                            <p class="mt-3 max-w-md mx-auto text-lg text-gray-500 sm:text-xl md:mt-5 md:max-w-3xl">
                                Tweetler silinse bile kaybetmek istemiyor musun? Hemen aşağıdaki alana tweet linkini
                                bırak ve tweeti anlık olarak kaydet!</p>
                            @if(session()->has('savedSuccessTweet'))

                                @include('layouts.partials.success_alert', ['title' => 'Başarılı', 'description' => 'Tweet başarıyla kaydedildi. <a class="text-blue-500" href="'.route('tweets.show', ['tweet' => session('savedSuccessTweet')->tweet_id]).'">'.session('savedSuccessTweet')->tweet_id.'</a>.'])
                            @endif
                            @if($errors->any())
                                <div class="rounded-md bg-red-50 p-4 mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <!-- Heroicon name: solid/x-circle -->
                                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            {!! implode('', $errors->all('<div class="text-sm text-red-700">:message</div>')) !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="mt-10 sm:mt-12">
                                <form action="{{ route('home') }}" method="POST" class="mt-3 sm:flex">
                                    @csrf
                                    <label for="tweeturl" class="sr-only">Tweet Linki</label>
                                    <input type="text" name="tweet_url" id="tweeturl" placeholder="Tweet Linki"
                                           class="block w-full py-3 text-base rounded-md placeholder-gray-500 shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:flex-1 border-gray-300">
                                    <button type="submit"
                                            class="mt-3 w-full px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-500 shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-300 sm:mt-0 sm:ml-3 sm:flex-shrink-0 sm:inline-flex sm:items-center sm:w-auto">
                                        Tweeti Kaydet
                                    </button>
                                </form>
                                <p class="mt-3 text-sm text-gray-500">
                                    Örnek Tweet linki: https://twitter.com/Twitter/status/1509206476874784769
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-12 -mb-16 sm:-mb-48 lg:m-0 lg:relative">
                        <div class="mx-auto max-w-md px-4 sm:max-w-2xl sm:px-6 lg:max-w-none lg:px-0">
                            <!-- Illustration taken from Lucid Illustrations: https://lucid.pixsellz.io/ -->
                            <img class="w-full lg:absolute lg:inset-y-0 lg:left-0 lg:h-full lg:w-auto lg:max-w-none"
                                 src="https://i.ibb.co/5TPjSdn/584px-Twitter-logo.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- More main page content here... -->
    </main>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-10">
        <h1 class="mt-4 text-center text-2xl tracking-tight font-extrabold text-dark sm:text-4xl xl:text-4xl mb-4">
            <span class="block">Son Kaydedilen Tweetler</span>
        </h1>
        <div style="border-radius: 10px">
            <div class="max-w-sm mx-auto py-6 px-4 sm:px-0">

                <div>
                    <div class="flow-root mt-6">
                        @foreach($lastTweets as $tweet)
                            <div class="relative focus-within:ring-2 focus-within:ring-indigo-500 mb-5">
                                @include('layouts.partials.tweet_card', ['tweet' => $tweet])
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-6">
                        <a href="#" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-900 bg-white hover:bg-blue-50">
                            Yeni Bir Tweet Kaydet
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
