@extends('admin.layouts.adminlayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h4 class="font-weight-bold mb-0 text-dark">Support Tickets</h4>
                <a href="{{ route('admin.support_tickets.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="ti ti-plus mr-1"></i> Create Ticket
                </a>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 py-3 px-4">Ticket ID</th>
                                    <th class="border-0 py-3">Subject</th>
                                    <th class="border-0 py-3">Client</th>
                                    <th class="border-0 py-3">Priority</th>
                                    <th class="border-0 py-3">Status</th>
                                    <th class="border-0 py-3">Last Updated</th>
                                    <th class="border-0 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tickets as $ticket)
                                    <tr>
                                        <td class="px-4 text-muted">#{{ $ticket->id }}</td>
                                        <td>
                                            <a href="{{ route('admin.support_tickets.show', \Illuminate\Support\Facades\Crypt::encryptString($ticket->id)) }}" class="text-dark font-weight-bold text-decoration-none">
                                                {{ Str::limit($ticket->title, 40) }}
                                            </a>
                                        </td>
                                        <td>{{ $ticket->businessConfiguration->bus_name ?? 'N/A' }}</td>
                                        <td>
                                            @php
                                                $priorityColors = [
                                                    'critical' => 'danger',
                                                    'medium' => 'warning',
                                                    'new_feature' => 'info',
                                                    'informational' => 'secondary'
                                                ];
                                                $color = $priorityColors[$ticket->priority] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}-subtle text-{{ $color }} px-2 py-1 rounded-pill">
                                                {{ ucfirst(str_replace('_', ' ', $ticket->priority)) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'warning',
                                                    'in_progress' => 'primary',
                                                    'resolved' => 'success'
                                                ];
                                                $color = $statusColors[$ticket->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}-subtle text-{{ $color }} px-2 py-1 rounded-pill">
                                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                            </span>
                                        </td>
                                        <td class="text-muted small">
                                            {{ $ticket->updated_at->diffForHumans() }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.support_tickets.show', \Illuminate\Support\Facades\Crypt::encryptString($ticket->id)) }}" class="btn btn-sm btn-light border rounded-pill px-3">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="ti ti-ticket fs-1 opacity-25 mb-3 d-block"></i>
                                            No support tickets found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($tickets->hasPages())
                    <div class="card-footer bg-white border-top py-3">
                        {{ $tickets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .bg-danger-subtle { background-color: rgba(220, 53, 69, 0.1); }
    .bg-warning-subtle { background-color: rgba(255, 193, 7, 0.1); }
    .bg-info-subtle { background-color: rgba(13, 202, 240, 0.1); }
    .bg-success-subtle { background-color: rgba(25, 135, 84, 0.1); }
    .bg-primary-subtle { background-color: rgba(13, 110, 253, 0.1); }
    .bg-secondary-subtle { background-color: rgba(108, 117, 125, 0.1); }
</style>
@endsection
