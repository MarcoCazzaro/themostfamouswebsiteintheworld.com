@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-amber-900 focus:ring focus:ring-amber-300 focus:ring-opacity-50 rounded-md shadow-sm']) !!}>
