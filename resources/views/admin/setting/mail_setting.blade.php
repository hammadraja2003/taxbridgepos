@extends('admin.layouts.adminlayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-10 mx-auto">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="icon-shape icon-sm bg-primary-soft text-primary rounded mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="ti ti-mail fs-4"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold text-dark">Global Mail Settings</h5>
                            <p class="text-sm text-muted mb-0">Configure SMTP settings used for system-wide notifications (e.g., Database Cloning).</p>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.mail.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600">Mail Driver <span class="text-danger">*</span></label>
                                <input type="text" name="driver" class="form-control" value="{{ $mail_setting_data->driver ?? 'smtp' }}" required placeholder="e.g., smtp">
                                @error('driver') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600">Mail Host <span class="text-danger">*</span></label>
                                <input type="text" name="host" class="form-control" value="{{ $mail_setting_data->host ?? '' }}" required placeholder="e.g., smtp.mailtrap.io">
                                @error('host') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600">Mail Port <span class="text-danger">*</span></label>
                                <input type="text" name="port" class="form-control" value="{{ $mail_setting_data->port ?? '587' }}" required placeholder="e.g., 587">
                                @error('port') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600">Encryption <span class="text-danger">*</span></label>
                                <input type="text" name="encryption" class="form-control" value="{{ $mail_setting_data->encryption ?? 'tls' }}" required placeholder="e.g., tls or ssl">
                                @error('encryption') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600">Mail Username <span class="text-danger">*</span></label>
                                <input type="text" name="username" class="form-control" value="{{ $mail_setting_data->username ?? '' }}" required placeholder="SMTP Username">
                                @error('username') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600">Mail Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" value="{{ $mail_setting_data->password ?? '' }}" required placeholder="SMTP Password">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600">From Address <span class="text-danger">*</span></label>
                                <input type="email" name="from_address" class="form-control" value="{{ $mail_setting_data->from_address ?? '' }}" required placeholder="e.g., support@example.com">
                                @error('from_address') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-600">From Name <span class="text-danger">*</span></label>
                                <input type="text" name="from_name" class="form-control" value="{{ $mail_setting_data->from_name ?? '' }}" required placeholder="e.g., TaxBridge POS">
                                @error('from_name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="mt-2 text-right">
                            <button type="submit" class="btn btn-primary px-5 py-2">
                                <i class="ti ti-device-floppy mr-1"></i> Save Settings & Send Test Mail
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-600 { font-weight: 600; }
    .bg-primary-soft { background-color: rgba(59, 130, 246, 0.1); }
    .card { border-radius: 12px; }
    .form-control { border-radius: 8px; padding: 10px 15px; border: 1px solid #e5e7eb; }
    .form-control:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
    .btn-primary { border-radius: 8px; font-weight: 600; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.2); }
</style>
@endsection
