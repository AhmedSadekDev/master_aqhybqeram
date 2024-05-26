<?php

namespace App\Console\Commands;

use App\Models\Notification;
use Illuminate\Console\Command;
use App\Models\User\UserSubscription;

class CheckUserSubsc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'magic:check-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check-user';

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
     * @return int
     */
    public function handle()
    {
        $lists = UserSubscription::where('active',1)->get();
        foreach($lists as $list) {
            if(\Carbon\Carbon::parse($list->end) < \Carbon\Carbon::now()) {
                $list->update([
                    'active'=>0
                ]);
                $title      = "تم الإنتهاء من الإشتراك الخاصه بك";
                $message    = "نعتذرا منك ولكن تم ايقاف الخدمه لإنتهاء الإشتراك";
                Notification::create([
                    'user_id'   => $list->user_id,
                    'model_id'  => $list->subscription_id,
                    'title'     => $title,
                    'message'   => $message,
                    'type'      => "subscription",
                ]);
                PushFireBaseNotification($title,$message,"system","customer",$list->user->dev_token ?? '');
            }
        }
    }
}
