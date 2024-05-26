@props([
    'id',
    'label',
    'required' => false,
    'type' => 'password',
    'placeholder' => '',
    'icon_id' => 'passwordIcon',
    'disabled' => false,
])

<div class="form-group">
    <label for="{{ $id }}">{{ $label }}: @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="d-flex justify-content-between align-items-center">
        <input type="{{ $type }}" class="form-control mr-2" id="{{ $id }}" name="{{ $id }}"
            placeholder="{{ $placeholder }}" @if ($required) required @endif
            @if ($disabled) disabled @endif>
        <button class="icon-btn btn btn-sm btn-primary" title="Toggle Password"
            onclick="onPasswordHelpClick(event, '{{ $id }}', '{{ $icon_id }}')">
            <i class="fas fa-eye" id="{{ $icon_id }}"></i>
        </button>
    </div>

</div>
