<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Model\User;
use App\Model\Site;

use App\Jobs\GetMonthlyJob;

class GetMonth extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sc:get {sub=0 : 何ヶ月前のデータか指定}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '検索アナリティクスを取得';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $sub = (int)$this->argument('sub');

        $users = User::cursor();

        foreach ($users as $user) {
            /**
             * @var Site $sites
             */
            $sites = $user->sites()
                          ->where('fails', '<', 10)
                          ->orderBy('updated_at', 'asc')
                          ->when($sub === 0, function ($query) {
                              //今月の場合のみ一定数ずつ取得。先月分は1回で全部。
                              return $query->take(config('sc.site_take'));
                          })
                          ->get();

            if ($sites->count() === 0) {
                continue;
            }

            $this->info($user->name);

            $this->getSites($sites, $sub);
        }
    }

    /**
     * @param Site $sites
     * @param int  $sub
     */
    private function getSites($sites, $sub)
    {
        foreach ($sites as $site) {
            $this->info($site->url);
            GetMonthlyJob::dispatchNow($site, $sub);
        }
    }
}
