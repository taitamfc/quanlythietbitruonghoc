<?php

namespace App\Listeners;

use App\Events\BorrowCreated as BorrowCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BorrowCreated
{
    protected $item;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BorrowCreatedEvent $event): void
    {
        $auto_approved = \App\Models\Option::get_option('borrow_device','auto_approved',1);
        if($auto_approved){
            $event->item->status = 1;
            $event->item->save();

            // Gửi tới nhân viên quản lý thiết bị
            \App\Models\Notification::addNotification(1, 'new_borrow', 'site_to_user', $event->item->id);
        }
    }
}
