<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $sites = $request->user()
                         ->sites()
                         ->orderBy('url')
                         ->with([
                             'totals' => function ($query) {
                                 $query->orderBy('month', 'desc');
                             },
                         ])->get();

        $input_group = $request->input('group', config('sc.group_all'));

        if (isset($sites[0]) and isset($sites[0]->totals[0])) {
            $this_month = $sites[0]->totals[0]->month->format('Y-m');
        }

        $groups = collect([config('sc.group_all'), config('sc.group_empty')]);

        $clicks = [];
        $impressions = [];
        $ctrs = [];
        $positions = [];

        //3ヶ月分のデータ
        foreach ($sites as $site) {
            if (!$groups->contains($site->group) and !empty($site->group)) {
                $groups->push($site->group);
            }

            for ($i = 0; $i <= 2; $i++) {
                $clicks[$site->id][] = $site->totals->has($i) ? $site->totals->get($i)->clicks : 0;
                $impressions[$site->id][] = $site->totals->has($i) ? $site->totals->get($i)->impressions : 0;
                $ctrs[$site->id][] = $site->totals->has($i) ? $site->totals->get($i)->ctr : 0;
                $positions[$site->id][] = $site->totals->has($i) ? $site->totals->get($i)->position : 0;
            }
        }

        return view('home')
            ->with(compact([
                'sites',
                'input_group',
                'groups',
                'this_month',
                'clicks',
                'impressions',
                'ctrs',
                'positions',
            ]));
    }
}
