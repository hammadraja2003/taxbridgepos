@extends('backend.layout.main')
@section('content')
<section class="forms">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header mt-2">
                <h3 class="text-center">{{__('db.Bill Profitability Report')}}</h3>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => 'report.bill_profitability_report', 'method' => 'post']) !!}
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="d-block" for="start_date"><strong>{{__('db.Start Date')}}</strong></label>
                            <input type="text" name="start_date" class="form-control date" value="{{$start_date}}" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="d-block" for="end_date"><strong>{{__('db.End Date')}}</strong></label>
                            <input type="text" name="end_date" class="form-control date" value="{{$end_date}}" />
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="d-block" for="customer_id"><strong>{{__('db.customer')}}</strong></label>
                            <select id="customer_id" name="customer_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" required>
                                <option value="0">{{__('All Customer')}}</option>
                                @foreach($lims_customer_list as $customer)
                                <option value="{{$customer->id}}" {{ $customer_id == $customer->id ? 'selected' : '' }}>{{$customer->name}} ({{$customer->phone_number}})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                         <div class="form-group">
                            <label class="d-block" for="sale_id"><strong>{{__('db.Sale')}} (Bill)</strong></label>
                            <select id="sale_id" name="sale_id[]" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" multiple>
                                @foreach($lims_sale_list as $sale)
                                    <option value="{{$sale->id}}" {{ in_array($sale->id, $sale_id) ? 'selected' : '' }}>{{$sale->reference_no}}</option>
                                @endforeach
                            </select> 
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">{{__('db.submit')}}</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

            <div class="table-responsive mb-4">
                <table id="report-table" class="table table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <th>{{__('db.date')}}</th>
                            <th>{{__('db.reference')}}</th>
                            <th>{{__('db.customer')}}</th>
                            <th>{{__('db.Product')}}</th>
                            <th>{{__('db.Quantity')}}</th>
                            <th>{{__('Sale Price')}}</th>
                            <th>{{__('db.Cost')}}</th>
                            <th>{{__('db.profit')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_qty = 0;
                            $total_sale_price = 0;
                            $total_cost = 0;
                            $total_profit = 0;
                        @endphp
                        @foreach($lims_profitability_data as $data)
                        @php
                            // Calculate Sale Price (Net Unit Price * Quantity) - Discount + Tax if needed, usually Net Sale Amount
                            // Here assuming 'total' from product_sales is the row total (price * qty - discount + tax)
                            // Cost is (product cost * qty)
                            
                            $sale_price = $data->total; 
                            $cost = $data->cost * $data->qty;
                            $profit = $sale_price - $cost;

                            $total_qty += $data->qty;
                            $total_sale_price += $sale_price;
                            $total_cost += $cost;
                            $total_profit += $profit;
                        @endphp
                        <tr>
                            <td>
                                {{ date($general_setting->date_format, strtotime($data->created_at)) }}
                            </td>
                            <td>{{$data->reference_no}}</td>
                            <td>{{$data->customer_name}}</td>
                            <td>{{$data->product_name}} ({{$data->product_code}})</td>
                            <td>{{$data->qty}}</td>
                            <td>{{number_format($sale_price, $general_setting->decimal, '.', '')}}</td>
                            <td>{{number_format($cost, $general_setting->decimal, '.', '')}}</td>
                            <td>{{number_format($profit, $general_setting->decimal, '.', '')}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">Total</th>
                            <th>{{$total_qty}}</th>
                            <th>{{number_format($total_sale_price, $general_setting->decimal, '.', '')}}</th>
                            <th>{{number_format($total_cost, $general_setting->decimal, '.', '')}}</th>
                            <th>{{number_format($total_profit, $general_setting->decimal, '.', '')}}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");

    // Initialize date pickers with the values from PHP variables
    var start_date = "{{$start_date}}";
    var end_date = "{{$end_date}}";

    $('input[name="start_date"]').val(start_date);
    $('input[name="end_date"]').val(end_date);

    $('.date').datepicker({
     format: "yyyy-mm-dd",
     autoclose: true,
     todayHighlight: true
     });
    
    $('#report-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ {{__("db.records per page")}}',
             "info":      '<small>{{__("db.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search":  '{{__("db.Search")}}',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );

    // AJAX to fetch bills for selected customer
    $('#customer_id').on('change', function() {
        var customer_id = $(this).val();
        // Clear current options
        $('#sale_id').empty();
        $('#sale_id').selectpicker('refresh');
        
        if (customer_id > 0) {
            $.ajax({
                url: '{{url("report/get_customer_sales")}}/' + customer_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $.each(data, function(key, value) {
                        $('#sale_id').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                     $('#sale_id').selectpicker('refresh');
                }
            });
        }
    });

    // Handle date change to filter bills if needed? No, let's keep it simple: Filter bills by Customer only for now.
    // If date range is crucial for limiting the bill list, we can pass dates to the ajax call.
    // Given the requirement "customer select -> bills appear", it implies customer is the main driver.

</script>
@endpush
