<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use SearchConsole;

use Carbon\Carbon;

use App\Model\Site;
use App\Model\Total;

use App\Search\GetMonthlyQuery;

/**
 * 月ごとのデータ取得
 */
class GetMonthlyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Site
     */
    protected $site;

    /**
     * @var int
     */
    protected $sub;

    /**
     * Create a new job instance.
     *
     * @param Site $site
     * @param int  $sub 何ヶ月前かを指定。0なら今月。
     *
     * @return void
     */
    public function __construct($site, $sub = 1)
    {
        $this->site = $site;
        $this->sub = $sub;
    }

    /**
     * Execute the job.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function handle()
    {
        $date = Carbon::create(now()->year, now()->month, 1);
        $date->subMonthsNoOverflow($this->sub);

        //月初◯日までは先月分のデータ
        if (now()->day <= config('sc.day_shift') and 0 == $this->sub) {
            $date->subMonthsNoOverflow(1);
        }

        $start = $date->copy()->startOfMonth()->toDateString();
        $end = $date->copy()->endOfMonth()->toDateString();

        $site = $this->setAccessToken($this->site);

        $search = $this->queryRequest($start, $end);

        $query = $this->getQuery($site->url, $search);

        $total = Total::firstOrNew([
            'site_id' => $this->site->id,
            'month'   => $start,
        ]);

        $total->fill($query)->save();

        $this->site->fill(['fails' => 0])->save();
    }

    /**
     * @param string $url
     * @param mixed  $search
     *
     * @return array
     * @throws \Exception
     */
    private function getQuery($url, $search)
    {
        $query_rows = data_get(SearchConsole::query($url, $search), 'rows', []);

        $count = count($query_rows);

        $clicks = 0;
        $impressions = 0;
        $ctr = 0;
        $position = 0;

        if ($count > 0) {
            foreach ($query_rows as $row) {
                $clicks += $row->clicks;
                $impressions += $row->impressions;
                $ctr += $row->ctr;
                $position += $row->position;
            }

            $ctr = $ctr / $count;
            $ctr = round($ctr * 100, 2);
            $position = $position / $count;
            $position = round($position, 1);
        }

        return compact('clicks', 'impressions', 'ctr', 'position');
    }

    /**
     * @param string $start
     * @param string $end
     *
     * @return GetMonthlyQuery
     */
    private function queryRequest(string $start, string $end)
    {
        $request = [
            'startDate' => $start,
            'endDate'   => $end,
        ];

        $query = new GetMonthlyQuery($request);

        return $query;
    }

    /**
     * @param Site $site
     *
     * @return mixed
     */
    private function setAccessToken($site)
    {
        $access_token = [
            'access_token'  => $site->access_token,
            'refresh_token' => $site->refresh_token,
            'expires_in'    => 3600,
            'created'       => now()->subDay()->getTimestamp(),
        ];

        SearchConsole::setAccessToken($access_token);

        $token = SearchConsole::getAccessToken();

        if (empty($token['access_token'])) {
            logger()->critical("Invalid access_token: " . $site->url);
            $site->increment('fails');
        } else {
            $site->access_token = $token['access_token'];
            $site->save();
        }

        return $site;
    }

    /**
     * 失敗したジョブの処理
     *
     * @param  \Exception $exception
     *
     * @return void
     */
    public function failed(\Exception $exception)
    {
        $this->site->increment('fails');
    }
}
