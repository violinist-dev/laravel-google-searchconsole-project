<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Total;

class MemoController extends Controller
{
    public function __invoke(Request $request, $site, $memo)
    {
        $total = Total::findOrFail($memo);

        $this->authorize('update', $total->site);

        $total->memo = $request->input('memo');
        $total->memo_at = now();

        $total->save();

        return back()->with('message', 'メモを更新しました。');
    }
}
