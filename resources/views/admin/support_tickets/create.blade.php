@extends('admin.layouts.adminlayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ route('admin.support_tickets.index') }}" class="btn btn-outline-secondary btn-sm rounded-circle mr-3" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                    <i class="ti ti-arrow-left"></i>
                </a>
                <h4 class="font-weight-bold mb-0 text-dark">Create New Ticket</h4>
            </div>

            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="{{ route('admin.support_tickets.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label font-weight-bold">Subject / Title</label>
                                <input type="text" name="title" class="form-control shadow-sm" required placeholder="Brief summary of the issue">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Client / Business</label>
                                <select name="client_id" class="form-control shadow-sm" required>
                                    <option value="">Select Client</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->bus_config_id }}">{{ $client->bus_name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Priority</label>
                                <select name="priority" class="form-control shadow-sm" required>
                                    <option value="informational">Informational</option>
                                    <option value="medium">Medium</option>
                                    <option value="critical">Critical</option>
                                    <option value="new_feature">New Feature</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label font-weight-bold">Initial Status</label>
                                <select name="status" class="form-control shadow-sm" required>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="resolved">Resolved</option>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label font-weight-bold">Description</label>
                                <textarea name="description" class="form-control shadow-sm" rows="5" required placeholder="Detailed description of the issue..."></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label font-weight-bold">Attachments (Optional)</label>
                                <input type="file" name="attachments[]" class="form-control shadow-sm" multiple>
                                <small class="text-muted">Supported: JPG, PNG, PDF, DOC. Max 2MB per file.</small>
                            </div>

                            <div class="col-12 mt-4 text-end">
                                <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">
                                    <i class="ti ti-send mr-1"></i> Create Ticket
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
