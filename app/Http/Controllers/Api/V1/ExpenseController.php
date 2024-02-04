<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\V1\StoreExpenseRequest;
use App\Http\Requests\V1\UpdateExpenseRequest;
use App\Models\Expense;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ExpenseCollection;
use App\Filters\V1\ExpensesFilter;
use App\Http\Resources\V1\ExpenseResource;
use Illuminate\Http\Request;
use App\Policies\V1\ExpensePolicy;

class ExpenseController extends Controller
{

    /**
     * Retrieves a listing of resources
     */
    public function index(Request $request)
    {
        $filter = new ExpensesFilter();
        $queryItems = $filter->transform($request);

        $includeCategories = $request->query('includeCategories');

        $expenses = Expense::where([
            ...$queryItems,
            'user_id' => $request->user()->id
        ]);

        if($includeCategories){
            $expenses->with('category');
        }

        return new ExpenseCollection($expenses->paginate()->appends($request->query()));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExpenseRequest $request)
    {
        return new ExpenseResource(Expense::create([
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
    public function show(Request $request, Expense $expense)
    {
        if($request->user()->cannot('show', [$expense, ExpensePolicy::class])){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $includeCategories = request()->query('includeCategories');

        if($includeCategories){
            return new ExpenseResource($expense->loadMissing('category'));
        }
        
        return new ExpenseResource($expense);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {

        $dateToUse = $request->date ? $request->date : $expense->date;

        $expense->update([
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
    public function destroy(Request $request, Expense $expense)
    {
        if($request->user()->cannot('delete', [$expense, ExpensePolicy::class])){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $expense->delete();
    }
}
