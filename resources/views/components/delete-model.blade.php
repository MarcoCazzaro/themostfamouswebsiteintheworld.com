@php($form_id = uniqid('ssnailDeleteForm'))
<form x-data="" id="{{ $form_id }}" x-ref="{{ $form_id }}" method="POST" action="{{ route(\Str::plural(array_key_first($attributes->getAttributes())) . '.destroy', $attributes->first()) }}" enctype="multipart/form-data">
    @csrf
    {{ method_field('DELETE') }}

    {{ $slot }}
    <button @click.prevent="confirm('Sure?') ? $refs.{{ $form_id }}.submit() : false" class="text-red-500"><i class="fas fa-trash"></i> <span class="{{ $attributes->get('label-class') ?? '' }}">{{ __('Delete') }}</span></button>
</form>