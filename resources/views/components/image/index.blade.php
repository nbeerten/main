<img 
    src="{{ $src }}"
@isset($srcset)
    srcset="{{ $srcset }}"
@endisset
    width="{{ $width }}"
    height="{{ $height }}"
    alt="{{ $alt }}"
    {{ $attributes }}
/>