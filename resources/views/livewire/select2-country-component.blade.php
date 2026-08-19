<div>
    <select wire:model="selectedOption" id="select2" class="form-select select country-select"  name="sellist1">
        @foreach ($options as $option)
            <option value="{{ $option }}">{{ $option }}</option>
        @endforeach
    </select>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#select2').select2({ dir: 'rtl', width: '100%' });
        });
    </script>
@endpush
