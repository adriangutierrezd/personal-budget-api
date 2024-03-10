<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreRecurringRequest;
use App\Http\Requests\V1\UpdateRecurringRequest;
use App\Models\Recurring;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RecurringCollection;
use App\Http\Resources\V1\RecurringResource;
use App\Filters\V1\RecurringsFilter;
use App\Policies\V1\RecurringPolicy;
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

        $includeCategories = $request->query('includeCategories');

        $recurrings = Recurring::where([
            ...$queryItems,
            'user_id' => $request->user()->id
        ]);
        if($includeCategories){
            $recurrings->with('category');
        }

        return new RecurringCollection($recurrings->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecurringRequest $request)
    {
        return new RecurringResource(Recurring::create([
            ...$request->all(),
            'user_id' => $request->user()->id,
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Recurring $recurring)
    {

        if($request->user()->cannot('show', [$recurring, RecurringPolicy::class])){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $includeCategories = request()->query('includeCategories');

        if($includeCategories){
            return new RecurringResource($recurring->loadMissing('category'));
        }
        
        return new RecurringResource($recurring);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecurringRequest $request, Recurring $recurring)
    {
        $recurring->update([
            ...$request->all(),
            'user_id' => $request->user()->id
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Recurring $recurring)
    {
        if($request->user()->cannot('delete', [$recurring, RecurringPolicy::class])){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $recurring->delete();
    }
}
