<?php

namespace App\Http\Controllers;

use App\Models\AxisFeed;
use App\Models\CosmosFeed;
use App\Models\ICICIFeed;
use App\Models\InduslndFeed;
use App\Models\KotakFeed;
use App\Models\PayGAxisFeed;
use App\Models\PayGCosmosFeed;
use App\Models\PayGICICIFeed;
use App\Models\PayGInduslndFeed;
use App\Models\PayGKotakFeed;
use App\Models\PayGPayUFeed;
use App\Models\PayUFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllAcquirersController extends Controller
{
    public $totalPaygAxisCount, $axisFeed, $totalAxisCount, $paygAxisFeed, $axisFeedAllTransAmt, $paygAxisFeedAllTransAmt, $axisDiffAmount, $paygAxisDiffAmount;
    public $totalCosmosCount, $totalPaygCosmoscount, $acquirerFeeds, $mmsReconDats, $cosmosFeedAllTransAmt, $paygFeedAllTransAmt, $diffAmount, $diffAmountt;
    public $totalICICICount, $totalPaygICICIcount, $iciciFeed, $paygIciciFeed, $iciciFeedAllTransAmt, $paygIciciFeedAllTransAmt, $iciciDiffAmount, $paygIciciDiffAmount;

    public function changeTab(Request $request)
    {
        $tab = $request->input('tab', 'Cosmos');
        return redirect()->route('all-acquirers', ['tab' => $tab]);
    }
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'Cosmos');
        $unmatchedTxnIdsForAxisList = AxisFeed::leftJoin('payg_axis_feed', 'axis_feed.Txn Id', '=', 'payg_axis_feed.Processor RequestId')
            ->whereNull('payg_axis_feed.Processor RequestId')
            ->orWhereRaw("axis_feed.`Txn Id` != payg_axis_feed.`Processor RequestId`")
            ->get();
        $unmatchedTxnIdsForPaygAxisList = PayGAxisFeed::leftJoin('axis_feed', 'payg_axis_feed.Processor RequestId', '=', 'axis_feed.Txn Id')
            ->whereNull('axis_feed.Txn Id')
            ->orWhereRaw("payg_axis_feed.`Processor RequestId` != axis_feed.`Txn Id`")
            ->get();
        $unmatchedTxnIdsCosmos = CosmosFeed::leftJoin('payg_cosmos_feed', 'cosmos_feed.Ext Id', '=', 'payg_cosmos_feed.ProcessorRequestId')
            ->whereNull('payg_cosmos_feed.ProcessorRequestId')
            ->orWhereRaw('`cosmos_feed`.`Ext Id` != payg_cosmos_feed.ProcessorRequestId')
            ->get();
        $unmatchedTxnIdsPaygCosmos = PayGCosmosFeed::leftJoin('cosmos_feed', 'cosmos_feed.Ext Id', '=', 'payg_cosmos_feed.ProcessorRequestId')
            ->whereNull('cosmos_feed.Ext Id')
            ->orWhereRaw('payg_cosmos_feed.ProcessorRequestId != `cosmos_feed`.`Ext Id`')
            ->get();

        $unmatchedTxnIdsForICICIList = ICICIFeed::leftJoin('payg_icici_feed', 'icici_feed.merchantTranID', '=', 'payg_icici_feed.Processor RequestId')
            ->whereNull('payg_icici_feed.Processor RequestId')
            ->orWhereRaw("icici_feed.merchantTranID != payg_icici_feed.`Processor RequestId`")
            ->get();

        $unmatchedTxnIdsForPaygICICIList = PayGICICIFeed::leftJoin('icici_feed', 'icici_feed.merchantTranID', '=', 'payg_icici_feed.Processor RequestId')
            ->whereNull('icici_feed.merchantTranID')
            ->orWhereRaw("payg_icici_feed.`Processor RequestId` != icici_feed.merchantTranID")
            ->get();

        $unmatchedTxnIdsForPaygInduslndList = PayGInduslndFeed::leftJoin('induslnd_feed', 'induslnd_feed.Ref Id', '=', 'payg_induslnd_feed.Processor RequestId')
            ->whereNull('induslnd_feed.Ref Id')
            ->orWhereRaw("payg_induslnd_feed.`Processor RequestId` != induslnd_feed.`Ref Id`")
            ->get();

        $unmatchedTxnIdsForInduslndList = InduslndFeed::leftJoin('payg_induslnd_feed', 'induslnd_feed.Ref Id', '=', 'payg_induslnd_feed.Processor RequestId')
            ->whereNull('payg_induslnd_feed.Processor RequestId')
            ->orWhereRaw("induslnd_feed.`Ref Id` != payg_induslnd_feed.`Processor RequestId`")
            ->get();

        $unmatchedTxnIdsForPayuList = PayUFeed::leftJoin('payg_payu_feed', 'payu_feed.txnid', '=', 'payg_payu_feed.ProcessorRequestId')
            ->whereNull('payg_payu_feed.ProcessorRequestId')
            ->orWhereRaw("payu_feed.txnid != payg_payu_feed.ProcessorRequestId")
            ->get();

        $unmatchedTxnIdsForPaygPayuList = PayGPayUFeed::leftJoin('payu_feed', 'payu_feed.txnid', '=', 'payg_payu_feed.ProcessorRequestId')
            ->whereNull('payu_feed.txnid')
            ->orWhereRaw("payg_payu_feed.ProcessorRequestId != payu_feed.txnid")
            ->get();
        $unmatchedTxnIdsForKotakList = KotakFeed::leftJoin('payg_kotak_feed', 'kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->whereNull('payg_kotak_feed.Processor RequestId')
            ->orWhereRaw("kotak_feed.`NVL_TSDK ORDERID` != payg_kotak_feed.`Processor RequestId`")
            ->get();

        $unmatchedTxnIdsForPaygKotakList = PayGKotakFeed::leftJoin('kotak_feed', 'kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->whereNull('kotak_feed.NVL_TSDK ORDERID')
            ->orWhereRaw("payg_kotak_feed.`Processor RequestId` != kotak_feed.`NVL_TSDK ORDERID`")
            ->get();
        $unmatchedTxnIdsForICICI = ICICIFeed::leftJoin('payg_icici_feed', 'icici_feed.merchantTranID', '=', 'payg_icici_feed.Processor RequestId')
            ->whereNull('payg_icici_feed.Processor RequestId')
            ->orWhereRaw("icici_feed.merchantTranID != payg_icici_feed.`Processor RequestId`")
            ->count();

        $unmatchedTxnIdsForPaygICICI = PayGICICIFeed::leftJoin('icici_feed', 'icici_feed.merchantTranID', '=', 'payg_icici_feed.Processor RequestId')
            ->whereNull('icici_feed.merchantTranID')
            ->orWhereRaw("payg_icici_feed.`Processor RequestId` != icici_feed.merchantTranID")
            ->count();

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

        $matchedTxnIdsForCosmos = CosmosFeed::leftJoin('payg_cosmos_feed', 'cosmos_feed.Ext Id', '=', 'payg_cosmos_feed.ProcessorRequestId')
            ->whereNotNull('payg_cosmos_feed.ProcessorRequestId')
            ->whereColumn('cosmos_feed.Ext Id', '=', 'payg_cosmos_feed.ProcessorRequestId')
            ->count();

        $unmatchedTxnIdsForCosmos = CosmosFeed::leftJoin('payg_cosmos_feed', 'cosmos_feed.Ext Id', '=', 'payg_cosmos_feed.ProcessorRequestId')
            ->whereNull('payg_cosmos_feed.ProcessorRequestId')
            ->orWhereRaw('`cosmos_feed`.`Ext Id` != payg_cosmos_feed.ProcessorRequestId')
            ->count();

        //PaygCosmos Matched & Unmatched Counts
        $matchedTxnIdsForPaygCosmso = PayGCosmosFeed::leftJoin('cosmos_feed', 'payg_cosmos_feed.ProcessorRequestId', '=', 'cosmos_feed.Ext Id')
            ->whereNotNull('cosmos_feed.Ext Id')
            ->whereColumn('payg_cosmos_feed.ProcessorRequestId', '=', 'cosmos_feed.Ext Id')
            ->count();

        $unmatchedTxnIdsForPaygCosmso = PayGCosmosFeed::leftJoin('cosmos_feed', 'cosmos_feed.Ext Id', '=', 'payg_cosmos_feed.ProcessorRequestId')
            ->whereNull('cosmos_feed.Ext Id')
            ->orWhereRaw('payg_cosmos_feed.ProcessorRequestId != `cosmos_feed`.`Ext Id`')
            ->count();
        //Matched trans amts for both cosmos & payg cosmos
        $matchedTxnAmtsForCosmos = CosmosFeed::leftJoin('payg_cosmos_feed', 'cosmos_feed.Ext Id', '=', 'payg_cosmos_feed.ProcessorRequestId')
            ->whereNotNull('payg_cosmos_feed.ProcessorRequestId')
            ->whereColumn('cosmos_feed.Ext Id', '=', 'payg_cosmos_feed.ProcessorRequestId')
            ->sum('cosmos_feed.amount');
        $matchedTxnAmtsForPaygCosmso = PayGCosmosFeed::leftJoin('cosmos_feed', 'payg_cosmos_feed.ProcessorRequestId', '=', 'cosmos_feed.Ext Id')
            ->whereNotNull('cosmos_feed.Ext Id')
            ->whereColumn('payg_cosmos_feed.ProcessorRequestId', '=', 'cosmos_feed.Ext Id')
            ->sum('payg_cosmos_feed.AuthorizedAmount');



        //Both unmatched Ids Lists
        $unmatchedTxnIdsCosmos = CosmosFeed::leftJoin('payg_cosmos_feed', 'cosmos_feed.Ext Id', '=', 'payg_cosmos_feed.ProcessorRequestId')
            ->whereNull('payg_cosmos_feed.ProcessorRequestId')
            ->orWhereRaw('`cosmos_feed`.`Ext Id` != payg_cosmos_feed.ProcessorRequestId')
            ->get();
        $unmatchedTxnIdsPaygCosmos = PayGCosmosFeed::leftJoin('cosmos_feed', 'cosmos_feed.Ext Id', '=', 'payg_cosmos_feed.ProcessorRequestId')
            ->whereNull('cosmos_feed.Ext Id')
            ->orWhereRaw('payg_cosmos_feed.ProcessorRequestId != `cosmos_feed`.`Ext Id`')
            ->get();

        //Both Matched Ids Lists 
        $matchedTxnIdsCosmos = CosmosFeed::leftJoin('payg_cosmos_feed', 'cosmos_feed.Ext Id', '=', 'payg_cosmos_feed.ProcessorRequestId')
            ->whereNotNull('payg_cosmos_feed.ProcessorRequestId')
            ->whereColumn('cosmos_feed.Ext Id', '=', 'payg_cosmos_feed.ProcessorRequestId')
            ->get();
        $matchedTxnIdsPaygCosmso = PayGCosmosFeed::leftJoin('cosmos_feed', 'payg_cosmos_feed.ProcessorRequestId', '=', 'cosmos_feed.Ext Id')
            ->whereNotNull('cosmos_feed.Ext Id')
            ->whereColumn('payg_cosmos_feed.ProcessorRequestId', '=', 'cosmos_feed.Ext Id')
            ->get();


        $this->acquirerFeeds = CosmosFeed::orderBy('Amount', 'asc')->paginate(20);
        $this->totalCosmosCount =  CosmosFeed::orderBy('Amount', 'asc')->count();
        $this->totalPaygCosmoscount = PayGCosmosFeed::orderBy('AuthorizedAmount', 'asc')
            ->count();

        $this->mmsReconDats = PayGCosmosFeed::orderBy('AuthorizedAmount', 'asc')

            ->paginate(20);


        $this->diffAmount = $matchedTxnAmtsForCosmos - $matchedTxnAmtsForPaygCosmso;
        $this->diffAmountt = $matchedTxnAmtsForPaygCosmso - $matchedTxnAmtsForCosmos;
        $unmatchedTxnIdsForAxis = AxisFeed::leftJoin('payg_axis_feed', 'axis_feed.Txn Id', '=', 'payg_axis_feed.Processor RequestId')
            ->whereNull('payg_axis_feed.Processor RequestId')
            ->orWhereRaw("axis_feed.`Txn Id` != payg_axis_feed.`Processor RequestId`")
            ->count();

        $unmatchedTxnIdsForPaygAxis = PayGAxisFeed::leftJoin('axis_feed', 'axis_feed.Txn Id', '=', 'payg_axis_feed.Processor RequestId')
            ->whereNull('axis_feed.Txn Id')
            ->orWhereRaw("payg_axis_feed.`Processor RequestId` != axis_feed.`Txn Id`")
            ->count();

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
        $unmatchedTxnIdsForPayu = PayUFeed::leftJoin('payg_payu_feed', 'payu_feed.txnid', '=', 'payg_payu_feed.ProcessorRequestId')
            ->whereNull('payg_payu_feed.ProcessorRequestId')
            ->orWhereRaw("payu_feed.txnid != payg_payu_feed.ProcessorRequestId")
            ->count();

        $unmatchedTxnIdsForPaygPayu = PayGPayUFeed::leftJoin('payu_feed', 'payu_feed.txnid', '=', 'payg_payu_feed.ProcessorRequestId')
            ->whereNull('payu_feed.txnid')
            ->orWhereRaw("payg_payu_feed.ProcessorRequestId != payu_feed.txnid")
            ->count();

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
        $unmatchedTxnIdsForKotak = KotakFeed::leftJoin('payg_kotak_feed', 'kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->whereNull('payg_kotak_feed.Processor RequestId')
            ->orWhereRaw("kotak_feed.`NVL_TSDK ORDERID` != payg_kotak_feed.`Processor RequestId`")
            ->count();

        $unmatchedTxnIdsForPaygKotak = PayGKotakFeed::leftJoin('kotak_feed', 'kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->whereNull('kotak_feed.NVL_TSDK ORDERID')
            ->orWhereRaw("payg_kotak_feed.`Processor RequestId` != kotak_feed.`NVL_TSDK ORDERID`")
            ->count();

        $matchedTxnIdsForKotak = KotakFeed::leftJoin('payg_kotak_feed', 'kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->whereNotNull('payg_kotak_feed.Processor RequestId')
            ->whereColumn('kotak_feed.NVL_TSDK ORDERID', '=', 'payg_kotak_feed.Processor RequestId')
            ->count();

        $matchedTxnIdsForPaygKotak = PayGKotakFeed::leftJoin('kotak_feed', 'payg_kotak_feed.Processor RequestId', '=', 'kotak_feed.NVL_TSDK ORDERID')
            ->whereNotNull('kotak_feed.NVL_TSDK ORDERID')
            ->whereColumn('payg_kotak_feed.Processor RequestId', '=', 'kotak_feed.NVL_TSDK ORDERID')
            ->count();

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

        $results = KotakFeed::select('NVL_TSDK ORDERID', 'AMOUNT')
        ->join('payg_kotak_feed', 'NVL_TSDK ORDERID', '=', 'Processor RequestId')
        ->select('NVL_TSDK ORDERID', 'AMOUNT', 'Processor RequestId', 'Authorized Amount')
        ->selectRaw('ABS(AMOUNT - `Authorized Amount`) AS `Amount Difference`')
        ->havingRaw('`Amount Difference` != 0')
        ->get();
        $diffKotakAmount = $kotakFeedAllTransAmt - $paygKotakFeedAllTransAmt;
        $diffPaygKotakAmount = $paygKotakFeedAllTransAmt - $kotakFeedAllTransAmt;

        return view('all_acquirers_view', compact(
            'tab',
            'results',
            'unmatchedTxnIdsForAxisList',
            'unmatchedTxnIdsForPaygAxisList',
            'unmatchedTxnIdsCosmos',
            'unmatchedTxnIdsPaygCosmos',
            'unmatchedTxnIdsForICICIList',
            'unmatchedTxnIdsForPaygICICIList',
            'unmatchedTxnIdsForPaygInduslndList',
            'unmatchedTxnIdsForInduslndList',
            'unmatchedTxnIdsForPayuList',
            'unmatchedTxnIdsForPaygPayuList',
            'unmatchedTxnIdsForKotakList',
            'unmatchedTxnIdsForPaygKotakList',
            'paygKotakFeeds',
            'kotakFeeds',
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
            'matchedTxnIdsPaygCosmso',
            'matchedTxnIdsCosmos',
            'matchedTxnIdsForCosmos',
            'unmatchedTxnIdsForCosmos',
            'matchedTxnIdsForPaygCosmso',
            'unmatchedTxnIdsForPaygCosmso',
            'unmatchedTxnIdsCosmos',
            'unmatchedTxnIdsPaygCosmos',
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
            'totalPaygInduslndCount'
        ), [
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
            'matchedTxnIdsForPaygICICI' => $matchedTxnIdsForPaygICICI,
            'acquirerFeeds' => $this->acquirerFeeds,
            'mmsReconDats' => $this->mmsReconDats,
            'cosmosFeedAllTransAmt' => $matchedTxnAmtsForCosmos,
            'paygFeedAllTransAmt' => $matchedTxnAmtsForPaygCosmso,
            'diffAmount' => $this->diffAmount,
            'diffAmountt' => $this->diffAmountt,
            'totalPaygCosmoscount' => $this->totalPaygCosmoscount,
            'totalCosmosCount' => $this->totalCosmosCount,
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
        ]);
    }
}
