@php
    $db_str = '';
    $isLandlord = 0;
    if (!config('database.connections.saleprosaas_landlord')) {
        $layout = 'backend.layout.main';
        $db_str = 'db.';
    }
    else {
        $isLandlord = 1;
        $layout = 'landlord.layout.main';
    }
@endphp

@extends($layout)
@section('content')

@push('css')
<style>
.table td {
    background: #FFF;
}
</style>
@endpush

<x-success-message key="message" />
<x-error-message key="not_permitted" />

<section>
    <div class="container-fluid">
        <div class="card-header mt-2">
            <h3 class="text-center">{{__($db_str.'Addon List')}}</h3>
        </div>
    </div>
    <div class="table-responsive container-fluid mt-5">
        <h3 class="text-center">Coming soon</h3>
    </div>
</section>

@endsection

@push('scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>
@endpush
