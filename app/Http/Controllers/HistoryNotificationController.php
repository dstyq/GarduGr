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
    public function index()
    {
        $data['page_title'] = 'History Log';
        $data['notifications'] = HistoryNotification::where('status', '!=', true)->get();

        return view('notification.index', $data);
    }

}
