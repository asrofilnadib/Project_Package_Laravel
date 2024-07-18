<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCustomerRequests;
use App\Http\Requests\V1\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerCollection;
use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;
use App\Filters\V1\CustomerFilters;
use Cassandra\Custom;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new CustomerFilters();
        $filterItems = $filter->transform($request); //[['column', 'operator', 'value']]

        $invoiceInclude = $request->query('includeInvoices');

        $customers = Customer::where($filterItems);

        if ($invoiceInclude) {
            $customers = $customers->with('invoice');
        }

        return new CustomerCollection($customers->paginate()->appends($request->query()));
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
    public function store(StoreCustomerRequests $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $invoiceInclude = request()->query('includeInvoices');

        $customer = Customer::findOrFail($id);

        if ($invoiceInclude) {
            return new CustomerResource($customer->loadMissing('invoice'));
        }

        return new CustomerResource($customer);
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
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
