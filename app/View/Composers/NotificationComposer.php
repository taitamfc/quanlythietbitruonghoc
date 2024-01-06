<?php
 
namespace App\View\Composers;
 
use Illuminate\View\View;
use App\Repositories\Eloquents\UserRepository;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
class NotificationComposer
{
    /**
     * Create a new profile composer.
     */
    public function __construct() {}
 
    /**
     * Bind data to the view.
     */
    // public function compose(View $view): void
    // {
    //     Facades\View::composer('*', function (View $view) {
    //         $dataEmail = 'Phireus2002@gmail.com';
    //         $user = $this->user->getInfoUser($dataEmail);
    //         $view->with('profile', $user->profile);
    //     });
    // }

    public function compose(View $view): void
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $items = Notification::where('action', 'user_to_admin')
                ->where('is_read', 0)
                ->where('user_id', $user_id)
                ->orderBy('id', 'desc')->get();
            $view->with('cr_notifications', $items);
        } else {
            // Set $cr_notifications to an empty array if not authenticated
            $view->with('cr_notifications', []);
        }
    }
    
    
}