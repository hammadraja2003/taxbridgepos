@extends('backend.layout.main')
@section('content')
<section class="forms">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header mt-2">
                <h3 class="text-center">{{__('db.Stock Report')}}</h3>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => 'report.stock_report', 'method' => 'post']) !!}
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="d-block" for="warehouse_id"><strong>{{__('db.Warehouse')}}</strong></label>
                            <select id="warehouse_id" name="warehouse_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                <option value="0">{{__('db.All Warehouse')}}</option>
                                @foreach($lims_warehouse_list as $warehouse)
                                <option value="{{$warehouse->id}}" {{ $warehouse_id == $warehouse->id ? 'selected' : '' }}>{{$warehouse->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="d-block" for="brand_id"><strong>{{__('db.Brand')}}</strong></label>
                            <select id="brand_id" name="brand_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                <option value="0">{{__('All Brand')}}</option>
                                @foreach($lims_brand_list as $brand)
                                <option value="{{$brand->id}}" {{ $brand_id == $brand->id ? 'selected' : '' }}>{{$brand->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="d-block" for="category_id"><strong>{{__('db.category')}}</strong></label>
                            <select id="category_id" name="category_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                <option value="0">{{__('All Category')}}</option>
                                @foreach($lims_category_list as $category)
                                <option value="{{$category->id}}" {{ $category_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label class="d-block" for="product_id"><strong>{{__('db.Product')}}</strong></label>
                            <select id="product_id" name="product_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" >
                                <option value="0">{{__('All Product')}}</option>
                                @foreach($lims_product_list_all as $product)
                                    <option value="{{$product->id}}" {{ $product_id == $product->id ? 'selected' : '' }}>{{$product->name}} ({{$product->code}})</option>
                                @endforeach
                            </select> 
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary">{{__('db.submit')}}</button>
                        <a href="{{route('report.stock_report')}}" class="btn btn-secondary">{{__('Reset')}}</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>

            <div class="table-responsive mb-4">
                <table id="report-table" class="table table-hover" style="width: 100%">
                    <thead>
                        <tr>
                            <th>{{__('db.Product Name')}}</th>
                            <th>{{__('db.Product Code')}}</th>
                            <th>{{__('db.Warehouse')}}</th>
                            <th>{{__('db.Brand')}}</th>
                            <th>{{__('db.category')}}</th>
                            <th>{{__('db.Quantity')}}</th>
                            <th>{{__('db.Price')}} (Excl)</th>
                            <th>{{__('db.Price')}} (Incl)</th>
                            <th>{{__('db.Cost')}}</th>
                            <th>{{__('Stock Value')}} (Price)</th>
                            <th>{{__('Stock Value')}} (Cost)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total_qty = 0;
                            $total_price_value = 0;
                            $total_cost_value = 0;
                        @endphp
                        @foreach($lims_product_list as $product)
                        @php
                            $tax_rate = $product->tax_rate ?? 0;
                            $price_excl = 0;
                            $price_incl = 0;

                            if($product->tax_method == 1) { // Exclusive
                                $price_excl = $product->price;
                                $price_incl = $product->price + ($product->price * $tax_rate / 100);
                            } else { // Inclusive
                                $price_incl = $product->price;
                                $price_excl = $product->price / (1 + ($tax_rate / 100));
                            }

                            $total_qty += $product->qty;
                            $total_price_value += ($product->price * $product->qty);
                            $total_cost_value += ($product->cost * $product->qty);
                        @endphp
                        <tr>
                            <td>{{$product->product_name}}</td>
                            <td>{{$product->product_code}}</td>
                            <td>{{$product->warehouse_name}}</td>
                            <td>{{$product->brand_name}}</td>
                            <td>{{$product->category_name}}</td>
                            <td>{{$product->qty}}</td>
                            <td>{{number_format($price_excl, 2)}}</td>
                            <td>{{number_format($price_incl, 2)}}</td>
                            <td>{{number_format($product->cost, 2)}}</td>
                            <td>{{number_format($product->price * $product->qty, 2)}}</td>
                            <td>{{number_format($product->cost * $product->qty, 2)}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5">Total</th>
                            <th>{{$total_qty}}</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th>{{number_format($total_price_value, 2)}}</th>
                            <th>{{number_format($total_cost_value, 2)}}</th>
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
</script>
@endpush
