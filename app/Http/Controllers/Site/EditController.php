<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Site;

class EditController extends Controller
{
    /**
     * サイト設定画面
     *
     * @param Site $site
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Site $site)
    {
        $this->authorize('update', $site);

        return view('sites.edit')->with(compact('site'));
    }

    /**
     * サイト設定保存
     *
     * @param Request $request
     * @param Site    $site
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Site $site)
    {
        $this->authorize('update', $site);

        $site->fill($request->only(['title', 'group']))->save();

        return redirect()->route('sites.show', $site);
    }
}
