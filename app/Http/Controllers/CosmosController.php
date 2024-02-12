<?php

namespace App\Http\Controllers;

use App\Models\CosmosFeed;
use App\Models\PayGCosmosFeed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CosmosController extends Controller
{
    public $totalCosmosCount, $totalPaygCosmoscount, $acquirerFeeds, $mmsReconDats, $cosmosFeedAllTransAmt, $paygFeedAllTransAmt, $diffAmount, $diffAmountt;

    public function index()
    {
        //Cosmos Matched & Unmatched Counts
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

        return view('cosmos_view', [
            'acquirerFeeds' => $this->acquirerFeeds,
            'mmsReconDats' => $this->mmsReconDats,
            'cosmosFeedAllTransAmt' => $matchedTxnAmtsForCosmos,
            'paygFeedAllTransAmt' => $matchedTxnAmtsForPaygCosmso,
            'diffAmount' => $this->diffAmount,
            'diffAmountt' => $this->diffAmountt,
            'totalPaygCosmoscount' => $this->totalPaygCosmoscount,
            'totalCosmosCount' => $this->totalCosmosCount,
        ], compact(
            'matchedTxnIdsPaygCosmso',
            'matchedTxnIdsCosmos',
            'matchedTxnIdsForCosmos',
            'unmatchedTxnIdsForCosmos',
            'matchedTxnIdsForPaygCosmso',
            'unmatchedTxnIdsForPaygCosmso',
            'unmatchedTxnIdsCosmos',
            'unmatchedTxnIdsPaygCosmos'
        ));
    }
}
