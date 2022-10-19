<?php
if($user ?? false) {
    $profile_photo_path = asset('img/logo-squared.png');
    if ($user->profile_photo_path ?? false) {
        $profile_photo_path = Storage::url($user->profile_photo_path);
    }
    ?>
    <div class="w-full max-w-sm bg-white rounded-lg border border-gray-200 shadow-md">
        <div class="flex flex-col items-center p-8">
            <img class="mb-3 w-24 h-24 rounded-full border border-amber-300" src="{{  $profile_photo_path }}" alt="{{ $user->name }}">
            <h5 class="mb-1 text-xl font-medium text-gray-900">{{ $user->name }}</h5>
            <div class="ssnail-points text-xs flex items-center border-t pt-2">
                <span>{{ $user->total_famous_points }}</span>
                <x-jet-application-logo class="inline h-3 w-auto ml-1" />
            </div>
            <div class="flex mt-4 space-x-3 md:mt-6">
                <a href="{{ $user->url ?? '' }}" class="inline-flex items-center py-2 px-4 text-sm font-medium text-center text-white bg-amber-500 rounded-lg hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-amber-300">View</a>
            </div>
        </div>
    </div>
    <?php
}