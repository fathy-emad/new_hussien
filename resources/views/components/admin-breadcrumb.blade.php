<!-- Breadcrumb -->
<div class="breadcrumb-bar breadcrumb-bar-info">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-12">
                <div class="breadcrumb-list">
                    <h2 class="breadcrumb-title">{{ $title }}</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb admin-page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ $item1 }}</a></li>
                            <li class="breadcrumb-separator" aria-hidden="true">-</li>
                            @if (! empty($item3))
                                <li class="breadcrumb-item">
                                    <a href="{{ $item2Url ?? '#' }}">{{ $item2 }}</a>
                                </li>
                                <li class="breadcrumb-separator" aria-hidden="true">-</li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $item3 }}</li>
                            @else
                                <li class="breadcrumb-item active" aria-current="page">{{ $item2 }}</li>
                            @endif
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Breadcrumb -->
