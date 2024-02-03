<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class CategoriesFilter extends ApiFilter{

    protected $allowedParams = [
        'id' => ['eq'],
        'userId' => ['eq'],
        'name' => ['eq'],
        'color' => ['eq']
    ];

    protected $columnMap = [
        'userId' => 'user_id'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];

}
