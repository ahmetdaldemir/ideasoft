<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CustomerRequest;
use App\Repositories\Customer\CustomerInterface;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;
use App\Http\Resources\CustomerResource;

class CustomerController extends BaseController
{
    use ApiResponse;

    private CustomerInterface $customerRepository;

    public function __construct(CustomerInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function index()
    {
        $customer = $this->customerRepository->all();
        return $this->success([
            $customer
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        $customer = $this->customerRepository->create($request);

        return $this->success([
            new CustomerResource($customer)
        ],'Customer Saved');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Customer $Customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = $this->customerRepository->find($id);
        if (is_null($customer)) {
            return $this->error('Error','404',[
                'Customer not found.'
            ]);
        }

        return $this->success([
            new CustomerResource($customer)
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $Customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $customer = $this->customerRepository->update($request, $id);

        return $this->success([
            new CustomerResource($customer)
        ],'Customer Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Customer $Customer
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $customer = $this->customerRepository->delete($id);
        return $this->success([
            new CustomerResource($customer)
        ],'Customer Deleted.');
    }
}
