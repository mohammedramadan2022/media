@props(['imageUrl'])

<a href="{{ $imageUrl }}" class="image-popup-vertical-fit">
    <img src="{{ $imageUrl }}" {{ $attributes }} alt="image">
</a>
