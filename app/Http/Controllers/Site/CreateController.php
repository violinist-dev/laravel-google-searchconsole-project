<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Site;

class CreateController extends Controller
{
    /**
     * サイト追加
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function __invoke(Request $request)
    {
        $urls = $request->input('url');
        $refresh = $request->input('refresh_token');

        if (count($urls) == 0 or empty($refresh)) {
            return redirect('home');
        }

        foreach ($urls as $url) {
            $site = Site::withTrashed()
                        ->firstOrNew([
                            'url'     => $url,
                            'user_id' => $request->user()->id,
                        ]);

            if ($site->trashed()) {
                $site->restore();
            }

            $site->fill($request->only(['group', 'access_token', 'refresh_token']))
                 ->save();
        }

        return redirect('home');
    }
}
