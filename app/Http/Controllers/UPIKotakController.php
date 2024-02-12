<?php

namespace App\Http\Controllers;

use App\Models\KotakFeed;
use App\Models\PayGKotakFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UPIKotakController extends Controller
{
    public function index()
    {
        $results = KotakFeed::select('NVL_TSDK ORDERID', 'AMOUNT')
        ->join('payg_kotak_feed', 'NVL_TSDK ORDERID', '=', 'Processor RequestId')
        ->select('NVL_TSDK ORDERID', 'AMOUNT', 'Processor RequestId', 'Authorized Amount')
        ->selectRaw('ABS(AMOUNT - `Authorized Amount`) AS `Amount Difference`')
        ->havingRaw('`Amount Difference` != 0')
        ->get();
    
        $unmatchedTxnIdsForKotak = KotakFeed::leftJoin('payg_kotak_feed', 'kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->whereNull('payg_kotak_feed.Processor RequestId')
            ->orWhereRaw("kotak_feed.`NVL_TSDK ORDERID` != payg_kotak_feed.`Processor RequestId`")
            ->count();
        $matchedTxnIdsForPaygKotak = PayGKotakFeed::leftJoin('kotak_feed', 'payg_kotak_feed.Processor RequestId', '=', 'kotak_feed.NVL_TSDK ORDERID')
            ->whereNotNull('kotak_feed.NVL_TSDK ORDERID')
            ->whereColumn('payg_kotak_feed.Processor RequestId', '=', 'kotak_feed.NVL_TSDK ORDERID')
            ->count();


        $unmatchedTxnIdsForPaygKotak = PayGKotakFeed::leftJoin('kotak_feed', 'kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->whereNull('kotak_feed.NVL_TSDK ORDERID')
            ->orWhereRaw("payg_kotak_feed.`Processor RequestId` != kotak_feed.`NVL_TSDK ORDERID`")
            ->count();
        $unmatchedTxnIdsForKotakList = KotakFeed::leftJoin('payg_kotak_feed', 'kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->whereNull('payg_kotak_feed.Processor RequestId')
            ->orWhereRaw("kotak_feed.`NVL_TSDK ORDERID` != payg_kotak_feed.`Processor RequestId`")
            ->get();

        $unmatchedTxnIdsForPaygKotakList = PayGKotakFeed::leftJoin('kotak_feed', 'kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->whereNull('kotak_feed.NVL_TSDK ORDERID')
            ->orWhereRaw("payg_kotak_feed.`Processor RequestId` != kotak_feed.`NVL_TSDK ORDERID`")
            ->get();
        $matchedTxnIdsForKotak = KotakFeed::leftJoin('payg_kotak_feed', 'kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->whereNotNull('payg_kotak_feed.Processor RequestId')
            ->whereColumn('kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->count();
        $matchedTxnIdsForKotakList = KotakFeed::leftJoin('payg_kotak_feed', 'kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->whereNotNull('payg_kotak_feed.Processor RequestId')
            ->whereColumn('kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->get();

        $matchedTxnIdsForPaygKotakList = PayGKotakFeed::leftJoin('kotak_feed', 'payg_kotak_feed.Processor RequestId', '=', 'kotak_feed.NVL_TSDK ORDERID')
            ->whereNotNull('kotak_feed.NVL_TSDK ORDERID')
            ->whereColumn('payg_kotak_feed.Processor RequestId', '=', 'kotak_feed.NVL_TSDK ORDERID')
            ->get();


        $paygKotakFeeds = PayGKotakFeed::orderBy('Authorized Amount', 'asc')
            ->paginate(20);

        $kotakFeeds = KotakFeed::whereNotNull('NVL_TSDK ORDERID')->orderBy('AMOUNT', 'asc')
            ->paginate(20);

        $kotakFeedAllTransAmt = KotakFeed::leftJoin('payg_kotak_feed', 'kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->whereNotNull('payg_kotak_feed.Processor RequestId')
            ->whereColumn('kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->sum('kotak_feed.AMOUNT');
        $paygKotakFeedAllTransAmt = PayGKotakFeed::leftJoin('kotak_feed', 'payg_kotak_feed.Processor RequestId', '=', 'kotak_feed.NVL_TSDK ORDERID')
            ->whereNotNull('kotak_feed.NVL_TSDK ORDERID')
            ->whereColumn('payg_kotak_feed.Processor RequestId', '=', 'kotak_feed.NVL_TSDK ORDERID')
            ->sum('payg_kotak_feed.Authorized Amount');
        $totalKotakCount = KotakFeed::count();
        $totalPaygKotakCount = PayGKotakFeed::count();


        $diffKotakAmount = $kotakFeedAllTransAmt - $paygKotakFeedAllTransAmt;
        $diffPaygKotakAmount = $paygKotakFeedAllTransAmt - $kotakFeedAllTransAmt;

        return view('upi_kotak_view', compact(
            'paygKotakFeeds',
            'kotakFeeds',
            'unmatchedTxnIdsForKotakList',
            'unmatchedTxnIdsForPaygKotakList',
            'matchedTxnIdsForKotakList',
            'matchedTxnIdsForPaygKotakList',
            'unmatchedTxnIdsForKotak',
            'unmatchedTxnIdsForPaygKotak',
            'matchedTxnIdsForKotak',
            'matchedTxnIdsForPaygKotak',
            'totalKotakCount',
            'totalPaygKotakCount',
            'kotakFeedAllTransAmt',
            'paygKotakFeedAllTransAmt',
            'diffKotakAmount',
            'diffPaygKotakAmount',
            'results',
        ));
    }
}
