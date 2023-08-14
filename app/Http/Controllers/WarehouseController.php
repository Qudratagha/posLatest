<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;
use function Termwind\ValueObjects\w;

class WarehouseController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::orderByDesc('warehouseID')->get();
        return view('warehouse.index', compact('warehouses'));
    }

    public function create()
    {
        return view('warehouse.create');
    }

    public function store(Request $request)
    {
        Warehouse::create($request->all());
        $request->session()->flash('message', 'Warehouse created Successfully!');
        return to_route('warehouse.index');
    }

    public function show(Warehouse $warehouse)
    {
        return view('warehouse.show',compact('warehouse'));
    }

    public function edit(Warehouse $warehouse)
    {
        return view('warehouse.edit', compact('warehouse'));
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $warehouse->update($request->all());
        $request->session()->flash('message', 'Warehouse Updated successfully!');;

        return to_route('warehouse.index');
    }

    public function destroy(Warehouse $warehouse, Request $request)
    {
        $warehouse->delete();
        $request->session()->flash('error', 'Warehouse Deleted Successfully!');
        return to_route('warehouse.index');
    }
}
