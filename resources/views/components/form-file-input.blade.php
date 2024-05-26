@props([
    'id',
    'label',
    'required' => true,
    'accept' => 'image/jpeg',
    'previewContainerId',
    'file_type' => 'image',
    'disabled' => false,
])

<div class="form-group">
    <label for="{{ $id }}">{{ $label }}: @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <input type="file" class="form-control d-none" id="{{ $id }}" name="{{ $id }}"
        accept="{{ $accept }}" onchange="onSelectFileChange(event, '{{ $previewContainerId }}');"
        @if ($required) required @endif @if ($disabled) disabled @endif>
    <div class="d-flex justify-content-start align-items-start">
        <button class="btn btn-light mr-2" onclick="onSelectFileClick(event, '{{ $id }}');"
            @if ($disabled) disabled @endif>Choose
            {{ $label }}</button>
        @if ($file_type === 'image')
            <div class="imagePreview" id="{{ $previewContainerId }}">
                <p>No {{ $label }} Selected</p>
            </div>
        @endif
    </div>
</div>
