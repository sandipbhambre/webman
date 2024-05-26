@props(['id', 'label', 'required' => false, 'type' => 'text', 'placeholder' => '', 'disabled' => false])

<div class="form-group">
    <label for="{{ $id }}">{{ $label }}: @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <input type="{{ $type }}" class="form-control" id="{{ $id }}" name="{{ $id }}"
        placeholder="{{ $placeholder }}" @if ($required) required @endif
        @if ($disabled) disabled @endif>

</div>
