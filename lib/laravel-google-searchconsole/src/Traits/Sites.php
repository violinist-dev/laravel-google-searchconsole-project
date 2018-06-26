<?php

namespace Revolution\Google\SearchConsole\Traits;

trait Sites
{
    /**
     * @param array $optParams
     *
     * @return object
     */
    public function listSites($optParams = [])
    {
        return $this->getService()->sites->listSites($optParams)->toSimpleObject();
    }
}
