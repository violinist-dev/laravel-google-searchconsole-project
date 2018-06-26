<?php

namespace Revolution\Google\SearchConsole\Traits;

use Revolution\Google\SearchConsole\Contracts\Factory;

/**
 * use at User or another model
 */
trait SearchConsole
{
    /**
     * @return Factory
     * @throws \Exception
     */
    public function searchconsole()
    {
        $token = $this->tokenForSearchConsole();

        return app(Factory::class)->setAccessToken($token);
    }

    /**
     * Get the Access Token
     *
     * @return string|array
     */
    abstract protected function tokenForSearchConsole();
}
