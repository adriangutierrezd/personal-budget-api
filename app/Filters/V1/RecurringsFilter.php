<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;

class RecurringsFilter extends ApiFilter{

    protected $allowedParams = [
        'id' => ['eq'],
        'userId' => ['eq'],
        'categoryId' => ['eq'],
        'name' => ['eq'],
    ];

    protected $columnMap = [
        'userId' => 'user_id',
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
