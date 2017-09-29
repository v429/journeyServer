<?php


class InitSeeder extends \Illuminate\Database\Seeder {

    public function run()
    {
        \App\Services\rbacService::initRootUser();
        \App\Services\rbacService::initAuths();
    }


}