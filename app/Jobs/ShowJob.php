<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Http\Request;

use App\Model\Site;

class ShowJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Site
     */
    protected $site;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($request, $site)
    {
        $this->request = $request;
        $this->site = $site;
    }

    /**
     * Execute the job.
     *
     * @return array
     */
    public function handle()
    {
        $year = $this->request->input('year', now()->subDays(config('sc.day_shift'))->year);
        $month = $this->request->input('month', now()->subDays(config('sc.day_shift'))->month);
        $dimension = $this->request->input('dimension', 'query');

        $site = $this->site;

        $result = GetRowsJob::dispatchNow($this->request, $site);

        $query_rows = data_get($result, 'rows', []);

        $count = count($query_rows);

        if ($count > 0) {
            $clicks = 0;
            $impressions = 0;
            $ctr = 0;
            $position = 0;

            foreach ($query_rows as $row) {
                $clicks += $row->clicks;
                $impressions += $row->impressions;
                $ctr += $row->ctr;
                $position += $row->position;
            }

            $ctr = $ctr / $count;
            $ctr = round($ctr * 100, 2) . '%';
            $position = $position / $count;
            $position = round($position, 1);
        }

        return compact([
            'site',
            'query_rows',
            'year',
            'month',
            'clicks',
            'impressions',
            'ctr',
            'position',
            'dimension',
        ]);
    }
}
