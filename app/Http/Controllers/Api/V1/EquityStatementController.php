<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreEquityStatementRequest;
use App\Http\Requests\V1\UpdateEquityStatementRequest;
use App\Models\EquityStatement;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\EquityStatementCollection;
use App\Filters\V1\EquityStatementsFilter;
use App\Http\Resources\V1\EquityStatementResource;
use Illuminate\Http\Request;
use App\Policies\V1\EquityStatementPolicy;
use Illuminate\Support\Facades\DB;

class EquityStatementController extends Controller
{

    /**
     * Retrieves a listing of resources
     */
    public function index(Request $request)
    {
        $filter = new EquityStatementsFilter();
        $queryItems = $filter->transform($request);

        $includeCategories = $request->query('includeCategories');

        $expenses = EquityStatement::where([
            ...$queryItems,
            'user_id' => $request->user()->id
        ]);

        if ($includeCategories) {
            $expenses->with('category');
        }

        return new EquityStatementCollection($expenses->get());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEquityStatementRequest $request)
    {
        return new EquityStatementResource(EquityStatement::create([
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
    public function show(Request $request, EquityStatement $equityStatement)
    {
        if ($request->user()->cannot('show', [$equityStatement, EquityStatementPolicy::class])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $includeCategories = request()->query('includeCategories');

        if ($includeCategories) {
            return new EquityStatementResource($equityStatement->loadMissing('category'));
        }

        return new EquityStatementResource($equityStatement);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEquityStatementRequest $request, EquityStatement $equityStatement)
    {

        $dateToUse = $request->date ? $request->date : $equityStatement->date;

        $equityStatement->update([
            ...$request->all(),
            'user_id' => $request->user()->id,
            'week' => date('W', strtotime($dateToUse)),
            'month' => date('n', strtotime($dateToUse)),
            'year' => date('Y', strtotime($dateToUse)),
        ]);

        return new EquityStatementResource(EquityStatement::find($equityStatement->id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, EquityStatement $equityStatement)
    {
        if ($request->user()->cannot('delete', [$equityStatement, EquityStatementPolicy::class])) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $equityStatement->delete();
    }


    public function equityPerDate(Request $request)
    {
        $filter = new EquityStatementsFilter();
        $queryItems = $filter->transform($request);

        $expenses = EquityStatement::select(
            'date',
            'week',
            'month',
            'year',
            DB::raw('CONCAT(year, "-", LPAD(month, 2, "0")) as yearMonth'),
            DB::raw('ROUND(SUM(CASE WHEN type = \'ASSET\' THEN amount ELSE amount * -1 END), 2) as totalEquity')
        )
            ->where([
                ...$queryItems,
                'user_id' => $request->user()->id
            ])
            ->groupBy('yearMonth', 'month', 'year', 'week', 'date')
            ->get();


        return response()->json([
            'data' => $expenses
        ]);
    }
}
