<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SearchAnalyticsRequest;

use App\Model\Site;
use App\Model\Total;
use App\Jobs\ShowJob;

class ShareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.share')->except(['form', 'login']);
    }

    /**
     * @param SearchAnalyticsRequest $request
     * @param int                    $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(SearchAnalyticsRequest $request, $id)
    {
        $site = Site::findOrFail($id);

        $compact = ShowJob::dispatchNow($request, $site);

        return view('share.show')->with($compact);
    }

    /**
     * @param Request $request
     * @param         $site
     * @param         $memo
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function memo(Request $request, $site, $memo)
    {
        abort_unless(Site::findOrFail($site)->id === auth()->guard('site')->user()->id, 404);

        $total = Total::findOrFail($memo);

        $total->memo = $request->input('memo');
        $total->memo_at = now();

        $total->save();

        return back()->with('message', 'メモを更新しました。');
    }

    /**
     * @param int $site
     *
     * @return \Illuminate\Http\Response
     */
    public function form($site)
    {
        return view('share.login')->with(compact('site'));
    }

    /**
     * @param Request $request
     * @param int     $site
     *
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function login(Request $request, $site)
    {
        if (auth()->guard('site')->attempt(['id' => $site, 'password' => $request->input('password')])) {
            return redirect()->intended(route('share.show', $site))
                             ->withCookie('login_' . $site, true, 60 * 24);

        } else {
            return redirect()->intended('/');
        }
    }
}
