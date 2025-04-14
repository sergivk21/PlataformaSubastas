@props(['user', 'size' => 'h-8 w-8'])

<div class="flex items-center">
    @if($user->profile_photo_path)
        <img {{ $attributes->merge(['class' => $size . ' rounded-full object-cover']) }} src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}">
    @else
        <div {{ $attributes->merge(['class' => $size . ' rounded-full flex items-center justify-center bg-blue-500 text-white font-bold']) }}>
            {{ strtoupper(substr($user->name, 0, 1)) }}
        </div>
    @endif
</div>
