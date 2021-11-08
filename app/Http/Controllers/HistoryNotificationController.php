<?php

namespace App\Http\Controllers;
use App\Models\HistoryNotification;


use Illuminate\Http\Request;

class HistoryNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['page_title'] = 'History Log';
        $notification = HistoryNotification::where('status', '!=', true);

        if ($request->has('notification')) {
            if (!($request->get('notification') == 'all')) {
                $notification = $notification->where('type', $request->get('notification'));
            }             
        }

        if ($request->get('start_from') != "" || $request->get('end_from') != "") {
            $start_from = date('Y-m-d 00:00:00', strtotime($request->get('start_from') ?? 'today'));
            $end_from = date('Y-m-d 23:59:59', strtotime($request->get('end_from') ?? 'today'));
            $notification = $notification->whereBetween('datetime', [$start_from, $end_from]);
        }

        $data['notifications'] = $notification->get();

        return view('notification.index', $data);
    }

}
