<?php

namespace App\Http\Controllers;

use App\Models\InduslndFeed;
use App\Models\PayGInduslndFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InduslndController extends Controller
{
    public function index()
    {
        $paygInduslndFeeds = PayGInduslndFeed::orderBy('Authorized Amount', 'asc')->paginate(20);
        $induslndFeeds = InduslndFeed::orderBy('TRANSACTION AMOUNT', 'asc')->paginate(20);

        $induslndFeedAllTransAmt = InduslndFeed::leftJoin('payg_induslnd_feed', 'induslnd_feed.Ref Id', '=', 'payg_induslnd_feed.Processor RequestId')
            ->whereNotNull('payg_induslnd_feed.Processor RequestId')
            ->whereColumn('induslnd_feed.Ref Id', '=', 'payg_induslnd_feed.Processor RequestId')
            ->sum('induslnd_feed.TRANSACTION AMOUNT');

        $paygInduslndFeedAllTransAmt = PayGInduslndFeed::leftJoin('induslnd_feed', 'payg_induslnd_feed.Processor RequestId', '=', 'induslnd_feed.Ref Id')
            ->whereNotNull('induslnd_feed.Ref Id')
            ->whereColumn('payg_induslnd_feed.Processor RequestId', '=', 'induslnd_feed.Ref Id')
            ->sum('payg_induslnd_feed.Authorized Amount');

        $induslndDiffAmount = $induslndFeedAllTransAmt - $paygInduslndFeedAllTransAmt;
        $paygInduslndDiffAmount = $paygInduslndFeedAllTransAmt - $induslndFeedAllTransAmt;

        $totalInduslndCount =  InduslndFeed::count();
        $totalPaygInduslndCount = PayGInduslndFeed::count();

        $unmatchedTxnIdsForInduslnd = InduslndFeed::leftJoin('payg_induslnd_feed', 'induslnd_feed.Ref Id', '=', 'payg_induslnd_feed.Processor RequestId')
            ->whereNull('payg_induslnd_feed.Processor RequestId')
            ->orWhereRaw("induslnd_feed.`Ref Id` != payg_induslnd_feed.`Processor RequestId`")
            ->count();

        $unmatchedTxnIdsForPaygInduslndList = PayGInduslndFeed::leftJoin('induslnd_feed', 'induslnd_feed.Ref Id', '=', 'payg_induslnd_feed.Processor RequestId')
            ->whereNull('induslnd_feed.Ref Id')
            ->orWhereRaw("payg_induslnd_feed.`Processor RequestId` != induslnd_feed.`Ref Id`")
            ->get();

        $unmatchedTxnIdsForInduslndList = InduslndFeed::leftJoin('payg_induslnd_feed', 'induslnd_feed.Ref Id', '=', 'payg_induslnd_feed.Processor RequestId')
            ->whereNull('payg_induslnd_feed.Processor RequestId')
            ->orWhereRaw("induslnd_feed.`Ref Id` != payg_induslnd_feed.`Processor RequestId`")
            ->get();

        $unmatchedTxnIdsForPaygInduslnd = PayGInduslndFeed::leftJoin('induslnd_feed', 'induslnd_feed.Ref Id', '=', 'payg_induslnd_feed.Processor RequestId')
            ->whereNull('induslnd_feed.Ref Id')
            ->orWhereRaw("payg_induslnd_feed.`Processor RequestId` != induslnd_feed.`Ref Id`")
            ->count();

        $matchedTxnIdsForInduslnd = InduslndFeed::leftJoin('payg_induslnd_feed', 'induslnd_feed.Ref Id', '=', 'payg_induslnd_feed.Processor RequestId')
            ->whereNotNull('payg_induslnd_feed.Processor RequestId')
            ->whereColumn('induslnd_feed.Ref Id', '=', 'payg_induslnd_feed.Processor RequestId')
            ->count();

        $matchedTxnIdsForPaygInduslnd = PayGInduslndFeed::leftJoin('induslnd_feed', 'payg_induslnd_feed.Processor RequestId', '=', 'induslnd_feed.Ref Id')
            ->whereNotNull('induslnd_feed.Ref Id')
            ->whereColumn('payg_induslnd_feed.Processor RequestId', '=', 'induslnd_feed.Ref Id')
            ->count();

        return view('induslnd_view', compact(
            'unmatchedTxnIdsForInduslnd',
            'unmatchedTxnIdsForPaygInduslnd',
            'matchedTxnIdsForInduslnd',
            'matchedTxnIdsForPaygInduslnd',
            'paygInduslndFeeds',
            'induslndFeeds',
            'induslndFeedAllTransAmt',
            'paygInduslndFeedAllTransAmt',
            'induslndDiffAmount',
            'paygInduslndDiffAmount',
            'totalInduslndCount',
            'totalPaygInduslndCount',
            'unmatchedTxnIdsForPaygInduslndList',
            'unmatchedTxnIdsForInduslndList'
        ));
    }
}
