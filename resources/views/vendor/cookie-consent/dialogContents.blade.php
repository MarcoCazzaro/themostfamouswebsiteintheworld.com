<div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 pb-2 z-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="p-2 rounded-lg bg-amber-100">
            <div class="flex items-center justify-between flex-wrap">
                <div class="items-center">
                    <p class="ml-3 text-black cookie-consent__message">
                        {!! trans('cookie-consent::texts.message') !!}
                    </p>
                </div>
                <div class="mt-2 w-full sm:w-auto sm:mt-0">
                    <button class="js-cookie-consent-agree cookie-consent__agree cursor-pointer flex mx-auto items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-white bg-amber-500 hover:bg-amber-800">
                        {{ trans('cookie-consent::texts.agree') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
