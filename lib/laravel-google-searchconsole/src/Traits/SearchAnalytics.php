<?php

namespace Revolution\Google\SearchConsole\Traits;

use Revolution\Google\SearchConsole\Query\QueryInterface;

trait SearchAnalytics
{
    /**
     * @param string         $url
     * @param QueryInterface $query
     *
     * @return object
     */
    public function query(string $url, QueryInterface $query)
    {
        return $this->getService()->searchanalytics->query($url, $query)->toSimpleObject();
    }
}
