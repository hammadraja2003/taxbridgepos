
    public function getCustomerSales($customer_id)
    {
        $lims_sale_data = Sale::where('customer_id', $customer_id)->orderBy('created_at', 'desc')->pluck('reference_no', 'id');
        return json_encode($lims_sale_data);
    }

    public function billProfitabilityReport(Request $request)
    {
        $role = Role::find(Auth::user()->role_id);
        if ($role->hasPermissionTo('profit-loss')) {
            $start_date = $request->input('start_date', date('Y-m-d'));
            $end_date = $request->input('end_date', date('Y-m-d'));
            $customer_id = $request->input('customer_id', 0);
            $sale_id = $request->input('sale_id', []);

            $lims_customer_list = \App\Models\Customer::where('is_active', true)->get();
            $lims_sale_list = [];
            if($customer_id)
                $lims_sale_list = Sale::where('customer_id', $customer_id)->orderBy('created_at', 'desc')->get();

            $general_setting = getGeneralSetting();
            $lims_profitability_data = [];

            if($request->isMethod('post')) {
                 $query = DB::table('product_sales')
                    ->join('sales', 'product_sales.sale_id', '=', 'sales.id')
                    ->join('products', 'product_sales.product_id', '=', 'products.id')
                    ->join('customers', 'sales.customer_id', '=', 'customers.id');

                if (!empty($sale_id)) {
                    $query->whereIn('sales.id', $sale_id);
                } else {
                    $query->whereDate('sales.created_at', '>=', $start_date);
                    $query->whereDate('sales.created_at', '<=', $end_date);
                    if ($customer_id) {
                        $query->where('sales.customer_id', $customer_id);
                    }
                }
                
                $lims_profitability_data = $query->select(
                    'sales.created_at',
                    'sales.reference_no',
                    'customers.name as customer_name',
                    'products.name as product_name',
                    'products.code as product_code',
                    'products.cost', 
                    'product_sales.qty',
                    'product_sales.total', 
                )->orderBy('sales.created_at', 'desc')->get();
            }
            
            // Needed for view to avoid undefined variable if reused from other view
            $lims_product_list_all = []; 

            return view('backend.report.bill_profitability_report', compact('lims_customer_list', 'lims_sale_list', 'lims_profitability_data', 'start_date', 'end_date', 'customer_id', 'sale_id', 'general_setting', 'lims_product_list_all'));
        }
        else
            return redirect()->back()->with('not_permitted', __('db.Sorry! You are not allowed to access this module'));
    }
