<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Site;

class PasswordController extends Controller
{

    /***
     * @param Request $request
     * @param Site    $site
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function __invoke(Request $request, Site $site)
    {
        $this->authorize('update', $site);

        $password = null;

        if ($request->filled('shared')) {
            $password = bcrypt($request->input('shared'));
        }

        $site->fill([
            'password' => $password,
        ])->save();

        return redirect()->route('sites.show', $site);
    }
}
