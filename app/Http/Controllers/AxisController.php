<?php

namespace App\Http\Controllers;

use App\Models\AxisFeed;
use App\Models\PayGAxisFeed;
use App\Models\PayGICICIFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AxisController extends Controller
{
    public $totalPaygAxisCount, $axisFeed, $totalAxisCount, $paygAxisFeed, $axisFeedAllTransAmt, $paygAxisFeedAllTransAmt, $axisDiffAmount, $paygAxisDiffAmount;

    public function index()
    {
        $unmatchedTxnIdsForAxis = AxisFeed::leftJoin('payg_axis_feed', 'axis_feed.Txn Id', '=', 'payg_axis_feed.Processor RequestId')
            ->whereNull('payg_axis_feed.Processor RequestId')
            ->orWhereRaw("axis_feed.`Txn Id` != payg_axis_feed.`Processor RequestId`")
            ->count();

        $unmatchedTxnIdsForPaygAxis = PayGAxisFeed::leftJoin('axis_feed', 'axis_feed.Txn Id', '=', 'payg_axis_feed.Processor RequestId')
            ->whereNull('axis_feed.Txn Id')
            ->orWhereRaw("payg_axis_feed.`Processor RequestId` != axis_feed.`Txn Id`")
            ->count();


        $unmatchedTxnIdsForAxisList = AxisFeed::leftJoin('payg_axis_feed', 'axis_feed.Txn Id', '=', 'payg_axis_feed.Processor RequestId')
            ->whereNull('payg_axis_feed.Processor RequestId')
            ->orWhereRaw("axis_feed.`Txn Id` != payg_axis_feed.`Processor RequestId`")
            ->get();

        $unmatchedTxnIdsForPaygAxisList = PayGAxisFeed::leftJoin('axis_feed', 'payg_axis_feed.Processor RequestId', '=', 'axis_feed.Txn Id')
            ->whereNull('axis_feed.Txn Id')
            ->orWhereRaw("payg_axis_feed.`Processor RequestId` != axis_feed.`Txn Id`")
            ->get();

        $matchedTxnIdsForAxis = AxisFeed::leftJoin('payg_axis_feed', 'axis_feed.Txn Id', '=', 'payg_axis_feed.Processor RequestId')
            ->whereNotNull('payg_axis_feed.Processor RequestId')
            ->whereColumn('axis_feed.Txn Id', '=', 'payg_axis_feed.Processor RequestId')
            ->count();

        $matchedTxnIdsForPaygAxis = PayGAxisFeed::leftJoin('axis_feed', 'payg_axis_feed.Processor RequestId', '=', 'axis_feed.Txn Id')
            ->whereNotNull('axis_feed.Txn Id')
            ->whereColumn('payg_axis_feed.Processor RequestId', '=', 'axis_feed.Txn Id')
            ->count();

        $axisFeed = AxisFeed::orderBy('Amount', 'asc')->where('Response', 'Success')->paginate(20);
        $totalAxisCount = AxisFeed::count();
        $paygAxisFeed = PayGAxisFeed::orderBy('Authorized Amount', 'asc')->paginate(20);
        $totalPaygAxisCount = PayGAxisFeed::count();

        $axisFeedAllTransAmt = AxisFeed::leftJoin('payg_axis_feed', 'axis_feed.Txn Id', '=', 'payg_axis_feed.Processor RequestId')
            ->whereNotNull('payg_axis_feed.Processor RequestId')
            ->whereColumn('axis_feed.Txn Id', '=', 'payg_axis_feed.Processor RequestId')
            ->sum('axis_feed.Amount');

        $paygAxisFeedAllTransAmt = PayGAxisFeed::leftJoin('axis_feed', 'payg_axis_feed.Processor RequestId', '=', 'axis_feed.Txn Id')
            ->whereNotNull('axis_feed.Txn Id')
            ->whereColumn('payg_axis_feed.Processor RequestId', '=', 'axis_feed.Txn Id')
            ->sum('payg_axis_feed.Authorized Amount');

        $axisDiffAmount = $axisFeedAllTransAmt - $paygAxisFeedAllTransAmt;
        $paygAxisDiffAmount = $paygAxisFeedAllTransAmt - $axisFeedAllTransAmt;

        return view('axis_view', [
            'axisFeeds' => $axisFeed,
            'paygAxisFeeds' => $paygAxisFeed,
            'axisFeedAllTransAmt' => $axisFeedAllTransAmt,
            'paygAxisFeedAllTransAmt' => $paygAxisFeedAllTransAmt,
            'diffAmount' => $axisDiffAmount,
            'diffAmountt' => $paygAxisDiffAmount,
            'totalAxisCount' => $totalAxisCount,
            'totalPaygAxisCount' => $totalPaygAxisCount,
            'unmatchedTxnIdsForAxis' => $unmatchedTxnIdsForAxis,
            'unmatchedTxnIdsForPaygAxis' => $unmatchedTxnIdsForPaygAxis,
            'matchedTxnIdsForAxis' => $matchedTxnIdsForAxis,
            'matchedTxnIdsForPaygAxis' => $matchedTxnIdsForPaygAxis
        ],compact(
            'unmatchedTxnIdsForAxisList',
            'unmatchedTxnIdsForPaygAxisList'
        ));
    }
}
