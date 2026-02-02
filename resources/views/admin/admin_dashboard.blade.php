@extends('admin.layouts.adminlayout')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-12">
            <h3 class="font-weight-bold mb-4">Admin Dashboard</h3>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 py-2 border-left-primary">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Businesses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dashboardData['totalBusinesses'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 py-2 border-left-success">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Active Businesses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dashboardData['totalActiveBusinesses'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 py-2 border-left-info">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Trial Businesses</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dashboardData['totalTrialBusinesses'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 shadow-sm h-100 py-2 border-left-warning">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Users</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $dashboardData['totalUsers'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Subscriptions Expiring in 15 Days -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between border-0">
                    <h6 class="m-0 font-weight-bold text-primary">Subscriptions Expiring (Next 15 Days)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="expiringTwoWeeksChart"></canvas>
                    </div>
                    @if(empty($dashboardData['expiringTwoWeeks']['labels']))
                        <div class="text-center py-5 text-muted italic">No subscriptions expiring soon.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Subscriptions Expiring in 30 Days -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 d-flex flex-row align-items-center justify-content-between border-0">
                    <h6 class="m-0 font-weight-bold text-primary">Subscriptions Expiring (Next 30 Days)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="expiringOneMonthChart"></canvas>
                    </div>
                    @if(empty($dashboardData['expiringOneMonth']['labels']))
                        <div class="text-center py-5 text-muted italic">No subscriptions expiring this month.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Support Ticket Graphs -->
    <div class="row">
        <!-- Top Clients by Tickets -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="m-0 font-weight-bold text-primary">Top Clients by Tickets</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 250px;">
                        <canvas id="topTicketClientsChart"></canvas>
                    </div>
                    @if(empty($dashboardData['topTicketClients']['labels']))
                        <div class="text-center mt-3 text-muted small italic">No ticket data available.</div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tickets by Priority -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="m-0 font-weight-bold text-info">Tickets by Priority</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 250px;">
                        <canvas id="ticketsByPriorityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tickets by Status -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="m-0 font-weight-bold text-success">Tickets by Status</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area" style="height: 250px;">
                        <canvas id="ticketsByStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const expiringTwoWeeksData = @json($dashboardData['expiringTwoWeeks']);
        const expiringOneMonthData = @json($dashboardData['expiringOneMonth']);

        if (expiringTwoWeeksData.labels.length > 0) {
            new Chart(document.getElementById('expiringTwoWeeksChart'), {
                type: 'bar',
                data: {
                    labels: expiringTwoWeeksData.labels,
                    datasets: [{
                        label: 'Days Left',
                        data: expiringTwoWeeksData.data,
                        backgroundColor: 'rgba(255, 193, 7, 0.6)',
                        borderColor: 'rgb(255, 193, 7)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Days Remaining' }
                        }
                    }
                }
            });
        }

        if (expiringOneMonthData.labels.length > 0) {
            new Chart(document.getElementById('expiringOneMonthChart'), {
                type: 'bar',
                data: {
                    labels: expiringOneMonthData.labels,
                    datasets: [{
                        label: 'Days Left',
                        data: expiringOneMonthData.data,
                        backgroundColor: 'rgba(13, 110, 253, 0.6)',
                        borderColor: 'rgb(13, 110, 253)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Days Remaining' }
                        }
                    }
                }
            });
        }

        // --- Support Ticket Charts ---
        
        // 1. Top Clients (Bar Chart)
        const topClientsData = @json($dashboardData['topTicketClients']);
        if (topClientsData.labels.length > 0) {
            new Chart(document.getElementById('topTicketClientsChart'), {
                type: 'bar',
                data: {
                    labels: topClientsData.labels,
                    datasets: [{
                        label: 'Tickets',
                        data: topClientsData.data,
                        backgroundColor: 'rgba(78, 115, 223, 0.7)',
                        borderColor: '#4e73df',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y', // Horizontal Bar
                    scales: {
                        x: { beginAtZero: true }
                    },
                    plugins: { legend: { display: false } }
                }
            });
        }

        // 2. Tickets by Priority (Doughnut)
        const priorityData = @json($dashboardData['ticketsByPriority']);
        new Chart(document.getElementById('ticketsByPriorityChart'), {
            type: 'doughnut',
            data: {
                labels: ['Critical', 'High', 'Medium', 'Low', 'Feature', 'Info'],
                datasets: [{
                    data: [
                        priorityData.critical, 
                        priorityData.high, 
                        priorityData.medium, 
                        priorityData.low, 
                        priorityData.new_feature, 
                        priorityData.informational
                    ],
                    backgroundColor: ['#e74a3b', '#fd7e14', '#f6c23e', '#1cc88a', '#36b9cc', '#858796'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right', labels: { boxWidth: 10 } }
                }
            }
        });

        // 3. Tickets by Status (Pie)
        const statusData = @json($dashboardData['ticketsByStatus']);
        new Chart(document.getElementById('ticketsByStatusChart'), {
            type: 'pie',
            data: {
                labels: ['Open', 'Pending', 'Resolved', 'Closed'],
                datasets: [{
                    data: [
                        statusData.open, 
                        statusData.pending, 
                        statusData.resolved, 
                        statusData.closed
                    ],
                    backgroundColor: ['#4e73df', '#f6c23e', '#1cc88a', '#858796'],
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right', labels: { boxWidth: 10 } }
                }
            }
        });
    });
</script>
<style>
    .border-left-primary { border-left: 0.25rem solid #4e73df !important; }
    .border-left-success { border-left: 0.25rem solid #1cc88a !important; }
    .border-left-info { border-left: 0.25rem solid #36b9cc !important; }
    .border-left-warning { border-left: 0.25rem solid #f6c23e !important; }
    .text-gray-800 { color: #5a5c69 !important; }
    .text-gray-300 { color: #dddfeb !important; }
    .chart-area { position: relative; height: 300px; width: 100%; }
</style>
@endpush
@endsection
