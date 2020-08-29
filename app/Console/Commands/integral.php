<?php

namespace App\Console\Commands;

use App\User;
use App\Models\UserIntegral;
use Illuminate\Console\Command;

class Integral extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integral';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'integral';

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
        $beginLastweek= date("Y-m-d",mktime(0,0,0,date('m'),date('d')-date('w')+1-7,date('Y')));  
        $endLastweek= date("Y-m-d",mktime(23,59,59,date('m'),date('d')-date('w')+7-7,date('Y'))); 
        // "YEARWEEK(date_format(updated_at,'%Y-%m-%d')) = YEARWEEK(now())-1" 
        $data = UserIntegral::whereBetween("updated_at",[$beginLastweek,$endLastweek])->orderBy('integral','desc')->get()->toArray();
        foreach ($data as $k => $v) {
            \Log::info('user-data : '. json_encode($v));
        }
        
        print_r($data);die;
    }
}