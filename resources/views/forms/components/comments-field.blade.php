@php
    $record = $field->getRecord();
    $id = $record ? $record->id : null;
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        @if (!$id)
            Editing entries is only possible after the first save.
        @else
            @livewire('comments-table', ['blogId' => $id], key($id))
        @endif
    </div>
</x-dynamic-component>
