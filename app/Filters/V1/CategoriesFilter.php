<?php

namespace App\Filters\V1;
use App\Filters\ApiFilter;

class CategoriesFilter extends ApiFilter{

    protected $allowedParams = [
        'id' => ['eq'],
        'name' => ['eq'],
        'color' => ['eq'],
        'type' => ['eq']
    ];

    protected $columnMap = [];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>='
    ];

}
