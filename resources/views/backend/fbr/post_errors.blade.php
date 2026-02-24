@extends('backend.layout.main')
@section('content')
<section class="forms">
    <div class="container-fluid">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">
                FBR Posting Errors
            </h3>
            <div>
                <span class="badge badge-danger mr-2">Failed: {{ $pending }}</span>
                <span class="badge badge-secondary">Total: {{ $total }}</span>
                @if($pending == 0 && $total > 0)
                    <form action="{{ route('fbr.clear-resolved') }}" method="POST" class="d-inline ml-2"
                          onsubmit="return confirm('Clear all resolved errors?')">
                        @csrf
                        <button class="btn btn-sm btn-outline-secondary">
                            <i class="dripicons-trash"></i> Clear Resolved
                        </button>
                    </form>
                @endif
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }} <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>
        @endif

        {{-- Filter Bar --}}
        <div class="card mb-3">
            <div class="card-body py-2">
                <form method="GET" action="{{ route('fbr.post-errors') }}" class="form-inline flex-wrap">
                    <label class="mr-2"><strong>Status:</strong></label>
                    <select name="status" class="form-control form-control-sm mr-3 mb-2">
                        <option value="">All</option>
                        <option value="failed"   {{ request('status')=='failed'   ? 'selected':'' }}>Failed</option>
                        <option value="resolved" {{ request('status')=='resolved' ? 'selected':'' }}>Resolved</option>
                    </select>

                    <label class="mr-2"><strong>Type:</strong></label>
                    <select name="type" class="form-control form-control-sm mr-3 mb-2">
                        <option value="">All</option>
                        <option value="validation" {{ request('type')=='validation' ? 'selected':'' }}>Validation</option>
                        <option value="network"    {{ request('type')=='network'    ? 'selected':'' }}>Network</option>
                        <option value="other"      {{ request('type')=='other'      ? 'selected':'' }}>Other</option>
                    </select>

                    <label class="mr-2"><strong>From:</strong></label>
                    <input type="date" name="date_from" class="form-control form-control-sm mr-3 mb-2"
                           value="{{ request('date_from') }}">

                    <label class="mr-2"><strong>To:</strong></label>
                    <input type="date" name="date_to" class="form-control form-control-sm mr-3 mb-2"
                           value="{{ request('date_to') }}">

                    <button class="btn btn-sm btn-primary mb-2 mr-2">
                        <i class="dripicons-search"></i> Filter
                    </button>
                    <a href="{{ route('fbr.post-errors') }}" class="btn btn-sm btn-secondary mb-2">
                        <i class="dripicons-cross"></i> Reset
                    </a>
                </form>
            </div>
        </div>

        {{-- Errors Table --}}
        <div class="card">
            <div class="card-body p-0">
                @if($errors->isEmpty())
                    <div class="text-center py-5 text-muted">
                        <i class="dripicons-checkmark" style="font-size:3rem;"></i>
                        <p class="mt-2">No FBR posting errors found.</p>
                    </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0" id="fbr-errors-table">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:50px">#</th>
                                <th>Time</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>HTTP Code</th>
                                <th>Error Code</th>
                                <th>Error Message</th>
                                <th>Invoice Statuses</th>
                                <th>FBR Env</th>
                                <th>Reference No</th>
                                <!-- <th>Sale ID</th> -->
                                <th style="width:130px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($errors as $index => $err)
                            <tr class="{{ $err->status === 'failed' ? 'table-danger' : '' }}">
                                <td>{{ $errors->firstItem() + $index }}</td>
                                <td class="text-nowrap">
                                    {{ $err->error_time ? $err->error_time->format('Y-m-d H:i:s') : '—' }}
                                </td>
                                <td>
                                    <span class="badge badge-{{ $err->type === 'network' ? 'warning' : 'info' }}">
                                        {{ $err->type ?? '—' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $err->status === 'failed' ? 'danger' : 'success' }}">
                                        {{ ucfirst($err->status ?? '—') }}
                                    </span>
                                </td>
                                <td>{{ $err->status_code ?? '—' }}</td>
                                <td>{{ $err->error_code ?? '—' }}</td>
                                <td>
                                    <span title="{{ $err->error }}">
                                        {{ Str::limit($err->error, 80) }}
                                    </span>
                                </td>
                                <td>
                                    @if(!empty($err->invoice_statuses))
                                        <button class="btn btn-xs btn-outline-info"
                                                data-toggle="modal"
                                                data-target="#invoiceStatusModal"
                                                data-items='@json($err->invoice_statuses)'>
                                            View ({{ count($err->invoice_statuses) }})
                                        </button>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge badge-{{ $err->fbr_env === 'live' ? 'primary' : 'secondary' }}">
                                        {{ strtoupper($err->fbr_env ?? '—') }}
                                    </span>
                                </td>
                                <td>{{ $err->reference_no ?? '—' }}</td>
                                <!-- <td>{{ $err->sale_id ?? '—' }}</td> -->
                                <td class="text-nowrap">
                                    @if($err->status !== 'resolved')
                                    <form action="{{ route('fbr.mark-resolved', $err->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-xs btn-success" title="Mark Resolved">
                                            <i class="dripicons-checkmark"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('fbr.delete-error', $err->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('Delete this error record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-xs btn-danger" title="Delete">
                                            <i class="dripicons-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-between align-items-center px-3 py-2">
                    <small class="text-muted">
                        Showing {{ $errors->firstItem() }}–{{ $errors->lastItem() }} of {{ $errors->total() }} records
                    </small>
                    {{ $errors->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>

    </div>
</section>

{{-- Invoice Status Table Modal --}}
<div class="modal fade" id="invoiceStatusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">FBR Invoice Statuses</h5>
                <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0" id="invoiceStatusTable">
                        <thead class="thead-dark">
                            <tr>
                                <th style="width:60px">#</th>
                                <th style="width:100px">Status Code</th>
                                <th style="width:100px">Status</th>
                                <th style="width:100px">Error Code</th>
                                <th>Error Description</th>
                            </tr>
                        </thead>
                        <tbody id="invoiceStatusBody">
                            {{-- filled by JS --}}
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {

        // Populate Invoice Status Modal with a formatted table
        $('#invoiceStatusModal').on('show.bs.modal', function (e) {
            var items = $(e.relatedTarget).data('items');

            // items may already be an object if jQuery parsed it, or still a string
            if (typeof items === 'string') {
                try { items = JSON.parse(items); } catch(ex) { items = []; }
            }
            if (!Array.isArray(items)) {
                items = [items]; // wrap single object
            }

            var tbody = $('#invoiceStatusBody').empty();

            if (items.length === 0) {
                tbody.append('<tr><td colspan="5" class="text-center text-muted">No data</td></tr>');
                return;
            }

            $.each(items, function (i, item) {
                var statusBadge = item.status === 'Valid'
                    ? '<span class="badge badge-success">' + item.status + '</span>'
                    : '<span class="badge badge-danger">'  + (item.status || '—') + '</span>';

                var row = '<tr>' +
                    '<td>' + (item.itemSNo || (i + 1)) + '</td>' +
                    '<td><code>' + (item.statusCode || '—') + '</code></td>' +
                    '<td>' + statusBadge + '</td>' +
                    '<td><code>' + (item.errorCode || '—') + '</code></td>' +
                    '<td class="text-wrap" style="max-width:500px">' + (item.error || '<span class="text-muted">—</span>') + '</td>' +
                    '</tr>';

                tbody.append(row);
            });
        });

        // Activate sidebar
        $("ul#sale").siblings('a').attr('aria-expanded', 'true');
        $("ul#sale").addClass("show");
        $("ul#sale #fbr-errors-menu").addClass("active");
    });
</script>
@endpush
