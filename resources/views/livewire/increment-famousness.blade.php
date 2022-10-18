<div wire:poll.visible.13s>
    Be famous!<br>Current time: {{ now() }} {{ $famous_points }}

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
    <div class="h-3 relative max-w-xl rounded-full overflow-hidden">
        <div class="w-full h-full bg-gray-200 absolute"></div>
        <div id="bar" class="h-full bg-amber-500 relative w-0 transition-all"></div>
    </div>

    <script>
        /*
        let progress = 0;
        let invervalSpeed = 100;
        let totalDuration = 13000;
        let incrementSpeed = 100 / 130;
        let rechargeFamousness = function() {
            console.log("Recharging famousness...");
            let bar = document.getElementById('bar');
            progressInterval = setInterval(function(){
                progress += incrementSpeed;
                bar.style.width = progress + "%";
                if(progress >= totalDuration){
                    clearInterval(progressInterval);
                }
            }, invervalSpeed);
        };
        rechargeFamousness();

        /*Livewire::listen('component.hydrate', function ($component, $request) {
            console.log("Wotaaaaa");
        });*/
    </script>
</div>
