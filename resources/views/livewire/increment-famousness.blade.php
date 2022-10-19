<div wire:poll.visible.13s>
    <div class="w-full flex justify-end items-center py-2">
        <span class="ssnail-points font-bold text-sm text-amber-900">{{ $famous_points }}</span>
        <div class="relative">
            <span id="{{ $blinker_id }}" class="absolute inline-flex left-1 -top-1 h-5 w-5 rounded-full bg-amber-400 opacity-0"></span>
            <x-jet-application-logo class="block h-3 w-auto ml-1" />
        </div>
    </div>
    <style>
        #bar {
            animation: goahead 13s linear infinite;
        }
        @keyframes goahead {
          0% {
            width: 0;
          }
          100% {
            width: 100%;
          }
        }
    </style>
    <div class="h-3 relative w-full rounded-full overflow-hidden">
        <div class="w-full h-full bg-gray-200 absolute"></div>
        <div id="bar" class="h-full bg-amber-500 relative w-0 transition-all"></div>
    </div>
    <div class="ssnail-explanation mt-10">
        <h5 class="font-semibold text-amber-900">Make {{ $user->name }} more famous!</h5>
        <p class="my-2">The more you stay on this page, the more famous points <x-jet-application-logo class="inline h-3 w-auto" /> you give to this person.</p>
    </div>

    <script>
        window.addEventListener('ssnail-points-updated', event => {
            var blinker = document.getElementById('{{ $blinker_id }}');
            blinker.classList.remove('opacity-0');
            blinker.classList.add('opacity-75', 'animate-ping');
            setTimeout(function(){
                blinker.classList.add('opacity-0');
                blinker.classList.remove('opacity-75', 'animate-ping');
            }, 700);
        });
    </script>
</div>
