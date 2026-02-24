@extends('backend.layout.main')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa fa-key"></i> Recovery Codes</h4>
                </div>
                <div class="card-body">
                    @if(isset($regenerated) && $regenerated)
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle"></i> New recovery codes have been generated. Your old codes are no longer valid.
                        </div>
                    @else
                        <div class="alert alert-success">
                            <i class="fa fa-check-circle"></i> Two-factor authentication has been enabled successfully!
                        </div>
                    @endif

                    <div class="alert alert-warning">
                        <strong><i class="fa fa-exclamation-triangle"></i> Important!</strong>
                        <ul class="mb-0 mt-2">
                            <li>Store these recovery codes in a secure location</li>
                            <li>Each code can only be used once</li>
                            <li>Use them if you lose access to your authenticator app</li>
                            <li>You can regenerate new codes at any time</li>
                        </ul>
                    </div>

                    <div class="recovery-codes-container">
                        <div class="row">
                            @foreach($recoveryCodes as $code)
                                <div class="col-md-6 mb-2">
                                    <div class="recovery-code">
                                        <code>{{ $code }}</code>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="button" class="btn btn-primary" onclick="printCodes()">
                            <i class="fa fa-print"></i> Print Codes
                        </button>
                        <button type="button" class="btn btn-info" onclick="copyCodes()">
                            <i class="fa fa-copy"></i> Copy All Codes
                        </button>
                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#regenerateModal">
                            <i class="fa fa-sync"></i> Regenerate Codes
                        </button>
                        <a href="{{ route('mfa.show') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back to 2FA Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Regenerate Modal -->
<div class="modal fade" id="regenerateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('mfa.recovery-codes.regenerate') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Regenerate Recovery Codes</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <strong>Warning!</strong> This will invalidate all your existing recovery codes.
                    </div>
                    <p>Please confirm your password to continue.</p>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Regenerate Codes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .recovery-codes-container {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        margin: 20px 0;
    }
    .recovery-code {
        background: white;
        padding: 10px;
        border: 1px solid #dee2e6;
        border-radius: 3px;
        text-align: center;
        font-family: monospace;
        font-size: 16px;
        letter-spacing: 2px;
    }
    @media print {
        .btn, .alert, .card-header, .modal { display: none !important; }
        .recovery-code { page-break-inside: avoid; }
    }
</style>
@endpush

@push('scripts')
<script>
    function printCodes() {
        window.print();
    }

    function copyCodes() {
        const codes = @json($recoveryCodes);
        const text = codes.join('\n');
        
        navigator.clipboard.writeText(text).then(function() {
            alert('Recovery codes copied to clipboard!');
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>
@endpush
@endsection