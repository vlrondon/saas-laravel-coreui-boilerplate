<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;

class Saas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:make {tenant}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new tenant';

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
     */
    public function handle(): void
    {
        $tenantName = $this->argument('tenant');
        $tenant = Tenant::create(['id' => $tenantName]);
        $domains = config('tenancy.central_domains');

        foreach ($domains as $domain){
            $tenant->domains()->create(['domain' => $tenantName . '.' . $domain]);
        }

        $this->info("{$tenantName} tenant created!");
    }
}
