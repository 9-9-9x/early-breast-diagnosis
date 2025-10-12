@props(['value'])

@php
    $id = 'recommendation_' . Str::slug($value);
@endphp

<label for="{{ $id }}" class="flex items-center gap-x-6 cursor-pointer group">
    <input type="checkbox" id="{{ $id }}" name="recommendations[]" value="{{ $value }}" class="hidden peer"
           @if(is_array(old('recommendations')) && in_array($value, old('recommendations'))) checked @endif>

    <div class="flex-shrink-0 w-14 h-14 border border-black rounded-lg flex items-center justify-center transition-colors
                peer-checked:bg-[#3e7b27] peer-checked:border-[#3e7b27] group-hover:border-[#85a947]">
        <svg class="hidden peer-checked:block w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
        </svg>
    </div>

    <span class="text-2xl text-black">{{ $slot }}</span>
</label>
