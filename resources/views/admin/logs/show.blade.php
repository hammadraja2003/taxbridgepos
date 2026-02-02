@extends('admin.layouts.adminlayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Header Section -->
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h4 class="font-weight-bold mb-1 text-dark">System Logs</h4>
                    <p class="text-muted small mb-0">Real-time application log viewer and analysis.</p>
                </div>
                <div class="d-flex gap-2">
                    <button id="refreshBtn" class="btn btn-white border shadow-sm rounded-pill px-3">
                        <i class="ti ti-refresh mr-1"></i> Refresh
                    </button>
                    <button id="clearBtn" class="btn btn-danger rounded-pill px-3 shadow-sm">
                        <i class="ti ti-trash mr-1"></i> Clear Logs
                    </button>
                </div>
            </div>

            <div class="card shadow-sm border-0">
                <!-- Toolbar -->
                <div class="card-header bg-white border-bottom py-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="ti ti-search text-muted"></i></span>
                                <input type="text" id="searchBox" class="form-control bg-light border-start-0" placeholder="Search log entries...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select id="filterLevel" class="form-select bg-light">
                                <option value="">All Levels</option>
                                <option value="ERROR">Error</option>
                                <option value="WARNING">Warning</option>
                                <option value="INFO">Info</option>
                                <option value="DEBUG">Debug</option>
                            </select>
                        </div>
                        <div class="col-md-5 text-md-end text-muted small">
                            <span id="status"><i class="ti ti-loader animate-spin mr-1"></i> Connecting...</span>
                            <span class="mx-2">•</span>
                            <span>Auto-refresh: 15s</span>
                        </div>
                    </div>
                </div>

                <!-- Log Content -->
                <div class="card-body p-0 bg-dark position-relative">
                    <div id="logContainer" class="p-3 overflow-auto font-monospace custom-scrollbar" 
                        style="height: auto; white-space: pre-wrap; font-size: 13px; color: #e9ecef;">
                        {{-- Content loaded via JS --}}
                        @if (!empty($log))
                            {!! nl2br(e($log)) !!}
                        @else
                            <div class="h-100 d-flex flex-column align-items-center justify-content-center text-secondary opacity-50">
                                <i class="ti ti-terminal fs-1 mb-3"></i>
                                <p>Waiting for logs...</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Scroll to Top (Optional) -->
                    <button id="scrollTopBtn" class="btn btn-sm btn-secondary position-absolute bottom-0 end-0 m-3 rounded-circle shadow" style="display: none; width: 32px; height: 32px; padding: 0;">
                        <i class="ti ti-arrow-up"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .font-monospace { font-family: 'SFMono-Regular', Consolas, 'Liberation Mono', Menlo, monospace !important; }
    .custom-scrollbar::-webkit-scrollbar { width: 8px; height: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #212529; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #495057; border-radius: 4px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #6c757d; }
    .animate-spin { animation: spin 2s linear infinite; }
    @keyframes spin { 100% { transform: rotate(360deg); } }
    
    /* Log highlighting classes */
    .log-error { color: #ff6b6b; font-weight: bold; }
    .log-warning { color: #fcc419; font-weight: bold; }
    .log-info { color: #339af0; font-weight: bold; }
    .log-debug { color: #51cf66; font-weight: bold; }
    .log-time { color: #868e96; }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const logContainer = document.getElementById('logContainer');
        const refreshBtn = document.getElementById('refreshBtn');
        const clearBtn = document.getElementById('clearBtn');
        const status = document.getElementById('status');
        const searchBox = document.getElementById('searchBox');
        const filterLevel = document.getElementById('filterLevel');
        let allLogs = "";

        async function fetchLogs() {
            status.innerHTML = '<i class="ti ti-loader animate-spin mr-1"></i> Updating...';
            try {
                const response = await fetch('{{ route('admin.logs.index') }}?lines=300', {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                allLogs = data.log || '';
                renderLogs();
                status.innerHTML = '<i class="ti ti-check text-success mr-1"></i> Updated: ' + new Date().toLocaleTimeString();
            } catch (e) {
                console.error(e);
                status.innerHTML = '<i class="ti ti-alert-circle text-danger mr-1"></i> Connection failed';
            }
        }

        function renderLogs() {
            let filtered = allLogs;
            const query = searchBox.value.trim().toLowerCase();
            const level = filterLevel.value;

            if (filtered.length === 0) {
                logContainer.innerHTML = '<div class="h-100 d-flex flex-column align-items-center justify-content-center text-secondary opacity-50"><i class="ti ti-check-circle fs-1 mb-3"></i><p>Log file is empty.</p></div>';
                return;
            }

            if (level) {
                const regex = new RegExp(`\\b${level}\\b`, 'i');
                filtered = filtered.split('\n').filter(line => regex.test(line)).join('\n');
            }
            if (query) {
                filtered = filtered.split('\n').filter(line => line.toLowerCase().includes(query)).join('\n');
            }

            if (filtered.length === 0) {
                logContainer.innerHTML = '<div class="py-5 text-center text-secondary">No matching entries found.</div>';
            } else {
                logContainer.innerHTML = highlightLogs(filtered);
                // Auto scroll to bottom if at bottom? For now, let's keep position or scroll to bottom on first load.
            }
        }

        function highlightLogs(logs) {
            return logs
                .replace(/\[(.*?)\]/g, '<span class="log-time">[$1]</span>')
                .replace(/\bERROR\b/g, '<span class="log-error">ERROR</span>')
                .replace(/\bWARNING\b/g, '<span class="log-warning">WARNING</span>')
                .replace(/\bINFO\b/g, '<span class="log-info">INFO</span>')
                .replace(/\bDEBUG\b/g, '<span class="log-debug">DEBUG</span>')
                .replace(/(Stack trace:)/g, '<br><span class="text-secondary ms-3">$1</span>')
                .replace(/(#\d+)/g, '<br><span class="text-secondary ms-4">$1</span>');
        }

        async function clearLogs() {
            if (!confirm('Are you sure you want to clear the entire log file? This cannot be undone.')) return;
            status.textContent = 'Clearing...';
            try {
                const response = await fetch('{{ route('admin.logs.clear') }}');
                const data = await response.json();
                fetchLogs(); // Reload empty
            } catch (e) {
                alert('Failed to clear logs.');
            }
        }

        refreshBtn.addEventListener('click', fetchLogs);
        clearBtn.addEventListener('click', clearLogs);
        searchBox.addEventListener('input', renderLogs);
        filterLevel.addEventListener('change', renderLogs);

        // Initial fetch
        fetchLogs();
        
        // Auto refresh
        setInterval(fetchLogs, 15000);
    });
</script>
@endsection

