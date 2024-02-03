<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreRevenueRequest;
use App\Http\Requests\UpdateRevenueRequest;
use App\Models\Revenue;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RevenueCollection;
use App\Http\Resources\V1\RevenueResource;
use App\Filters\V1\RevenuesFilter;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new RevenuesFilter();
        $queryItems = $filter->transform($request);

        if(empty($queryItems)){
            return new RevenueCollection(Revenue::paginate());
        }else{
            $revenues = Revenue::where($queryItems)->paginate();
            return new RevenueCollection($revenues->appends($request->query()));
        }
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
    public function store(StoreRevenueRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Revenue $revenue)
    {
        return new RevenueResource($revenue);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Revenue $revenue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRevenueRequest $request, Revenue $revenue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Revenue $revenue)
    {
        //
    }
}
