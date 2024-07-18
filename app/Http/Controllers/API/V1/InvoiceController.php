<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\InvoiceFilters;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\BulkStoreInvoiceRequests;
use App\Http\Resources\V1\InvoiceCollection;
use App\Http\Resources\V1\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new InvoiceFilters();
        $filterItems = $filter->transform($request);

        $includeCustomer = $request->query('includeCustomer');

        $invoices = Invoice::where($filterItems);

        if ($includeCustomer) {
            $invoices = $invoices->with('customer');
        }
        return new InvoiceCollection($invoices->paginate()->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $includeCustomer = request()->query('includeCustomer');

        $invoice = Invoice::findOrFail($id);

        if ($includeCustomer) {
            return new InvoiceResource($invoice->loadMissing('customer'));
        }

        return new InvoiceResource(Invoice::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function bulkStore(BulkStoreInvoiceRequests $requests)
    {
        $bulk = collect($requests->all())->map(function ($arr, $key) {
           return Arr::except($arr, ['customerId', 'billedDate', 'paidDate']);
        });

        Invoice::insert($bulk->toArray());
    }
}
