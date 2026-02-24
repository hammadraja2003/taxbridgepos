@extends('backend.layout.main')
@section('content')

<error-message key="not_permitted" />

<section class="forms">
    <div class="container-fluid">

        {{-- Top Bar: Count + Buttons --}}
        <div class="row mb-3">
            <div class="col-md-12">
                <span>Total: <strong id="total-count">0</strong></span> &nbsp;|&nbsp;
                <span>Assigned: <strong id="assigned-count">0</strong></span>
                &nbsp;&nbsp;
                <button type="button" id="select-all-btn" class="btn btn-sm btn-primary">Select All</button>
                <button type="button" id="deselect-all-btn" class="btn btn-sm btn-secondary">Deselect All</button>
            </div>
        </div>

        {!! Form::open(['route' => 'role.setPermission', 'method' => 'post']) !!}
        <input type="hidden" name="role_id" value="{{ $role->id }}">

        @php
            // Group all permissions by their prefix (part before first dash)
            $grouped = [];
            foreach ($permissions as $permission) {
                $parts  = explode('-', $permission->name, 2);
                $prefix = $parts[0];
                $grouped[$prefix][] = $permission;
            }

            // Define display groups: label => [prefixes that belong here]
            $displayGroups = [
                'Products & Catalog' => ['categories', 'brand', 'unit', 'products'],
                'Purchases'          => ['purchases', 'purchase'],
                'Sales'              => ['sales', 'sale', 'quotes', 'returns'],
                'Transfers'          => ['transfers'],
                'People'             => ['customers', 'billers', 'suppliers'],
                'Employees & Users'  => ['employees', 'users'],
                'Accounting'         => ['account', 'money', 'balance', 'expenses', 'incomes'],
                'HRM'                => ['hrm', 'department', 'designations', 'shift', 'overtime', 'leave', 'attendance', 'payroll', 'holiday'],
                'Reports'            => ['profit', 'best', 'daily', 'monthly', 'product', 'payment', 'challan', 'warehouse', 'dso', 'user', 'biller', 'customer', 'supplier', 'due', 'yearly'],
                'Settings'           => ['general', 'mail', 'sms', 'pos', 'barcode', 'language', 'reward', 'invoice', 'role', 'currency', 'tax', 'backup', 'discount', 'custom', 'all', 'send', 'create'],
                'Exports'            => ['product', 'purchase', 'sale', 'customer'],
                'POS'                => ['cart', 'handle'],
                'Sidebar'            => ['sidebar'],
                'Dashboard'          => ['revenue', 'cash', 'monthly', 'yearly'],
                'Addons'             => ['addons'],
                'FBR'                => ['fbr'],
                'Miscellaneous'      => [],
            ];

            // Friendly action labels
            $crudLabels = [
                'index'  => 'View',
                'add'    => 'Add',
                'edit'   => 'Edit',
                'delete' => 'Delete',
                'import' => 'Import',
            ];

            // Track assigned permission ids to avoid duplicates across groups
            $usedIds = [];
        @endphp

        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th style="width:200px">{{ __('db.Module Name') }}</th>
                        <th>{{ __('db.Permissions') }}</th>
                    </tr>
                </thead>
                <tbody>

                @foreach($displayGroups as $groupLabel => $prefixes)

                    @php
                        $groupPerms = collect();

                        if ($groupLabel === 'Miscellaneous') {
                            // Catch-all: anything not yet shown
                            foreach ($permissions as $perm) {
                                if (!in_array($perm->id, $usedIds)) {
                                    $groupPerms->push($perm);
                                }
                            }
                        } else {
                            foreach ($prefixes as $prefix) {
                                if (isset($grouped[$prefix])) {
                                    foreach ($grouped[$prefix] as $perm) {
                                        if (!in_array($perm->id, $usedIds)) {
                                            $groupPerms->push($perm);
                                            $usedIds[] = $perm->id;
                                        }
                                    }
                                }
                            }
                        }

                        if ($groupPerms->isEmpty()) continue;

                        // Sub-group within the group by prefix
                        $subGroups = [];
                        foreach ($groupPerms as $perm) {
                            $parts = explode('-', $perm->name, 2);
                            $sub   = $parts[0];
                            $subGroups[$sub][] = $perm;
                        }
                    @endphp

                    {{-- Group Header Row --}}
                    <tr class="table-secondary">
                        <td colspan="2">
                            <strong>{{ $groupLabel }}</strong>
                        </td>
                    </tr>

                    @foreach($subGroups as $subPrefix => $subPerms)
                        <tr>
                            <td class="align-middle pl-4">
                                {{ ucfirst($subPrefix) }}
                            </td>
                            <td>
                                <div class="d-flex flex-wrap">
                                    @foreach($subPerms as $perm)
                                        @php
                                            $isChecked   = in_array($perm->name, $rolePermissions);
                                            $isAllowed   = in_array($perm->name, $adminPermissions);
                                            $parts       = explode('-', $perm->name, 2);
                                            $action      = $parts[1] ?? $perm->name;
                                            $actionLabel = $crudLabels[$action] ?? ucfirst(str_replace('-', ' ', $action));
                                        @endphp

                                        <div class="form-check form-check-inline mr-3 mb-1">
                                            @if($isAllowed)
                                                <input type="checkbox"
                                                    name="{{ $perm->name }}"
                                                    value="1"
                                                    class="form-check-input"
                                                    id="perm_{{ $perm->id }}"
                                                    {{ $isChecked ? 'checked' : '' }}>
                                                <label class="form-check-label" for="perm_{{ $perm->id }}">
                                                    {{ $actionLabel }}
                                                </label>
                                            @else
                                                <input type="checkbox"
                                                    class="form-check-input"
                                                    disabled
                                                    {{ $isChecked ? 'checked' : '' }}
                                                    data-toggle="tooltip"
                                                    title="This permission is locked for you">
                                                <label class="form-check-label text-muted">
                                                    {{ $actionLabel }}
                                                    <i class="fa fa-lock text-danger"></i>
                                                </label>
                                            @endif
                                        </div>

                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endforeach

                @endforeach

                </tbody>
            </table>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary">{{ __('db.save') }}</button>
            </div>
        </div>

        {!! Form::close() !!}

    </div>
</section>

@endsection

@push('scripts')
<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    function updateCounts() {
        var total    = $('input.form-check-input[type="checkbox"]').length;
        var assigned = $('input.form-check-input[type="checkbox"]:checked').length;
        $('#total-count').text(total);
        $('#assigned-count').text(assigned);
    }

    updateCounts();

    $(document).on('change', 'input.form-check-input[type="checkbox"]', function () {
        updateCounts();
    });

    $('#select-all-btn').on('click', function () {
        $('input.form-check-input[type="checkbox"]:not(:disabled)').prop('checked', true);
        updateCounts();
    });

    $('#deselect-all-btn').on('click', function () {
        $('input.form-check-input[type="checkbox"]:not(:disabled)').prop('checked', false);
        updateCounts();
    });
});
</script>
@endpush