<?php

namespace App\Filters\V1;
use App\Filters\ApiFilter;

class EquityStatementsFilter extends ApiFilter{

    protected $allowedParams = [
        'id' => ['eq'],
        'categoryId' => ['eq'],
        'type' => ['eq'],
        'name' => ['eq'],
        'date' => ['eq', 'lt', 'lte', 'gt', 'gte'],
        'week' => ['eq', 'lt', 'lte', 'gt', 'gte'],
        'month' => ['eq', 'lt', 'lte', 'gt', 'gte'],
        'year' => ['eq', 'lt', 'lte', 'gt', 'gte']
    ];

    protected $columnMap = [
        'categoryId' => 'category_id'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'lte' => '<=',
        'gt' => '>',
        'gte' => '>=',
        'ne' => '!='
    ];


}
