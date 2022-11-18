<?php
if($user ?? false) {
    $contribution = $user->worship_amount ?? false;
    ?>
    <div class="w-full md:max-w-sm bg-white rounded-lg border border-gray-200 shadow-md">
        <div class="flex flex-col items-center p-6">
            @if($contribution)
                <div class="ssnail-contribution text-center text-xs mb-3 text-gray-400">
                    {{ __('Contribution') }}: {{ $contribution }}
                </div>
            @endif
            <div class="flex flex-row md:flex-col items-center">
                <img class="mb-3 w-16 h-16 md:w-24 md:h-24 rounded-full border border-amber-300" src="{{  $user->profile_photo_url }}" alt="{{ $user->name }}">
                <div class="ml-4 md:ml-0 text-left md:text-center">
                    <h5 class="mb-1 text-lg font-medium text-gray-900 md:truncate w-auto md:w-40">{{ $user->name }}</h5>
                    <div class="ssnail-points text-xs inline-flex items-center">
                        <span>{{ $user->total_famous_points }}</span>
                        <x-jet-application-logo class="inline h-3 w-auto ml-1" />
                    </div>
                </div>
            </div>
            <div class="flex mt-4 space-x-3 md:mt-6">
                <a href="{{ $user->url ?? '' }}" class="inline-flex items-center py-2 px-4 text-sm font-medium text-center text-white bg-amber-500 rounded-lg hover:bg-amber-700 focus:ring-4 focus:outline-none focus:ring-amber-300">View</a>
            </div>
        </div>
    </div>
    <?php
}