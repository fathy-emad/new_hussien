@php
    $center = $center ?? null;
@endphp

<div class="row">
    <div class="col-md-6">
        <div class="input-block">
            <label class="form-label" for="title">اسم السنتر <span class="text-danger">*</span></label>
            <input
                type="text"
                class="form-control @error('title') is-invalid @enderror"
                name="title"
                id="title"
                value="{{ old('title', $center?->title) }}"
                required
                minlength="4"
            >
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-md-6">
        <div class="input-block">
            <label class="form-label" for="phone">رقم الموبايل</label>
            <input
                type="text"
                class="form-control @error('phone') is-invalid @enderror"
                name="phone"
                id="phone"
                value="{{ old('phone', $center?->phone) }}"
            >
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    <div class="col-12">
        <div class="input-block">
            <label class="form-label" for="address">العنوان</label>
            <input
                type="text"
                class="form-control @error('address') is-invalid @enderror"
                name="address"
                id="address"
                value="{{ old('address', $center?->address) }}"
            >
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
