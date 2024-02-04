<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\StoreExpenseRequest;
use App\Http\Requests\UpdateExpenseRequest;
use App\Models\Expense;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ExpenseCollection;
use App\Filters\V1\ExpensesFilter;
use App\Http\Resources\V1\ExpenseResource;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = new ExpensesFilter();
        $queryItems = $filter->transform($request);

        $includeCategories = $request->query('includeCategories');

        $expenses = Expense::where($queryItems);

        if($includeCategories){
            $expenses->with('category');
        }

        return new ExpenseCollection($expenses->paginate()->appends($request->query()));
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
    public function store(StoreExpenseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Expense $expense)
    {

        $includeCategories = request()->query('includeCategories');

        if($includeCategories){
            return new ExpenseResource($expense->loadMissing('category'));
        }
        
        return new ExpenseResource($expense);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expense $expense)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expense $expense)
    {
        //
    }
}