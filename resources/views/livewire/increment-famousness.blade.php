<div wire:poll.visible.13s>
    Be famous!<br>Current time: {{ now() }}

    <div class="h-3 relative max-w-xl rounded-full overflow-hidden">
        <div class="w-full h-full bg-gray-200 absolute"></div>
        <div id="bar" class="h-full bg-amber-500 relative w-0 transition-all"></div>
    </div>

    <script>
        let progress = 0;
        let invervalSpeed = 100;
        let totalDuration = 13000;
        let incrementSpeed = 100 / 130;
        document.addEventListener("DOMContentLoaded", function(){
            let bar = document.getElementById('bar');
            progressInterval = setInterval(function(){
                progress += incrementSpeed;
                bar.style.width = progress + "%";
                if(progress >= totalDuration){
                    clearInterval(progressInterval);
                }
            }, invervalSpeed);
        });
    </script>
</div>
