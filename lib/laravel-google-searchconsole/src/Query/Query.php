<?php

namespace Revolution\Google\SearchConsole\Query;

use Google_Service_Webmasters_SearchAnalyticsQueryRequest as QueryRequest;

abstract class Query extends QueryRequest implements QueryInterface
{
    /**
     * Google_ModelのgapiInit()
     */
    protected function gapiInit()
    {
        $this->init();
    }

    abstract public function init();
}
