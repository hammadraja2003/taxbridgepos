<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\Table;
use Illuminate\Http\Request;
use DB;

class TableController extends Controller
{
    use \App\Traits\CacheForget;

    public function index()
    {
        $lims_table_all = Table::where('is_active', true)->get();

        $general_setting = GeneralSetting::latest()->first();
       
        return view('backend.table.index', compact('lims_table_all'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $data['is_active'] = true;
        $new = Table::create($data);

        $key_prefix = 'tenant_' . session('bus_config_id') . '_';
        $this->cacheForget($key_prefix . 'table_list');

        return redirect()->back()->with('message', __('db.Table created successfully'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $table = Table::find($request->table_id);
        $floor_prev_id = $table->floor_id;
        $table->update($request->all());

       
        $key_prefix = 'tenant_' . session('bus_config_id') . '_';
        $this->cacheForget($key_prefix . 'table_list');
        return redirect()->back()->with('message', __('db.Table updated successfully'));
    }

    public function destroy($id)
    {
        $table = Table::find($id);
        $table->update(['is_active' => false]);

       
        $key_prefix = 'tenant_' . session('bus_config_id') . '_';
        $this->cacheForget($key_prefix . 'table_list');
        return redirect()->back()->with('message', __('db.Table deleted successfully'));
    }
}
