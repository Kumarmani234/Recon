<?php

namespace App\Http\Controllers;

use App\Models\PayGPayUFeed;
use App\Models\PayUFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PayuController extends Controller
{
    public function index()
    {
        $unmatchedTxnIdsForPayu = PayUFeed::leftJoin('payg_payu_feed', 'payu_feed.txnid', '=', 'payg_payu_feed.ProcessorRequestId')
            ->whereNull('payg_payu_feed.ProcessorRequestId')
            ->orWhereRaw("payu_feed.txnid != payg_payu_feed.ProcessorRequestId")
            ->count();

        $unmatchedTxnIdsForPaygPayu = PayGPayUFeed::leftJoin('payu_feed', 'payu_feed.txnid', '=', 'payg_payu_feed.ProcessorRequestId')
            ->whereNull('payu_feed.txnid')
            ->orWhereRaw("payg_payu_feed.ProcessorRequestId != payu_feed.txnid")
            ->count();

        $unmatchedTxnIdsForPayuList = PayUFeed::leftJoin('payg_payu_feed', 'payu_feed.txnid', '=', 'payg_payu_feed.ProcessorRequestId')
            ->whereNull('payg_payu_feed.ProcessorRequestId')
            ->orWhereRaw("payu_feed.txnid != payg_payu_feed.ProcessorRequestId")
            ->get();

        $unmatchedTxnIdsForPaygPayuList = PayGPayUFeed::leftJoin('payu_feed', 'payu_feed.txnid', '=', 'payg_payu_feed.ProcessorRequestId')
            ->whereNull('payu_feed.txnid')
            ->orWhereRaw("payg_payu_feed.ProcessorRequestId != payu_feed.txnid")
            ->get();

        $matchedTxnIdsForPayu = PayUFeed::leftJoin('payg_payu_feed', 'payu_feed.txnid', '=', 'payg_payu_feed.ProcessorRequestId')
            ->whereNotNull('payg_payu_feed.ProcessorRequestId')
            ->whereColumn('payu_feed.txnid', '=', 'payg_payu_feed.ProcessorRequestId')
            ->count();

        $matchedTxnIdsForPaygPayu = PayGPayUFeed::leftJoin('payu_feed', 'payg_payu_feed.ProcessorRequestId', '=', 'payu_feed.txnid')
            ->whereNotNull('payu_feed.txnid')
            ->whereColumn('payg_payu_feed.ProcessorRequestId', '=', 'payu_feed.txnid')
            ->count();


        $totalPayuCount = PayUFeed::count();
        $totalPaygPayuCount = PayGPayUFeed::count();
        $paygPayUFeeds = PayGPayUFeed::whereNotNull('TransactionAmount')
            ->orderBy('TransactionAmount', 'asc')
            ->paginate(20);

        $payuFeeds = PayUFeed::orderBy('Amount', 'asc')
            ->paginate(20);

        $payuFeedAllTransAmt =  PayUFeed::leftJoin('payg_payu_feed', 'payu_feed.txnid', '=', 'payg_payu_feed.ProcessorRequestId')
            ->whereNotNull('payg_payu_feed.ProcessorRequestId')
            ->whereColumn('payu_feed.txnid', '=', 'payg_payu_feed.ProcessorRequestId')
            ->sum('payu_feed.amount');

        $paygFeedAllTransAmt = PayGPayUFeed::leftJoin('payu_feed', 'payg_payu_feed.ProcessorRequestId', '=', 'payu_feed.txnid')
            ->whereNotNull('payu_feed.txnid')
            ->whereColumn('payg_payu_feed.ProcessorRequestId', '=', 'payu_feed.txnid')
            ->sum('payg_payu_feed.TransactionAmount');

        $diffPayuAmount = $payuFeedAllTransAmt - $paygFeedAllTransAmt;
        $diffPaygPayuAmountt = $paygFeedAllTransAmt - $payuFeedAllTransAmt;

        return view('payu_view', compact(
            'paygPayUFeeds',
            'payuFeeds',
            'payuFeedAllTransAmt',
            'paygFeedAllTransAmt',
            'diffPayuAmount',
            'diffPaygPayuAmountt',
            'unmatchedTxnIdsForPayu',
            'unmatchedTxnIdsForPaygPayu',
            'matchedTxnIdsForPayu',
            'matchedTxnIdsForPaygPayu',
            'totalPayuCount',
            'totalPaygPayuCount',
            'unmatchedTxnIdsForPaygPayuList',
            'unmatchedTxnIdsForPayuList',
        ));
    }
}
