<div class="w-full mx-auto rounded-lg bg-white shadow p-5 text-gray-800" style="max-width: 400px; background: white">
    <div class="w-full flex mb-4">
        <div class="overflow-hidden rounded-full w-12 h-12">
            <img src="{{ $tweet->author->profile_image_url }}" alt="">
        </div>
        <div class="flex-grow pl-3">
            <h6 class="font-bold text-md">{{ $tweet->author->name }}</h6>
            <p class="text-xs text-gray-600">@<?php echo $tweet->author->username ?></p>
        </div>
        <div class="w-6">
            <svg class="h-6 w-6 text-blue-400 text-3xl" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
            </svg>
        </div>
    </div>
    <div class="w-full mb-4">
        <p class="text-sm">{{ $tweet->details->description }}</p>
    </div>
</div>
