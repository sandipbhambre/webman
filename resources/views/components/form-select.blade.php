@props(['id', 'label', 'required' => true, 'options' => [], 'disabled' => false])

<div class="form-group">
    <label for="{{ $id }}">{{ $label }}: @if ($required)
            <span class="text-danger">*</span>
        @endif
    </label>
    <select class="custom-select" id="{{ $id }}" name="{{ $id }}"
        @if ($required) required @endif @if ($disabled) disabled @endif>
        <option value=""></option>
        @foreach ($options as $option)
            <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
        @endforeach
    </select>
</div>
