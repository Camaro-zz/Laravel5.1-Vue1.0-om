<?php

namespace App\Http\Controllers\Customer;

use App\Services\CustomerService;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class CustomerController extends Controller
{
    public function __construct(CustomerService $customerService){
        $this->customerService = $customerService;
    }

    public function postCustomer(Request $request){
        $res = $this->customerService->addCustomer($request->all());
        return Response::json($res,200);
    }

    public function putCustomer($id, Request $request){
        $res = $this->customerService->editCustomer($id,$request->all());
        return Response::json($res,200);
    }

    public function getCustomer($id){
        $res = $this->customerService->getCustomer($id);
        return Response::json($res,200);
    }

    public function getCustomers(Request $request){
        $res = $this->customerService->getCustomers($request->all());
        return Response::json($res,200);
    }

    public function deleteCustomer(Request $request){
        $res = $this->customerService->deleteCustomer($request->all());
        return Response::json($res,200);
    }
}
