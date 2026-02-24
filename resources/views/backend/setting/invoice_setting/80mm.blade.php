<!DOCTYPE html>
<html>
@php
    $show = json_decode($invoice_settings->show_column);
@endphp

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="{{ url('logo', $general_setting->site_logo) }}" />
    <title>{{ $general_setting->site_title }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">

    <style type="text/css">
        * {
            font-size: 12px !important;
            line-height: 24px;
            font-family: 'Ubuntu', sans-serif;
            text-transform: capitalize;
        }
        body{
            font-size: 12px !important;
            margin: 0;
            padding: 0;
        }

        .btn {
            padding: 7px 10px;
            text-decoration: none;
            border: none;
            display: block;
            text-align: center;
            margin: 7px;
            cursor: pointer;
        }

        .btn-info {
            background-color: #999;
            color: #FFF;
        }

        .btn-primary {
            background-color: #5579a4;
            color: #FFF;
            width: 100%;
        }

        td,
        th,
        tr,
        table {
            border-collapse: collapse;
        }

        tr {
            border-bottom: 1px dotted #999;
        }

        td,
        th {
            padding: 7px 0;
            width: 50%;
        }

        table {
            width: 100%;
        }

        tfoot tr th:first-child {
            text-align: left;
        }

        .centered {
            text-align: center;
            align-content: center;
        }

        small {
            font-size: 11px;
        }

        @media print {
            * {
                font-size: 12px;
                line-height: 18px;/* line-height: 20px; */
            }

            td,
            th {
                padding: 5px 0;
            }

            .hidden-print {
                display: none !important;
            }

            @page {
                /* margin: 1.5cm 0.5cm 0.5cm; */
                margin: 0.3cm 0.2cm 0.3cm;
            }

            @page: first {
                margin-top: 0.5cm;
            }

            /*tbody::after {
                content: ''; display: block;
                page-break-after: always;
                page-break-inside: avoid;
                page-break-before: avoid;
            }*/
        }

        td, th {
            /* padding: 2px 0; */
            padding: 2px 3px;
            width: auto !important;
        }
    </style>
</head>

<body>

    <!-- <div style="max-width:290px;margin:0 auto"> -->
    <div style="max-width:300px;margin:0 auto;padding:0 2px">
        @if (preg_match('~[0-9]~', url()->previous()))
            @php $url = '../../pos'; @endphp
        @else
            @php $url = url()->previous(); @endphp
        @endif
        <div class="hidden-print">
            <table>
                <tr>
                    <td><a href="{{ $url }}" class="btn btn-info"><i class="fa fa-arrow-left"></i>
                            {{ __('db.Back') }}</a> </td>
                    <td><button onclick="window.print();" class="btn btn-primary"><i class="dripicons-print"></i>
                            {{ __('db.Print') }}</button></td>
                </tr>
            </table>
            <br>
        </div>

        <div id="receipt-data">
            @if (isset($show->show_warehouse_info) && $show->show_warehouse_info == 1)
                <div class="centered">
                    @if ($general_setting->site_logo || $invoice_settings->company_logo)
                    <img src="{{ $invoice_settings->company_logo ? url('invoices', $invoice_settings->company_logo) : url('logo', $general_setting->site_logo) }}"
                            height="{{ $invoice_settings->logo_height ?? auto }}" width="{{ $invoice_settings->logo_width ?? auto }}" style="margin:5px 0;">
                    @else
                    <h2 style="margin: 0 0 5px">{{ $general_setting->company_name }}</h2>
                    @endif
                    <p style="margin: 0 0 5px">{{ $lims_warehouse_data->address }}
                        <br>{{ $lims_warehouse_data->phone }}
                        @if ($general_setting->vat_registration_number && isset($show->show_vat_registration_number) && $show->show_vat_registration_number == 1)
                        <br>{{__('db.VAT Number')}}: {{$general_setting->vat_registration_number}}
                        @endif
                    </p>
                </div>
            @endif
            <p>{{ __('db.date') }}:
                @if (isset($show->active_date_format) && $show->active_date_format == 1)
                {{ Carbon\Carbon::parse($lims_sale_data->created_at)->format($invoice_settings->invoice_date_format) }}
                @else
                    {{ $lims_sale_data->created_at }}
                @endif
                <br>
                @if (isset($show->show_ref_number) && $show->show_ref_number == 1)
                {{ __('db.reference') }}: {{ $lims_sale_data->reference_no }}<br>
                @endif

                {{ __('db.customer') }}: {{ $lims_customer_data->name }}
            
                <?php
                foreach ($sale_custom_fields as $key => $fieldName) {
                    $field_name = str_replace(' ', '_', strtolower($fieldName));
                    echo '<br>' . $fieldName . ': ' . $lims_sale_data->$field_name;
                }
                foreach ($customer_custom_fields as $key => $fieldName) {
                    $field_name = str_replace(' ', '_', strtolower($fieldName));
                    echo '<br>' . $fieldName . ': ' . $lims_customer_data->$field_name;
                }
                ?>

            </p>
            <table class="table-data">
                <tr>
                    <th colspan="4" style="text-align: left;">{{ __('db.Item Description') }}</th>
                </tr>
                <tr>
                    <th style="text-align: left; width: 10%;"><small>Qty</small></th>
                    <th style="text-align: left; width: 30%;"><small>Price</small></th>
                    <th style="text-align: left; width: 20%;"><small>GST</small></th>
                    <th style="text-align: right; width: 40%;"><small>Total</small></th>
                </tr>
                <tbody>
                    <?php $total_product_tax = 0; ?>
                    @foreach ($lims_product_sale_data as $key => $product_sale_data)
                        <?php
                        $lims_product_data = \App\Models\Product::find($product_sale_data->product_id);
                        if ($product_sale_data->variant_id) {
                            $variant_data = \App\Models\Variant::find($product_sale_data->variant_id);
                            $product_name = $lims_product_data->name . ' [' . $variant_data->name . ']';
                        } elseif ($product_sale_data->product_batch_id) {
                            $product_batch_data = \App\Models\ProductBatch::select('batch_no')->find($product_sale_data->product_batch_id);
                            $product_name = $lims_product_data->name . ' [' . __('db.Batch No') . ':' . $product_batch_data->batch_no . ']';
                        } else {
                            $product_name = $lims_product_data->name;
                        }
                        // @dd($product_sale_data->imei_number);
                        if ($product_sale_data->imei_number && !str_contains($product_sale_data->imei_number, 'null')) {
                            $product_name .= '<br><small>' . trans('IMEI or Serial Numbers') . ': ' . $product_sale_data->imei_number . '</small>';
                        }

                        // Warranty
                        if (isset($product_sale_data->warranty_duration)) {
                            $product_name .= '<br>' . "<span style='font-weight: bold;'>Warranty</span>: " . $product_sale_data->warranty_duration;
                            $product_name .= '<br>' . "<span style='font-weight: bold;'>Will Expire</span>: " . $product_sale_data->warranty_end;
                        }
                        // Guarantee
                        if (isset($product_sale_data->guarantee_duration)) {
                            $product_name .= '<br>' . "<span style='font-weight: bold;'>Guarantee</span>: " . $product_sale_data->guarantee_duration;
                            $product_name .= '<br>' . "<span style='font-weight: bold;'>Will Expire</span>: " . $product_sale_data->guarantee_end;
                        }

                        $topping_names = [];
                        $topping_prices = [];
                        $topping_price_sum = 0;

                        if ($product_sale_data->topping_id) {
                            $decoded_topping_id = is_string($product_sale_data->topping_id) ? json_decode($product_sale_data->topping_id, true) : $product_sale_data->topping_id;

                            // dd(json_decode($product_sale_data->topping_id));
                            if (is_array($decoded_topping_id)) {
                                foreach ($decoded_topping_id as $topping) {
                                    $topping_names[] = $topping['name'];  // Extract name
                                    $topping_prices[] = $topping['price'];  // Extract price
                                    $topping_price_sum += $topping['price'];  // Sum up prices
                                }
                            }
                        }

                        $net_price_with_toppings = $product_sale_data->net_unit_price + $topping_price_sum;
                        $subtotal = $product_sale_data->total + $topping_price_sum;
                        ?>
                        @if (empty($show) || !isset($show->show_description) || $show->show_description == 1)
                            <tr style="border-top: 1px dotted #999">
                                <td colspan="4">
                                    <b>{!! $product_name !!}</b>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: left;">{{ $product_sale_data->qty }}</td>
                                <td style="text-align: left;">{{ $product_sale_data->net_unit_price }}</td>
                                <td style="text-align: left;">{{ $product_sale_data->tax }}</td>
                                <td style="text-align: right;">{{ $subtotal }}</td>
                            </tr>
                            
                            
                        @endif
                    @endforeach

                    <!-- <tfoot> -->
                    <tr>
                        <th colspan="2" style="text-align:left">{{ __('db.Total') }}</th>
                        <th colspan="2" style="text-align:right">
                            <x-amount-currency-symbol
                                :amount="$lims_sale_data->total_price"
                                :currency_symbol="$lims_sale_data->currency->symbol" />
                        </th>
                    </tr>
                    @if ($general_setting->invoice_format == 'gst' && $general_setting->state == 1)
                        <tr>
                            <th colspan="2" style="text-align:left">Sales Tax</th>
                            <th colspan="2" style="text-align:right">
                                <x-amount-currency-symbol
                                    :amount="$total_product_tax"
                                    :currency_symbol="$lims_sale_data->currency->symbol" />
                            </th>
                        </tr>
                    @endif
                    @if ($lims_sale_data->order_tax)
                        <tr>
                            <th colspan="2" style="text-align:left">{{ __('db.Order Tax') }}</th>
                            <th colspan="2" style="text-align:right">
                                <x-amount-currency-symbol
                                    :amount="$lims_sale_data->order_tax"
                                    :currency_symbol="$lims_sale_data->currency->symbol" />
                            </th>
                        </tr>
                    @endif
                    @if ($lims_sale_data->coupon_discount)
                        <tr>
                            <th colspan="2" style="text-align:left">{{ __('db.Coupon Discount') }}</th>
                            <th colspan="2" style="text-align:right">
                                <x-amount-currency-symbol
                                    :amount="$lims_sale_data->coupon_discount"
                                    :currency_symbol="$lims_sale_data->currency->symbol" />
                            </th>
                        </tr>
                    @endif
                    @if ($lims_sale_data->shipping_cost)
                        <tr>
                            <th colspan="2" style="text-align:left">{{ __('db.Shipping Cost') }}</th>
                            <th colspan="2" style="text-align:right">
                                <x-amount-currency-symbol
                                    :amount="$lims_sale_data->shipping_cost"
                                    :currency_symbol="$lims_sale_data->currency->symbol" />
                            </th>
                        </tr>
                    @endif
                    @if ($lims_sale_data->total_extra_tax)
                    <tr>
                        <th colspan="2" style="text-align:left">{{ __('db.Total Extra Tax') }}</th>
                        <th colspan="2" style="text-align:right">
                            <x-amount-currency-symbol
                                    :amount="$lims_sale_data->total_extra_tax"
                                    :currency_symbol="$lims_sale_data->currency->symbol" />
                        </th>
                    </tr>
                    @endif
                    @if ($lims_sale_data->total_further_tax)
                    <tr>
                        <th colspan="2" style="text-align:left">{{ __('db.Total Further Tax') }}</th>
                        <th colspan="2" style="text-align:right">
                            <x-amount-currency-symbol
                                    :amount="$lims_sale_data->total_further_tax"
                                    :currency_symbol="$lims_sale_data->currency->symbol" />
                        </th>
                    </tr>
                    @endif
                    @if ($lims_sale_data->total_fed_payable)
                    <tr>
                        <th colspan="2" style="text-align:left">{{ __('db.FED Payable') }}</th>
                        <th colspan="2" style="text-align:right">
                            <x-amount-currency-symbol
                                    :amount="$lims_sale_data->total_fed_payable"
                                    :currency_symbol="$lims_sale_data->currency->symbol" />
                        </th>
                    </tr>
                    @endif
                    
                    @if ($lims_sale_data->order_discount)
                        <tr>
                            <th colspan="2" style="text-align:left">{{ __('db.Order Discount') }}</th>
                            <th colspan="2" style="text-align:right">
                                <x-amount-currency-symbol
                                    :amount="$lims_sale_data->order_discount"
                                    :currency_symbol="$lims_sale_data->currency->symbol" />
                            </th>
                        </tr>
                    @endif
                    <tr>
                        <th colspan="2" style="text-align:left">{{ __('db.grand total') }}</th>
                        <th colspan="2" style="text-align:right">
                            <x-amount-currency-symbol
                                    :amount="$lims_sale_data->grand_total"
                                    :currency_symbol="$lims_sale_data->currency->symbol" />
                        </th>
                    </tr>
                    @if ($lims_sale_data->grand_total - $lims_sale_data->paid_amount > 0)
                        <tr>
                            <th colspan="2" style="text-align:left">{{ __('db.Due') }}</th>
                            <th colspan="2" style="text-align:right">
                                <x-amount-currency-symbol
                                    :amount="$lims_sale_data->grand_total - $lims_sale_data->paid_amount"
                                    :currency_symbol="$lims_sale_data->currency->symbol" />
                            </th>
                        </tr>
                    @endif
                    @if ($totalDue && isset($show->hide_total_due))
                        <tr>
                            @if (!$show->hide_total_due)
                            <th colspan="2" style="text-align:left">{{ __('db.Total Due') }}</th>
                            <th colspan="2" style="text-align:right">
                                <x-amount-currency-symbol
                                    :amount="$totalDue"
                                    :currency_symbol="$lims_sale_data->currency->symbol" /></th>
                            @endif
                        </tr>
                    @endif
                    <tr>
                        @if (isset($show->show_in_words) && $show->show_in_words == 1)
                            @if ($general_setting->currency_position == 'prefix')
                                <th class="centered" colspan="4">{{ __('db.In Words') }}:
                                    <span>{{ $currency_code }}</span>
                                    <span>{{ str_replace('-', ' ', $numberInWords) }}</span>
                                </th>
                            @else
                                <th class="centered" colspan="4">{{ __('db.In Words') }}:
                                    <span>{{ str_replace('-', ' ', $numberInWords) }}</span>
                                    <span>{{ $currency_code }}</span>
                                </th>
                            @endif
                        @endif
                    </tr>
                    <tr>
                        @if (isset($show->show_sale_note) && isset($lims_sale_data->sale_note) && $show->show_sale_note)
                            <td colspan="4">
                               <p class=""> <strong>{{ __('db.Sale Note') }}:</strong>{{ $lims_sale_data->sale_note }}</p>
                            </td>
                        @endif
                    </tr>
                </tbody>
                <!-- </tfoot> -->
            </table>
            <table>
                <tbody>
                    @if (isset($show->show_paid_info) && $show->show_paid_info == 1)
                        @foreach ($lims_payment_data as $payment_data)
                            <tr style="background-color:#ddd;">
                                <td style="padding: 5px;width:30%;text-align:center;">{{ __('db.Payment') }}:
                                    {{ $payment_data->paying_method }}</td>
                                <td style="padding: 5px;width:40%;text-align:center;">{{ __('db.Amount') }}:
                                    <x-amount-currency-symbol
                                        :amount="$payment_data->amount + $payment_data->change"
                                        :currency_symbol="$lims_sale_data->currency->symbol" />
                                </td>
                                <td style="padding: 5px;width:30%;text-align:center;">{{ __('db.Change') }}:
                                    <x-amount-currency-symbol
                                        :amount="$payment_data->change"
                                        :currency_symbol="$lims_sale_data->currency->symbol" />
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    <tr>
                        <td class="centered" colspan="4" style="padding: 3px 0;">
                            @if (isset($show->show_biller_info) && $show->show_biller_info == 1)
                                <small>{{ __('db.Served By') }}: {{ $lims_bill_by['name'] }} - ({{ $lims_bill_by['user_name'] }})</small>
                            @endif
                            @if (isset($show->show_footer_text) && $show->show_footer_text == 1)
                                @if (isset($show->show_biller_info) && $show->show_biller_info == 1)
                                    <br>
                                @endif
                                <strong>{!! $invoice_settings->footer_text ?? __('db.Thank you for shopping with us Please come again') !!}</strong>
                            @endif
                        </td>
                    </tr>
                    @if ($lims_sale_data->is_posted_to_fbr == 1 && !empty($lims_sale_data->fbr_invoice_number))
                    <tr>
                        @php
                            $fbrQrText = $lims_sale_data->fbr_invoice_number;
                        @endphp
                        <td class="centered" colspan="4">
                            <?php echo '<img style="margin-top:10px;" src="data:image/png;base64,' . DNS2D::getBarcodePNG($fbrQrText, 'QRCODE') . '" alt="QRcode"   />'; ?>
                            <img src="https://www.switchertechno.com/wp-content/uploads/1.jpg" width="80px" style="margin-top:10px;"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="centered" colspan="4">
                            <small>
                                FBR Invoice # : {{ $lims_sale_data->fbr_invoice_number }}
                            </small>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td class="centered" colspan="4">
                            @if (isset($show->show_barcode) && $show->show_barcode == 1)
                                <?php echo '<img style="margin-top:10px;" src="data:image/png;base64,' . DNS1D::getBarcodePNG($lims_sale_data->reference_no, 'C128') . '" width="300" alt="barcode"   />'; ?>
                            @endif
                            <br>
                            @if (isset($show->show_qr_code) && $show->show_qr_code == 1)
                                <?php echo '<img style="margin-top:10px;" src="data:image/png;base64,' . DNS2D::getBarcodePNG($qrText, 'QRCODE') . '" alt="QRcode"   />'; ?>
                            @endif
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <p style="text-align:center;">
                <small>Developed By {{ $general_setting->developed_by }}</small> 
            </p>  
        </div>
    </div>

    <script type="text/javascript">
        localStorage.clear();

        function auto_print() {
            window.print();
        }
        setTimeout(auto_print, 1000);
    </script>

</body>

</html>
