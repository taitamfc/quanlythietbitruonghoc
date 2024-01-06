<?php

namespace Modules\Home\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('home::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('home::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('home::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('home::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }

        public function is_read(Request $request)
    {
        try {
            DB::beginTransaction();
            DB::table('notifications')->where('is_read', 0)->update(['is_read' => 1]);
            DB::commit();
            $unreadCount = DB::table('notifications')->where('is_read', 0)->count();
            return redirect()->back()->with('success', 'Đã đánh dấu tất cả là đã đọc.')->with('unreadCount', $unreadCount);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Có lỗi xảy ra.');
        }
    }
}