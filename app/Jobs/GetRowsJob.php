<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Model\Site;
use App\Search\ShowQuery;

class GetRowsJob implements ShouldQueue
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
     * @return mixed
     */
    public function handle()
    {
        $this->site->load([
            'totals' => function ($query) {
                $query->orderBy('month', 'desc');
            },
        ]);

        $year = $this->request->input('year', now()->subDays(config('sc.day_shift'))->year);
        $month = $this->request->input('month', now()->subDays(config('sc.day_shift'))->month);
        $dimension = $this->request->input('dimension', 'query');
        $filter_expression = $this->request->input('filter', '');
        $filter_dimension = $this->request->input('filter_dimension', '');

        $date = Carbon::create($year, $month);

        $request = [
            'startDate'  => $date->copy()->startOfMonth()->toDateString(),
            'endDate'    => $date->copy()->endOfMonth()->toDateString(),
            'dimensions' => [$dimension],
        ];

        $sc = $this->site->searchconsole();

        $token = $sc->getAccessToken();

        if (empty($token['access_token'])) {
            logger()->critical("Invalid access_token: " . $this->site->url);
            //            $site->notify(new InvalidAccessToken($token));
            $this->site->increment('fails');
        } else {
            $this->site->access_token = $token['access_token'];
            $this->site->save();
        }

        $query = new ShowQuery($request);
        $query->filter($filter_dimension, $filter_expression);

        /**
         * @var object $query_rows
         */
        $query_rows = null;

        try {
            $query_rows = $sc->query($this->site->url, $query);

            $this->site->fill(['fails' => 0])->save();
        } catch (\Exception $e) {
            logger()->critical('Exception: ' . $e->getMessage());

            $this->site->increment('fails');
        }

        return $query_rows;
    }
}
