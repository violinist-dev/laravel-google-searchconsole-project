<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Site;

class HideController extends Controller
{
    /**
     * @param Site $site
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function __invoke(Site $site)
    {
        $this->authorize('delete', $site);

        if ($site->exists) {
            $site->delete();
        }

        return redirect('/home');
    }
}
