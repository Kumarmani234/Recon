<?php

namespace App\Http\Controllers;

use App\Models\ICICIFeed;
use App\Models\PayGICICIFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ICICIController extends Controller
{
    public $totalICICICount, $totalPaygICICIcount, $iciciFeed, $paygIciciFeed, $iciciFeedAllTransAmt, $paygIciciFeedAllTransAmt, $iciciDiffAmount, $paygIciciDiffAmount;

    public function index()
    {
        $unmatchedTxnIdsForICICI = ICICIFeed::leftJoin('payg_icici_feed', 'icici_feed.merchantTranID', '=', 'payg_icici_feed.Processor RequestId')
            ->whereNull('payg_icici_feed.Processor RequestId')
            ->orWhereRaw("icici_feed.merchantTranID != payg_icici_feed.`Processor RequestId`")
            ->count();

        $unmatchedTxnIdsForPaygICICI = PayGICICIFeed::leftJoin('icici_feed', 'icici_feed.merchantTranID', '=', 'payg_icici_feed.Processor RequestId')
            ->whereNull('icici_feed.merchantTranID')
            ->orWhereRaw("payg_icici_feed.`Processor RequestId` != icici_feed.merchantTranID")
            ->count();


        $unmatchedTxnIdsForICICIList = ICICIFeed::leftJoin('payg_icici_feed', 'icici_feed.merchantTranID', '=', 'payg_icici_feed.Processor RequestId')
            ->whereNull('payg_icici_feed.Processor RequestId')
            ->orWhereRaw("icici_feed.merchantTranID != payg_icici_feed.`Processor RequestId`")
            ->get();

        $unmatchedTxnIdsForPaygICICIList = PayGICICIFeed::leftJoin('icici_feed', 'icici_feed.merchantTranID', '=', 'payg_icici_feed.Processor RequestId')
            ->whereNull('icici_feed.merchantTranID')
            ->orWhereRaw("payg_icici_feed.`Processor RequestId` != icici_feed.merchantTranID")
            ->get();


        $matchedTxnIdsForICICI = ICICIFeed::leftJoin('payg_icici_feed', 'icici_feed.merchantTranID', '=', 'payg_icici_feed.Processor RequestId')
            ->whereNotNull('payg_icici_feed.Processor RequestId')
            ->whereColumn('icici_feed.merchantTranID', '=', 'payg_icici_feed.Processor RequestId')
            ->count();

        $matchedTxnIdsForPaygICICI = PayGICICIFeed::leftJoin('icici_feed', 'payg_icici_feed.Processor RequestId', '=', 'icici_feed.merchantTranID')
            ->whereNotNull('icici_feed.merchantTranID')
            ->whereColumn('payg_icici_feed.Processor RequestId', '=', 'icici_feed.merchantTranID')
            ->count();

        $totalICICICount =  ICICIFeed::count();
        $totalPaygICICIcount = PayGICICIFeed::count();
        $iciciFeed = ICICIFeed::orderBy('amount', 'asc')->paginate(20);
        $paygIciciFeed = PayGICICIFeed::orderBy('Authorized Amount', 'asc')->paginate(20);

        $iciciFeedAllTransAmt = ICICIFeed::leftJoin('payg_icici_feed', 'icici_feed.merchantTranID', '=', 'payg_icici_feed.Processor RequestId')
            ->whereNotNull('payg_icici_feed.Processor RequestId')
            ->whereColumn('icici_feed.merchantTranID', '=', 'payg_icici_feed.Processor RequestId')
            ->sum('icici_feed.amount');

        $paygIciciFeedAllTransAmt = PayGICICIFeed::leftJoin('icici_feed', 'payg_icici_feed.Processor RequestId', '=', 'icici_feed.merchantTranID')
            ->whereNotNull('icici_feed.merchantTranID')
            ->whereColumn('payg_icici_feed.Processor RequestId', '=', 'icici_feed.merchantTranID')
            ->sum('payg_icici_feed.Authorized Amount');

        $iciciDiffAmount = $iciciFeedAllTransAmt - $paygIciciFeedAllTransAmt;
        $paygIciciDiffAmount = $paygIciciFeedAllTransAmt - $iciciFeedAllTransAmt;

        return view('icici_view', [
            'iciciFeed' => $iciciFeed,
            'paygIciciFeed' => $paygIciciFeed,
            'iciciFeedAllTransAmt' => $iciciFeedAllTransAmt,
            'paygIciciFeedAllTransAmt' => $paygIciciFeedAllTransAmt,
            'diffAmount' => $iciciDiffAmount,
            'diffAmountt' => $paygIciciDiffAmount,
            'totalICICICount' => $totalICICICount,
            'totalPaygICICIcount' => $totalPaygICICIcount,
            'unmatchedTxnIdsForICICI' => $unmatchedTxnIdsForICICI,
            'unmatchedTxnIdsForPaygICICI' => $unmatchedTxnIdsForPaygICICI,
            'matchedTxnIdsForICICI' => $matchedTxnIdsForICICI,
            'matchedTxnIdsForPaygICICI' => $matchedTxnIdsForPaygICICI
        ],compact(
            'unmatchedTxnIdsForICICIList',
            'unmatchedTxnIdsForPaygICICIList',
        ));
    }
}
