@php($form_id = uniqid('ssnailDeleteForm'))
<form x-data="" id="{{ $form_id }}" x-ref="{{ $form_id }}" method="POST" action="{{ route(array_key_first($attributes->getAttributes()) . 's.destroy', $attributes->first()) }}" enctype="multipart/form-data">
    @csrf
    {{ method_field('DELETE') }}

    {{ $slot }}
    <button @click.prevent="confirm('Sure?') ? $refs.{{ $form_id }}.submit() : false"><i class="fas fa-trash"></i> {{ __('Delete') }}</button>
</form>