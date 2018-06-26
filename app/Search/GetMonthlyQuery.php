<?php

namespace App\Search;

use Revolution\Google\SearchConsole\Query\Query;

class GetMonthlyQuery extends Query
{
    /**
     *
     */
    public function init()
    {
        $this->setDimensions(['query']);
        $this->setAggregationType(['auto']);
        $this->setRowLimit(config('sc.row_limit'));
    }
}
