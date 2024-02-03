<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreRecurringRequest;
use App\Http\Requests\UpdateRecurringRequest;
use App\Models\Recurring;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RecurringCollection;
use App\Http\Resources\V1\RecurringResource;
use App\Filters\V1\RecurringsFilter;
use Illuminate\Http\Request;

class RecurringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new RecurringsFilter();
        $queryItems = $filter->transform($request);

        if(empty($queryItems)){
            return new RecurringCollection(Recurring::paginate());
        }else{
            $recurrings = Recurring::where($queryItems)->paginate();
            return new RecurringCollection($recurrings->appends($request->query()));
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
    public function store(StoreRecurringRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Recurring $recurring)
    {
        return new RecurringResource($recurring);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recurring $recurring)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecurringRequest $request, Recurring $recurring)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recurring $recurring)
    {
        //
    }
}
