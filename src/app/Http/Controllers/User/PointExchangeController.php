<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PointExchangeLog;
use Illuminate\Http\Request;

class PointExchangeController extends Controller
{
    public function updateApproved(Request $request, $id)
    {
        $point_exchange_log = PointExchangeLog::findOrFail($id);
        $point_exchange_log->status = PointExchangeLog::STATUS['APPROVED'];
        $point_exchange_log->save();

        return redirect()->route('admin.point-exchanges')->with(['flush.message' => '交換完了処理が正しく行われました', 'flush.alert_type' => 'success']);
    }
}
