<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageFeature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PackageController extends Controller
{
    // ---------------------------
    // List all packages
    // ---------------------------
    public function index()
    {
        $packages = Package::paginate(10);
        return view('admin.packages.index', compact('packages'));
    }

    // ---------------------------
    // Show form to create package
    // ---------------------------
    public function create()
    {
        return view('admin.packages.create');
    }

    // ---------------------------
    // Store new package
    // ---------------------------
    public function store(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string|max:255',
            'package_description' => 'nullable|string',
            'package_price' => 'required|numeric|min:0',
            'package_billing_cycle' => 'required|in:monthly,quarterly,yearly,custom',
            'feature_key' => 'required|array',
            'feature_key.*' => 'required|string|max:100',
        ]);

        DB::transaction(function () use ($request) {
            $package = Package::create([
                'package_name' => $request->package_name,
                'package_description' => $request->package_description,
                'package_price' => $request->package_price,
                'package_billing_cycle' => $request->package_billing_cycle,
            ]);

            if ($request->has('feature_key') && is_array($request->feature_key)) {
                foreach ($request->feature_key as $featureKey) {
                    PackageFeature::create([
                        'package_id' => $package->package_id,
                        'feature_key' => $featureKey
                    ]);
                }
            }
        });

        return redirect()->route('admin.packages.index')->with('success', 'Package created successfully.');
    }

    // ---------------------------
    // Show package edit form
    // ---------------------------
    public function edit($id)
    {
        try {
            $id = decrypt($id);
        } catch (\Exception $e) {
            abort(404);
        }
        $package = Package::with('features')->findOrFail($id);
        return view('admin.packages.edit', compact('package'));
    }

    // ---------------------------
    // Update package
    // ---------------------------
    public function update(Request $request, $id)
    {
        try {
            $id = decrypt($id);
        } catch (\Exception $e) {
            abort(404);
        }

        $request->validate([
            'package_name' => 'required|string|max:255',
            'package_description' => 'nullable|string',
            'package_price' => 'required|numeric|min:0',
            'package_billing_cycle' => 'required|in:monthly,quarterly,yearly,custom',
            'feature_key' => 'required|array',
            'feature_key.*' => 'required|string|max:100',
        ]);

        DB::transaction(function () use ($request, $id) {
            $package = Package::findOrFail($id);
            $package->update([
                'package_name' => $request->package_name,
                'package_description' => $request->package_description,
                'package_price' => $request->package_price,
                'package_billing_cycle' => $request->package_billing_cycle,
            ]);

            // Delete old features and insert new
            $package->features()->delete();

            if ($request->has('feature_key') && is_array($request->feature_key)) {
                foreach ($request->feature_key as $featureKey) {
                    PackageFeature::create([
                        'package_id' => $package->package_id,
                        'feature_key' => $featureKey
                    ]);
                }
            }
        });

        return redirect()->route('admin.packages.index')->with('success', 'Package updated successfully.');
    }

    // ---------------------------
    // Delete package
    // ---------------------------
    public function destroy($id)
    {
        try {
            $id = decrypt($id);
        } catch (\Exception $e) {
            abort(404);
        }
        $package = Package::findOrFail($id);
        $package->delete();
        return redirect()->route('admin.packages.index')->with('success', 'Package deleted successfully.');
    }
}
