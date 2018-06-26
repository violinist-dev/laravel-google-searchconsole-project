<?php

namespace App\Search;

use Revolution\Google\SearchConsole\Query\Query;

class ShowQuery extends Query
{
    public function init()
    {
        $this->setAggregationType(['auto']);
        $this->setRowLimit(config('sc.row_limit'));
    }

    /**
     * @param string $filter_dimension
     * @param string $filter_expression
     */
    public function filter(string $filter_dimension, string $filter_expression)
    {
        if (empty($filter_expression)) {
            return;
        }

        $filter = new \Google_Service_Webmasters_ApiDimensionFilter();
        $filter->setDimension($filter_dimension);
        $filter->setExpression($filter_expression);
        $filter->setOperator('equals');

        $filter_group = new \Google_Service_Webmasters_ApiDimensionFilterGroup();
        $filter_group->setFilters([$filter]);
        $this->setDimensionFilterGroups([$filter_group]);
    }
}
