@if($user ?? false)
    <?php
    $contribution = $user->worship_amount ?? false;
    $element_index = $element_index ?? false;
    ?>
    <div class="w-full md:max-w-sm bg-white rounded-lg border {{ ($highlight_user ?? false) ? 'border-amber-400' : 'border-gray-200' }} shadow-md overflow-hidden mx-auto">
        <div class="flex flex-col items-center p-6 relative">
            @if($element_index || $contribution)
                <header class="ssnail-extra-info flex justify-between w-full absolute top-0 left-0 p-2">
                    <div class="ssnail-position">
                        @if($element_index)
                            <span class="ssnail-count flex items-center justify-center w-6 h-6 {{ ($highlight_user ?? false) ? 'bg-amber-400 text-white' : 'bg-amber-100 text-amber-600' }} font-bold rounded-full text-[9px]">{{ humanNumber($element_index) }}</span>
                        @endif
                    </div>
                    <div class="ssnail-contribution text-right text-xs text-gray-400">
                        @if($contribution)
                            {{ __('Contribution') }}: {{ $contribution }}
                        @endif
                    </div>
                </header>
            @endif
            <div class="flex flex-row md:flex-col items-center w-full">
                <img class="grow-0 shrink-0 mb-3 w-16 h-16 md:w-24 md:h-24 object-cover rounded-full border border-amber-300" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
                <div class="ml-4 md:ml-0 text-left md:text-center grow">
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
@endif