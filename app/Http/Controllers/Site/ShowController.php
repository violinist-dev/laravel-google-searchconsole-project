<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Site;
use App\Exports\CsvExport;
use App\Http\Requests\SearchAnalyticsRequest;

use App\Jobs\ShowJob;
use App\Jobs\GetRowsJob;

class ShowController extends Controller
{
    /**
     * @param SearchAnalyticsRequest $request
     * @param Site                   $site
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function __invoke(SearchAnalyticsRequest $request, Site $site)
    {
        $this->authorize('view', $site);

        if ($request->input('action') === 'csv') {
            return $this->export($request, $site);
        } else {
            return $this->show($request, $site);
        }
    }

    /**
     * @param Request $request
     * @param Site    $site
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function show(Request $request, Site $site)
    {
        $compact = ShowJob::dispatchNow($request, $site);

        return view('sites.show')->with($compact);
    }

    /**
     * @param Request $request
     * @param Site    $site
     *
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Exception
     */
    public function export(Request $request, Site $site)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $rows = data_get(GetRowsJob::dispatchNow($request, $site), 'rows', []);

        $name = str_slug(str_replace(['https', 'http'], '', $site->url)) . '_' . $year . '-' . $month . '.csv';

        return (new CsvExport($rows))->download($name);
    }
}
