<div>
<div class="row gx-2 align-items-center">
    <div class="col-md-6 col-lg-3 col-item">
        <div class="input-block select-form mb-1">
            <select wire:model="selectedOption1" class="select2 form-select select">
                @foreach ($options1 as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 col-item">
        <div class="input-block select-form mb-1">
            <select wire:model="selectedOption2" class="select2 form-select select">
                @foreach ($options2 as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-6 col-lg-3 col-item">
        <div class="input-block select-form mb-1">
            <select wire:model="selectedOption3" class="select2 form-select select">
                @foreach ($options3 as $option)
                    <option value="{{ $option }}">{{ $option }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2.select').select2({ dir: 'rtl', width: '100%' });
        });
    </script>
@endpush
