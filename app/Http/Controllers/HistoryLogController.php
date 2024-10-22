<?php

namespace App\Http\Controllers;

use App\Models\HistoryLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HistoryLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:history-log-list', ['only' => 'index']);
    }

    public function index()
    {
        $data['page_title'] = 'History Log';
        $data['breadcumb'] = 'History Log';
        $data['logs'] = HistoryLog::latest()->get();

        return view('history-logs.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HistoryLog  $historyLog
     * @return \Illuminate\Http\Response
     */
    public function show(HistoryLog $historyLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HistoryLog  $historyLog
     * @return \Illuminate\Http\Response
     */
    public function edit(HistoryLog $historyLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HistoryLog  $historyLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HistoryLog $historyLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HistoryLog  $historyLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(HistoryLog $historyLog)
    {
        try {
            DB::transaction(function () use ($historyLog) {
                $newHistoryLog = new HistoryLog();
                $newHistoryLog->datetime = date('Y-m-d H:i:s');
                $newHistoryLog->type = 'Delete History Log';
                $newHistoryLog->user_id = auth()->user()->id;
                $newHistoryLog->save();

                $historyLog->delete();
            });
    
            Session::flash('success', 'History Log deleted successfully!');
            return response()->json(['status' => '200']);
        } catch (\Throwable $th) {    
            Session::flash('failed', $th);
            return response()->json(['status' => '500']);
        }
    }
}
