@extends('admin.layouts.adminlayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        {{-- Left Column: Ticket Details & Comments --}}
        <div class="col-lg-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.support_tickets.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle mr-3" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                    <i class="ti ti-arrow-left"></i>
                </a>
                <div>
                    <h5 class="font-weight-bold mb-1 text-dark">Ticket #{{ $ticket->id }}</h5>
                    <div class="text-muted small">Created {{ $ticket->created_at->format('M d, Y h:i A') }} • Last updated {{ $ticket->updated_at->diffForHumans() }}</div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h4 class="font-weight-bold mb-3">{{ $ticket->title }}</h4>
                    <div class="bg-light p-3 rounded-3 mb-3 text-break">
                        {!! nl2br(e($ticket->description)) !!}
                    </div>

                    @if($ticket->attachments && $ticket->attachments->count() > 0)
                        <h6 class="font-weight-bold mb-2 mt-4"><i class="ti ti-paperclip mr-1"></i> Attachments</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($ticket->attachments as $attachment)
                                <a href="{{ asset('storage/' . $attachment->file_path) }}" target="_blank" class="btn btn-sm btn-light border rounded-pill">
                                    <i class="ti ti-file mr-1"></i> {{ $attachment->file_name }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- Comments Section --}}
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="font-weight-bold m-0"><i class="ti ti-messages mr-2"></i> Discussion</h6>
                </div>
                <div class="card-body p-4 bg-light">
                    <div class="discussion-timeline">
                        @forelse($ticket->comments as $comment)
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0 mr-3">
                                    <div class="rounded-circle bg-white border d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                                        <i class="ti ti-user"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between mb-2">
                                                <small class="font-weight-bold text-dark">
                                                    {{ $comment->commenter_type == 'App\Models\Admin' ? 'Admin' : 'Client' }}
                                                </small>
                                                <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-0 small text-dark">{{ $comment->comment }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted small py-3">No comments yet.</p>
                        @endforelse
                    </div>

                    {{-- Add Comment Form --}}
                    <div class="mt-4">
                        <form action="{{ route('admin.support_tickets.add_comment', \Illuminate\Support\Facades\Crypt::encryptString($ticket->id)) }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <textarea name="comment" class="form-control shadow-sm shadow-inset" rows="3" placeholder="Write a reply..." required></textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4">
                                    <i class="ti ti-send mr-1"></i> Post Reply
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Sidebar Actions --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom py-3">
                    <h6 class="font-weight-bold m-0">Properties</h6>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase font-weight-bold d-block mb-1">Status</label>
                        <form action="{{ route('admin.support_tickets.update_status', \Illuminate\Support\Facades\Crypt::encryptString($ticket->id)) }}" method="POST">
                            @csrf
                            <div class="input-group input-group-sm">
                                <select name="status" class="form-select status-select bg-{{ $ticket->status == 'resolved' ? 'success' : ($ticket->status == 'in_progress' ? 'primary' : 'warning') }}-subtle text-dark border-0 fw-bold" onchange="this.form.submit()">
                                    <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                </select>
                            </div>
                        </form>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small text-uppercase font-weight-bold d-block mb-1">Priority</label>
                        <span class="badge bg-secondary p-2 d-block text-center">{{ ucfirst(str_replace('_', ' ', $ticket->priority)) }}</span>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small text-uppercase font-weight-bold d-block mb-1">Client</label>
                        <div class="d-flex align-items-center">
                            <i class="ti ti-building-store fs-4 mr-2 text-muted"></i>
                            <span class="font-weight-bold text-dark">{{ $ticket->businessConfiguration->bus_name ?? 'Unknown Business' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
