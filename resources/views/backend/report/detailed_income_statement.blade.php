@extends('backend.layout.main')
@section('content')
<section class="forms">
    <div class="container-fluid">
        <h3 class="text-center">{{__('db.Income Statement')}}</h3>
        <div class="card mt-3">
            <div class="card-header">
                {!! Form::open(['route' => 'report.detailed_income_statement', 'method' => 'post']) !!}
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-tc mt-2"><strong>{{__('db.Choose Your Date')}}</strong> &nbsp;</label>
                            <div class="d-tc">
                                <div class="input-group">
                                    <input type="text" class="daterangepicker-field form-control" value="{{$start_date}} To {{$end_date}}" required />
                                    <input type="hidden" name="start_date" value="{{$start_date}}" />
                                    <input type="hidden" name="end_date" value="{{$end_date}}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-tc mt-2"><strong>{{__('db.Warehouse')}}</strong> &nbsp;</label>
                            <div class="d-tc">
                                <select name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                    <option value="0">{{__('db.All Warehouse')}}</option>
                                    @foreach($lims_warehouse_list as $warehouse)
                                        <option value="{{$warehouse->id}}" {{$warehouse_id == $warehouse->id ? 'selected' : ''}}>{{$warehouse->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-2 mt-4">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">{{__('db.submit')}}</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            <div class="card-body">
                <div class="table-responsive col-md-8 offset-md-2">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th class="text-right">Amount</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Revenue Section -->
                            <tr class="thead-light">
                                <th colspan="3"><strong>REVENUE</strong></th>
                            </tr>
                            <tr>
                                <td>Gross Sales</td>
                                <td class="text-right">{{number_format((float)$total_sales, $general_setting->decimal, '.', ',')}}</td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>Less: Sales Returns</td>
                                <td class="text-right text-danger">({{number_format((float)$sales_returns, $general_setting->decimal, '.', ',')}})</td>
                                <td></td>
                            </tr>
                            <tr class="font-weight-bold">
                                <td>NET SALES</td>
                                <td></td>
                                <td class="text-right">{{number_format((float)$net_sales, $general_setting->decimal, '.', ',')}}</td>
                            </tr>

                            <!-- COGS Section -->
                            <tr class="thead-light">
                                <th colspan="3"><strong>COST OF GOODS SOLD</strong></th>
                            </tr>
                            <tr>
                                <td>Cost of Goods Sold</td>
                                <td class="text-right text-danger">({{number_format((float)$cogs, $general_setting->decimal, '.', ',')}})</td>
                                <td></td>
                            </tr>
                            <tr class="font-weight-bold table-active">
                                <td>GROSS PROFIT</td>
                                <td></td>
                                <td class="text-right">{{number_format((float)$gross_profit, $general_setting->decimal, '.', ',')}}</td>
                            </tr>

                            <!-- Operating Expenses -->
                            <tr class="thead-light">
                                <th colspan="3"><strong>OPERATING EXPENSES</strong></th>
                            </tr>
                            @foreach($expenses_by_category as $expense)
                            <tr>
                                <td>{{ $expense->name }}</td>
                                <td class="text-right">{{number_format((float)$expense->total_amount, $general_setting->decimal, '.', ',')}}</td>
                                <td></td>
                            </tr>
                            @endforeach
                            <tr class="font-weight-bold">
                                <td>TOTAL OPERATING EXPENSES</td>
                                <td></td>
                                <td class="text-right text-danger">({{number_format((float)$total_operating_expenses, $general_setting->decimal, '.', ',')}})</td>
                            </tr>

                            <!-- Other Income -->
                            @if($total_other_income > 0)
                            <tr class="thead-light">
                                <th colspan="3"><strong>OTHER INCOME</strong></th>
                            </tr>
                            @foreach($incomes_by_category as $income)
                            <tr>
                                <td>{{ $income->name }}</td>
                                <td class="text-right">{{number_format((float)$income->total_amount, $general_setting->decimal, '.', ',')}}</td>
                                <td></td>
                            </tr>
                            @endforeach
                            <tr class="font-weight-bold">
                                <td>TOTAL OTHER INCOME</td>
                                <td></td>
                                <td class="text-right">{{number_format((float)$total_other_income, $general_setting->decimal, '.', ',')}}</td>
                            </tr>
                            @endif

                            <!-- Net Profit -->
                            <tr class="thead-dark font-weight-bold">
                                <td>NET PROFIT / (LOSS)</td>
                                <td></td>
                                <td class="text-right">{{number_format((float)$net_profit, $general_setting->decimal, '.', ',')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script type="text/javascript">
    $("ul#report").siblings('a').attr('aria-expanded','true');
    $("ul#report").addClass("show");
    $("ul#report #detailed-income-statement-menu").addClass("active");

    $(".daterangepicker-field").daterangepicker({
      callback: function(startDate, endDate, period){
        var start_date = startDate.format('YYYY-MM-DD');
        var end_date = endDate.format('YYYY-MM-DD');
        var title = start_date + ' To ' + end_date;
        $(this).val(title);
        $('input[name="start_date"]').val(start_date);
        $('input[name="end_date"]').val(end_date);
      }
    });
</script>
@endpush