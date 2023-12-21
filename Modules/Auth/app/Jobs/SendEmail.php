<?php

namespace Modules\Auth\app\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $item;
    protected $data;
    protected $type;
    /**
     * Create a new job instance.
     */
    public function __construct($item,$data,$type = '')
    {
        $this->item = $item;
        $this->data = $data;
        $this->type = $type;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $item = $this->item;
        $data = $this->data;
        $type = $this->type;
        switch ($type) {
            case 'store_member':
                try {
                    Mail::send('auth::mailMember',compact('data'), function($email) use ($item){
                        $email->subject('Store Member');
                        $email->to($item->email, $item->name );
                    });
                } catch (\Exception $e) {
                    Log::error('Bug send email error : '.$e->getMessage());
                }
                break;
            case 'forgot_pass':
                try {
                    Mail::send('auth::mailForgot',compact('data'), function($email) use ($item){
                        $email->subject('Forgot Password');
                        $email->to($item->email, $item->name );
                    });
                } catch (\Exception $e) {
                    Log::error('Bug send email error : '.$e->getMessage());
                }
                break;
        }
    }
}