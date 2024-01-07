<?php
 
namespace App\View\Composers;
 
use App\Repositories\UserRepository;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
 
class AdminNotificationComposer
{
    /**
     * Create a new profile composer.
     */
    public function __construct() {}
 
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $cr_notifications = [];
        if (Auth::user()) {
            $items = Notification::whereIn('action', ['user_to_admin'])
                ->where('is_read', 0)
                ->orderBy('id', 'desc')->get();
            $cr_notifications = $items->toArray();
        }
        $view->with('cr_notifications', $cr_notifications);
    }
}