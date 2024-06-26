<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreRevenueRequest;
use App\Http\Requests\V1\UpdateRevenueRequest;
use App\Models\Revenue;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RevenueCollection;
use App\Http\Resources\V1\RevenueResource;
use App\Filters\V1\RevenuesFilter;
use Illuminate\Http\Request;
use App\Policies\V1\RevenuePolicy;
use Illuminate\Support\Facades\DB;

class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new RevenuesFilter();
        $queryItems = $filter->transform($request);

        $revenues = Revenue::where([
            ...$queryItems,
            'user_id' => $request->user()->id
        ])->get();
        return new RevenueCollection($revenues);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRevenueRequest $request)
    {
        return new RevenueResource(Revenue::create([
            ...$request->all(),
            'user_id' => $request->user()->id,
            'week' => date('W', strtotime($request->date)),
            'month' => date('n', strtotime($request->date)),
            'year' => date('Y', strtotime($request->date)),
        ]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Revenue $revenue)
    {
        if($request->user()->cannot('show', [$revenue, RevenuePolicy::class])){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return new RevenueResource($revenue);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRevenueRequest $request, Revenue $revenue)
    {
        $dateToUse = $request->date ? $request->date : $revenue->date;

        $revenue->update([
            ...$request->all(),
            'user_id' => $request->user()->id,
            'week' => date('W', strtotime($dateToUse)),
            'month' => date('n', strtotime($dateToUse)),
            'year' => date('Y', strtotime($dateToUse)),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Revenue $revenue)
    {
        if($request->user()->cannot('delete', [$revenue, RevenuePolicy::class])){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $revenue->delete();
    }


    public function revenuesByMonth(Request $request){
        $filter = new RevenuesFilter();
        $queryItems = $filter->transform($request);

        $expenses = DB::table('revenues as e')
            ->select('month', 'year', DB::raw('ROUND(SUM(amount), 2) as total'), DB::raw('CONCAT(year, "-", LPAD(month, 2, "0")) as yearMonth'))
            ->where([
                ...$queryItems,
                'e.user_id' => $request->user()->id
            ])
            ->groupBy('yearMonth', 'month', 'year')
            ->get();


        return response()->json([
            'data' => $expenses
        ]);
    }

}
