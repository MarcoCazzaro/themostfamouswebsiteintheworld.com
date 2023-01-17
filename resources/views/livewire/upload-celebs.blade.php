<div>
    <x-slot name="header">
        <div class="flex justify-between">
            <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Upload celebs') }}
            </h1>
        </div>
    </x-slot>

    <x-layout.container>
        <div class="w-full bg-white rounded-lg border border-gray-200 shadow-md">
            <div class="flex flex-col p-4 md:p-8 h-screen">
                <div wire:loading.delay>
                    <div class="text-center text-gray-400">
                        <i class="fas fa-rotate animate-spin"></i>
                    </div>
                </div>
                <div class="mb-8">
                    <x-jet-button wire:click="process">Import</x-jet-button>
                </div>
                <div class="ssnail-input-area h-full">
                    <textarea wire:model.defer="celebs" class="w-full h-full border-gray-300 focus:border-amber-900 focus:ring focus:ring-amber-300 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                </div>
            </div>
        </div>
    </x-layout.container>
</div>
