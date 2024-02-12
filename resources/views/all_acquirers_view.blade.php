@extends('home')
@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Acquirers</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    @import url('/css/app.css');
</style>


<body>
    <div style="margin-left: 12px;">
        <div class="row p-1">
            <div class="col-md-12">
                <div class="d-flex justify-content-start">
                    <form method="post" action="{{ route('change-tab') }}">
                        @csrf
                        <button type="submit" name="tab" value="Axis" class="tabs {{ $tab === 'Axis' ? 'active' : '' }}">UPI-Axis</button>
                        <button type="submit" name="tab" value="Cosmos" class="tabs {{ $tab === 'Cosmos' ? 'active' : '' }}">UPI-Cosmos</button>
                        <button type="submit" name="tab" value="ICICI" class="tabs {{ $tab === 'ICICI' ? 'active' : '' }}">UPI-ICICI</button>
                        <button type="submit" name="tab" value="Induslnd" class="tabs {{ $tab === 'Induslnd' ? 'active' : '' }}">Induslnd Bank</button>
                        <button type="submit" name="tab" value="Kotak" class="tabs {{ $tab === 'Kotak' ? 'active' : '' }}">UPI-Kotak</button>
                        <button type="submit" name="tab" value="PayU" class="tabs {{ $tab === 'PayU' ? 'active' : '' }}">PayU Bank</button>
                    </form>
                </div>
            </div>
        </div>


        @if($tab=="Cosmos")
        <div class="row">
            <div class="col-md-12 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 240px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align: start; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px"><strong>Cosmos Feed</strong></h6>
                <table class="custom-table1">
                    <thead style="background-color:  #2f84bc;color:white">
                        <tr style="height: 40px;">
                            <th>Acquirer Data</th>
                            <th>Transaction Date</th>
                            <th>Type Of Transaction</th>
                            <th>Ext Id</th>
                            <th>Amount</th>
                            <th>Txn ID</th>
                            <th>RRN</th>
                            <th>Payee VPA</th>
                            <th>Payer VPA</th>
                            <th>MCC</th>
                            <th>Switch Code</th>
                            <th>Switch Msg</th>
                            <th>Transaction Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($acquirerFeeds as $index => $feed)

                        <tr class="{{ $feed->highlightRowForProcessorRequestId($feed->{'Ext Id'}) == 'highlight-green' ? 'highlight-green' : '' }}">
                            <td>
                                @if($feed->highlightRowForProcessorRequestId($feed->{'Ext Id'}) == 'highlight-green')
                                <input disabled type="checkbox" name="" id="myCheckbox" checked>
                                @else
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                                @endif
                            </td>
                            <td>{{ $feed->Date }}</td>
                            <td>{{ $feed->Remarks }}</td>
                            <td>{{ $feed->{'Ext Id'} }}</td>
                            <td><strong>₹ {{ number_format($feed->Amount, 0, '.', ',') }}</strong></td>
                            <td>{{ $feed->{'Txn Id'} }}</td>
                            <td>{{ $feed->RRN }}</td>
                            <td>{{ $feed->{'Payee Vpa'} }}</td>
                            <td>{{ $feed->{'Payer Vpa'} }}</td>
                            <td>{{ $feed->MCC}}</td>
                            <td>{{ $feed->{'Switch Code'} }}</td>
                            <td>{{ $feed->{'Switch Msg'} }}</td>
                            <td>{{ $feed->{'Transaction Status'} }}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class="pagination">
                    {{ $acquirerFeeds->appends(['tab' => $tab])->links('custom-pagination-view') }}
                </div>
            </div>
            <div class="row m-0 p-0" style="font-size: 0.6rem;">
                <div class="col-md-12" style="border:8px solid #2f84bc;width:1290px">
                    <div class="row ml-1">
                        <div class="col total-amount">Total Count : <strong>{{$totalCosmosCount}}</strong></div>
                        <div class="col total-amount">Total Amount : <strong>₹ {{ number_format($cosmosFeedAllTransAmt, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount">Total Diff Amount : <strong>₹ {{ number_format($diffAmount, 0, '.', ',') }}</strong></div>
                    </div>
                    <hr style="margin: 0px;padding:0px">
                    <div class="row ml-1">
                        <div class="col total-amount">Matched Count : <strong>{{$matchedTxnIdsForCosmos}}</strong></div>
                        <div class="col total-amount">UnMatched Count : <strong> {{ number_format($unmatchedTxnIdsForCosmos, 0, '.', ',') }}</strong></div>
                        <div class="col total-amount"></strong></div>
                    </div>
                </div>
            </div>

            <div class="row  m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #2f84bc; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                    <h6 style="width: 100%; text-align: start; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px;font-size:0.6rem"><strong>Cosmos UNMatched List</strong></h6>
                    <table class="custom-table1">
                        <thead>
                            <tr style="background-color: #2f84bc;color:white;height:47px;">
                                <th>Id</th>
                                <th>Transaction Date</th>
                                <th>Type Of Transaction</th>
                                <th>Ext Id</th>
                                <th>Amount</th>
                                <th>Txn ID</th>
                                <th>RRN</th>
                                <th>Transaction Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unmatchedTxnIdsCosmos as $index => $feed)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $feed->Date }}</td>
                                <td>{{ $feed->Remarks }}</td>
                                <td>{{ $feed->{'Ext Id'} }}</td>
                                <td><strong>₹ {{ number_format($feed->Amount, 0, '.', ',') }}</strong></td>
                                <td>{{ $feed->{'Txn Id'} }}</td>
                                <td>{{ $feed->RRN }}</td>
                                <td>{{ $feed->{'Transaction Status'} }}</td>
                            </tr>
                            @empty
                            <td colspan="8">No records found</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 240px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: start; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px"><strong>PayG Feed (Cosmos)</strong></h6>
                <table class="custom-table2">
                    <thead style="background-color: #6b0aac;color:white">
                        <tr style="height: 40px;">
                            <th>All</th>
                            <th>Acquirer Data</th>
                            <th>Acquirer Settlement</th>
                            <th>Merchant Settlement</th>
                            <th>Transaction Date Time</th>
                            <th>Payment Type</th>
                            <th>Processor Request ID</th>
                            <th>Authorized Amount</th>
                            <th>NPCI Txn ID</th>
                            <th>Transaction Reference No</th>
                            <th>Processed Date Time</th>
                            <th>Processor ID</th>
                            <th>Merchant Key ID</th>
                            <th>Response Code</th>
                            <th>Response Text</th>
                            <!-- Add other table headers as needed -->
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($mmsReconDats as $index=> $data)

                        <tr>
                            <td><input disabled type="checkbox" name="" id="myUnCheckbox"></td>
                            <td>
                                @if($data->highlightRowForProcessorRequestId($data->ProcessorRequestId) == 'highlight-green')
                                <input disabled type="checkbox" name="" id="myCheckbox" checked>
                                @else
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                                @endif
                            </td>
                            <td>
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                            </td>
                            <td>
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                            </td>
                            <td>{{ $data->TransactionDateTime }}</td>
                            <td>{{ $data->PaymentType }}</td>
                            <td>{{ $data->ProcessorRequestId }}</td>
                            <td><strong>₹ {{ number_format($data->AuthorizedAmount, 0, '.', ',') }}</strong></td>
                            <td>{{ $data->NPCITxnId }}</td>
                            <td>{{ $data->TransactionReferenceNo }}</td>
                            <td>{{ $data->ProcessedDateTime }}</td>
                            <td>{{ $data->ProcessorId }}</td>
                            <td>{{ $data->MerchantKeyId }}</td>
                            <td>{{ $data->ResponseCode }}</td>
                            <td>{{ $data->ResponseText }}</td>
                            <!-- Add other table cells as needed -->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $mmsReconDats->appends(['tab' => $tab])->links('custom-pagination-view') }}
                </div>

            </div>
            <div class="row m-0 p-0" style="font-size: 0.6rem;">
                <div class="col-md-12" style="border:8px solid #6b0aac;width:1290px">
                    <div class="row ml-1">
                        <div class="col total-amount">Total Count : <strong>{{$totalPaygCosmoscount}}</strong></div>
                        <div class="col total-amount">Total Amount: <strong>₹ {{ number_format($paygFeedAllTransAmt, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount">Total Diff Amount: <strong>₹ {{ number_format($diffAmountt, 0, '.', ',') }}</strong></div>
                    </div>
                    <hr style="margin: 0px;padding:0px">
                    <div class="row ml-1">
                        <div class="col total-amount">Matched Count : <strong>{{$matchedTxnIdsForPaygCosmso}}</strong></div>
                        <div class="col total-amount">UnMatched Count : <strong>{{ number_format($unmatchedTxnIdsForPaygCosmso, 0, '.', ',') }}</strong></div>
                        <div class="col total-amount"></strong></div>
                    </div>
                </div>
            </div>

            <div class="row m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                    <h6 style="width: 100%; text-align: start; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px;font-size:0.6rem"><strong>PayG (Comsos) UNMatched List</strong></h6>
                    <table class="custom-table2">
                        <thead>
                            <tr style="background-color: #6b0aac;color:white;height:40px;">
                                <th>Id</th>
                                <th>Transaction DateTime</th>
                                <th>Payment Type</th>
                                <th>Processor Request ID</th>
                                <th>Authorized Amount</th>
                                <th>NPCI Txn ID</th>
                                <th>Transaction Reference No</th>
                                <th>Processed Date Time</th>
                                <th>Processor ID</th>
                                <th>Response Text</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unmatchedTxnIdsPaygCosmos as $index=> $data)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $data->TransactionDateTime }}</td>
                                <td>{{ $data->PaymentType }}</td>
                                <td>{{ $data->ProcessorRequestId }}</td>
                                <td><strong>₹ {{ number_format($data->AuthorizedAmount, 0, '.', ',') }}</strong></td>
                                <td>{{ $data->NPCITxnId }}</td>
                                <td>{{ $data->TransactionReferenceNo }}</td>
                                <td>{{ $data->ProcessedDateTime }}</td>
                                <td>{{ $data->ProcessorId }}</td>
                                <td>{{ $data->ResponseText }}</td>
                            </tr>
                            @empty
                            <td colspan="10">No records found</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        @elseif($tab=="PayU")
        <div class="row">
            <div class="col-md-12 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 240px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align: start; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px"><strong>PayU Feed</strong></h6>
                <table class="custom-table1">
                    <thead style="background-color: #2f84bc;color:white">
                        <tr style="height: 40px;">
                            <th>Acquirer Data</th>
                            <th>Transaction Date</th>
                            <th>Acquirer Name </th>
                            <th>Bank Name</th>
                            <th>Txn ID</th>
                            <th>Amount</th>
                            <th>Settlement Amount</th>
                            <th>Bank Reference No</th>
                            <th>Merchant Id</th>
                            <th>Merchant Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($payuFeeds as $index=> $feed)

                        <tr class="{{ $feed->highlightRowForProcessorRequestId($feed->txnid) == 'highlight-green' ? 'highlight-green' : '' }}">
                            <td>
                                @if($feed->highlightRowForProcessorRequestId($feed->txnid) == 'highlight-green')
                                <input disabled type="checkbox" name="" id="myCheckbox" checked>
                                @else
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                                @endif
                            </td>
                            <td>24-01-29</td>
                            <td>PayU</td>
                            <td>{{ $feed->{'bank_name'} }}</td>
                            <td>{{ $feed->txnid }}</td>
                            <td>@if($feed->amount)
                                <strong> ₹ {{ number_format($feed->amount, 0, '.', ',') }}</strong>
                                @else
                                --
                                @endif
                            </td>
                            <td><strong>₹ {{ $feed->settlement_amount }}</strong></td>
                            <td>{{ $feed->{'bank_ref_no'} }}</td>
                            <td>{{ $feed->{'merchant_id'} }}</td>
                            <td>{{ $feed->{'merchant_name'} }}</td>
                            <td>{{ $feed->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $payuFeeds->appends(['tab' => $tab])->links('custom-pagination-view') }}
                </div>

            </div>
            <div class="row m-0 p-0" style="font-size: 0.6rem;">
                <div class="col-md-12" style="border:8px solid #2f84bc;width:1290px">
                    <div class="row ml-1">
                        <div class="col total-amount">Total Count : <strong>{{$totalPayuCount}}</strong></div>
                        <div class="col total-amount">Total Amount : <strong>₹ {{ number_format($payuFeedAllTransAmt, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount">Total Diff Amount : <strong>₹ {{ number_format($diffPayuAmount, 0, '.', ',') }}</strong></div>
                    </div>
                    <hr style="margin: 0px;padding:0px">
                    <div class="row ml-1">
                        <div class="col total-amount">Matched Count : <strong>{{$matchedTxnIdsForPayu}}</strong></div>
                        <div class="col total-amount">UnMatched Count : <strong>{{ number_format($unmatchedTxnIdsForPayu, 0, '.', ',') }}</strong></div>
                        <div class="col total-amount"></strong></div>
                    </div>
                </div>
            </div>
            <div class="row  m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #2f84bc; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                    <h6 style="width: 100%; text-align: start; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px;font-size:0.6rem"><strong>PayU UNMatched List</strong></h6>
                    <table class="custom-table1">
                        <thead>
                            <tr style="background-color: #2f84bc;color:white;height:47px;">
                                <th>Id</th>
                                <th>Transaction Date</th>
                                <th>Acquirer Name </th>
                                <th>Bank Name</th>
                                <th>Txn ID</th>
                                <th>Amount</th>
                                <th>Settlement Amount</th>
                                <th>Bank Reference No</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unmatchedTxnIdsForPayuList as $index => $feed)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>24-01-29</td>
                                <td>PayU</td>
                                <td>{{ $feed->{'bank_name'} }}</td>
                                <td>{{ $feed->txnid }}</td>
                                <td>@if($feed->amount)
                                    <strong> ₹ {{ number_format($feed->amount, 0, '.', ',') }}</strong>
                                    @else
                                    --
                                    @endif
                                </td>
                                <td><strong>₹ {{ $feed->settlement_amount }}</strong></td>
                                <td>{{ $feed->{'bank_ref_no'} }}</td>
                                <td>{{ $feed->status }}</td>
                            </tr>
                            @empty
                            <td colspan="9">No records found</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 240px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: start; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px"><strong>PayG Feed (PayU)</strong></h6>
                <table class="custom-table1">
                    <thead style="background-color: #6b0aac;color:white">
                        <tr style="height: 40px;">
                            <th>All</th>
                            <th>Acquirer Data </th>
                            <th>Acquirer Settlement </th>
                            <th>Merchant Settlement </th>
                            <th>Date </th>
                            <th>Acquirer Name </th>
                            <th>Transaction Type</th>
                            <th>Payment Type</th>
                            <th>Txn ID</th>
                            <th>Transaction Amount</th>
                            <th>Transaction Reference No</th>
                            <th>Merchant Key ID</th>
                            <th>Processor ID</th>
                            <th>PayUId</th>
                            <th>Response Code</th>
                            <th>Response Text</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($paygPayUFeeds as $index=> $feed)

                        <tr>
                            <td>
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                            </td>
                            <td>
                                @if($feed->highlightRowForProcessorRequestId($feed->ProcessorRequestId) == 'highlight-green')
                                <input disabled type="checkbox" name="" id="myCheckbox" checked>
                                @else
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                                @endif
                            </td>
                            <td>
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                            </td>
                            <td>
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                            </td>
                            <td>{{ $feed->TransactionDatetime }}</td>
                            <td>PayU</td>
                            <td>{{ $feed->TransactionType }}</td>
                            <td>{{ $feed->PaymentType }}</td>
                            <td>{{ $feed->ProcessorRequestId }}</td>
                            <td>@if($feed->TransactionAmount)
                                <strong>₹ {{ number_format($feed->TransactionAmount, 0, '.', ',') }}</strong>
                                @else
                                --
                                @endif
                            </td>
                            <td>{{ $feed->TransactionReferenceNo }}</td>
                            <td>{{ $feed->MerchantKeyId }}</td>
                            <td>{{ $feed->ProcessorId }}</td>
                            <td>{{ $feed->PayUId }}</td>
                            <td>{{ $feed->ResponseCode }}</td>
                            <td>{{ $feed->ResponseText }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $paygPayUFeeds->appends(['tab' => $tab])->links('custom-pagination-view') }}
                </div>
            </div>
            <div class="row m-0 p-0" style="font-size: 0.6rem;">
                <div class="col-md-12" style="border:8px solid #6b0aac;width:1290px">
                    <div class="row ml-1">
                        <div class="col total-amount">Total Count : <strong>{{$totalPaygPayuCount}}</strong></div>
                        <div class="col total-amount">Total Amount: <strong>₹ {{ number_format($paygFeedAllTransAmt, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount">Total Diff Amount : <strong>₹ {{ number_format($diffPaygPayuAmountt, 0, '.', ',') }}</strong></div>

                    </div>
                    <hr style="margin: 0px;padding:0px">
                    <div class="row ml-1">
                        <div class="col total-amount">Matched Count : <strong>{{$matchedTxnIdsForPaygPayu}}</strong></div>
                        <div class="col total-amount">UnMatched Count : <strong>{{ number_format($unmatchedTxnIdsForPaygPayu, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount"></strong></div>
                    </div>
                </div>
            </div>
            <div class="row m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                    <h6 style="width: 100%; text-align: start; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px;font-size:0.6rem"><strong>PayG (PayU) UNMatched List</strong></h6>
                    <table class="custom-table2">
                        <thead>
                            <tr style="background-color: #6b0aac;color:white;height:40px">
                                <th>ID</th>
                                <th>Date </th>
                                <th>Acquirer Name </th>
                                <th>Transaction Type</th>
                                <th>Payment Type</th>
                                <th>Txn ID</th>
                                <th>Transaction Amount</th>
                                <th>Transaction Reference No</th>
                                <th>Merchant Key ID</th>
                                <th>Processor ID</th>
                                <th>Response Text</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unmatchedTxnIdsForPaygPayuList as $index=> $feed)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $feed->TransactionDatetime }}</td>
                                <td>PayU</td>
                                <td>{{ $feed->TransactionType }}</td>
                                <td>{{ $feed->PaymentType }}</td>
                                <td>{{ $feed->ProcessorRequestId }}</td>
                                <td>@if($feed->TransactionAmount)
                                    <strong> ₹ {{ number_format($feed->TransactionAmount, 0, '.', ',') }}</strong>
                                    @else
                                    --
                                    @endif
                                </td>
                                <td>{{ $feed->TransactionReferenceNo }}</td>
                                <td>{{ $feed->MerchantKeyId }}</td>
                                <td>{{ $feed->ProcessorId }}</td>
                            </tr>
                            @empty
                            <td colspan="10">No records found</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @elseif($tab=="Axis")
        <div class="row">
            <div class="col-md-22 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 240px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align: start; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px"><strong>Axis Feed</strong></h6>
                <table class="custom-table1">
                    <thead>
                        <tr style="background-color: #2f84bc;color:white;height:47px">
                            <th>Acquirer Data</th>
                            <th>Transaction Date</th>
                            <th>Type Of Transaction</th>
                            <th>Txn Id</th>
                            <th>Amount</th>
                            <th>RRN</th>
                            <th>Merchant Id</th>
                            <th>Channel Id</th>
                            <th>Response Code</th>
                            <th>Aggregator Code</th>
                            <th>Transaction Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($axisFeeds as $index => $feed)


                        <tr class="{{ $feed->highlightRowForProcessorRequestId($feed->{'Txn Id'}) == 'highlight-green' ? 'highlight-green' : '' }}">
                            <td>
                                @if($feed->highlightRowForProcessorRequestId($feed->{'Txn Id'}) == 'highlight-green')
                                <input disabled type="checkbox" name="" id="myCheckbox" checked>
                                @else
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                                @endif
                            </td>
                            <td>{{ $feed->{'Txn Date'} }}</td>
                            <td>{{ $feed->{'Txn Type'} }}</td>
                            <td>{{ $feed->{'Txn Id'} }}</td>
                            <td><strong>₹ {{ number_format($feed->Amount, 0, '.', ',') }}</strong></td>
                            <td>{{ $feed->RRN }}</td>
                            <td>{{ $feed->{'Merchant Id'} }}</td>
                            <td>{{ $feed->{'Channel Id'} }}</td>
                            <td>{{ $feed->{'Response Code'} }}</td>
                            <td>{{ $feed->{'Aggregator Code'} }}</td>
                            <td>{{ $feed->Response }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $axisFeeds->appends(['tab' => $tab])->links('custom-pagination-view') }}
                </div>
            </div>
            <div class="row m-0 p-0" style="font-size: 0.6rem;">
                <div class="col-md-12" style="border: 8px solid #2f84bc;">
                    <div class="row ml-1">
                        <div class="col total-amount">Total Count : <strong>{{$totalAxisCount}}</strong></div>
                        <div class="col total-amount">Total Amount : <strong>₹ {{ number_format($axisFeedAllTransAmt, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount">Total Diff Amount : <strong>₹ {{ number_format($diffAmount, 0, '.', ',') }}</strong></div>
                    </div>
                    <hr style="margin: 0px;padding:0px">
                    <div class="row ml-1">
                        <div class="col total-amount">Matched Count : <strong>{{$matchedTxnIdsForAxis}}</strong></div>
                        <div class="col total-amount">UnMatched Count : <strong>{{ number_format($unmatchedTxnIdsForAxis, 0, '.', ',') }}</strong></div>
                        <div class="col total-amount"></strong></div>
                    </div>
                </div>
            </div>

            <div class="row  m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #2f84bc; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                    <h6 style="width: 100%; text-align: start; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px;font-size:0.6rem"><strong>Axis UNMatched List</strong></h6>
                    <table class="custom-table1">
                        <thead>
                            <tr style="background-color: #2f84bc;color:white;height:47px;">
                                <th>Id</th>
                                <th>Transaction Date</th>
                                <th>Type Of Transaction</th>
                                <th>Txn Id</th>
                                <th>Amount</th>
                                <th>RRN</th>
                                <th>Merchant Id</th>
                                <th>Transaction Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unmatchedTxnIdsForAxisList as $index => $feed)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $feed->{'Txn Date'} }}</td>
                                <td>{{ $feed->{'Txn Type'} }}</td>
                                <td>{{ $feed->{'Txn Id'} }}</td>
                                <td><strong>₹ {{ number_format($feed->Amount, 0, '.', ',') }}</strong></td>
                                <td>{{ $feed->RRN }}</td>
                                <td>{{ $feed->{'Merchant Id'} }}</td>
                                <td>{{ $feed->Response }}</td>
                            </tr>
                            @empty
                            <td colspan="8">No records found</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 240px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: start; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px"><strong>PayG Feed (Axis)</strong></h6>
                <table class="custom-table2">
                    <thead>
                        <tr style="background-color: #6b0aac;color:white;height:40px">
                            <th>All</th>
                            <th>Acquirer Data</th>
                            <th>Acquirer Settlement</th>
                            <th>Merchant Settlement</th>
                            <th>Transaction Date Time</th>
                            <th>Payment Type</th>
                            <th>Processor Request ID</th>
                            <th>Authorized Amount</th>
                            <th>Fee Amount</th>
                            <th>GST Amount</th>
                            <th>Request UniqueId</th>
                            <th>Processed DateTime</th>
                            <th>Transaction Reference No</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($paygAxisFeeds as $index => $feed)


                        <tr>
                            <td>
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                            </td>
                            <td>
                                @if($feed->highlightRowForProcessorRequestId($feed->{'Processor RequestId'}) == 'highlight-green')
                                <input disabled type="checkbox" name="" id="myCheckbox" checked>
                                @else
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                                @endif
                            </td>
                            <td>
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                            </td>
                            <td>
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                            </td>
                            <td>{{ $feed->{'Transaction Datetime'} }}</td>
                            <td>{{ $feed->{'Payment Type'} }}</td>
                            <td>{{ $feed->{'Processor RequestId'} }}</td>
                            <td><strong>₹ {{ number_format($feed->{'Authorized Amount'}, 0, '.', ',') }}</strong></td>
                            <td><strong>₹ {{ number_format($feed->{'Fee Amount'}, 0, '.', ',') }}</strong></td>
                            <td><strong>₹ {{ number_format($feed->{'Gst Amount'}, 0, '.', ',') }}</strong></td>
                            <td>{{$feed->{'Request UniqueId'} }}</td>
                            <td>{{$feed->{'Processed DateTime'} }}</td>
                            <td>{{ $feed->{'TransactionReference Number'} }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $paygAxisFeeds->appends(['tab' => $tab])->links('custom-pagination-view') }}
                </div>
            </div>
            <div class="row m-0 p-0" style="font-size: 0.6rem;">
                <div class="col-md-12" style="border: 8px solid #6b0aac;">
                    <div class="row ml-1">
                        <div class="col total-amount">Total Count : <strong>{{$totalPaygAxisCount}}</strong></div>
                        <div class="col total-amount">Total Amount: <strong>₹ {{ number_format($paygAxisFeedAllTransAmt, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount">Total Diff Amount: <strong>₹ {{ number_format($diffAmountt, 0, '.', ',') }}</strong></div>
                    </div>
                    <hr style="margin: 0px;padding:0px">
                    <div class="row ml-1">
                        <div class="col total-amount">Matched Count : <strong>{{$matchedTxnIdsForPaygAxis}}</strong></div>
                        <div class="col total-amount">UnMatched Count : <strong>{{ number_format($unmatchedTxnIdsForPaygAxis, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount"></strong></div>
                    </div>
                </div>
            </div>
            <div class="row  m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                    <h6 style="width: 100%; text-align: start; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px;font-size:0.6rem"><strong>PayG (Axis) UNMatched List</strong></h6>
                    <table class="custom-table2">
                        <thead>
                            <tr style="background-color: #6b0aac;color:white;height:40px">
                                <th>ID</th>
                                <th>Transaction Date Time</th>
                                <th>Payment Type</th>
                                <th>Processor Request ID</th>
                                <th>Authorized Amount</th>
                                <th>Request UniqueId</th>
                                <th>Processed DateTime</th>
                                <th>Transaction Reference No</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unmatchedTxnIdsForPaygAxisList as $index=> $feed)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $feed->{'Transaction Datetime'} }}</td>
                                <td>{{ $feed->{'Payment Type'} }}</td>
                                <td>{{ $feed->{'Processor RequestId'} }}</td>
                                <td><strong>₹ {{ number_format($feed->{'Authorized Amount'}, 0, '.', ',') }}</strong></td>
                                <td>{{$feed->{'Request UniqueId'} }}</td>
                                <td>{{$feed->{'Processed DateTime'} }}</td>
                                <td>{{ $feed->{'TransactionReference Number'} }}</td>
                            </tr>
                            @empty
                            <td colspan="8">No records found</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @elseif($tab=="ICICI")
        <div class="row">
            <div class="col-md-12 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 240px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align: start; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px"><strong>ICICI Feed</strong></h6>
                <table class="custom-table1">
                    <thead>
                        <tr style="background-color: #2f84bc;color:white;height:47px">
                            <th>Acquirer Data</th>
                            <th>Transaction Date</th>
                            <th>Type Of Transaction</th>
                            <th>Txn Id</th>
                            <th>Amount</th>
                            <th>Commission</th>
                            <th>Service Tax</th>
                            <th>Net Amount</th>
                            <th>Bank Transaction Id</th>
                            <th>Merchant Id</th>
                            <th>Transaction Status</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($iciciFeed as $index => $feed)

                        <tr class="{{ $feed->highlightRowForProcessorRequestId($feed->merchantTranID) == 'highlight-green' ? 'highlight-green' : '' }}">
                            <td>
                                @if($feed->highlightRowForProcessorRequestId($feed->merchantTranID) == 'highlight-green')
                                <input disabled type="checkbox" name="" id="myCheckbox" checked>
                                @else
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                                @endif
                            </td>
                            <td>{{ $feed->date }}</td>
                            <td>{{ $feed->Remark }}</td>
                            <td>{{ $feed->merchantTranID}}</td>
                            <td><strong>₹ {{ number_format($feed->amount, 0, '.', ',') }}</strong></td>
                            <td><strong>₹ {{ number_format($feed->Commission, 0, '.', ',') }}</strong></td>
                            <td><strong>₹ {{ number_format($feed->{'Service tax'}, 0, '.', ',') }}</strong></td>
                            <td><strong>₹ {{ number_format($feed->{'Net amount'}, 0, '.', ',') }}</strong></td>
                            <td>{{ $feed->bankTranID }}</td>
                            <td>{{ $feed->merchantID }}</td>
                            <td>{{ $feed->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $iciciFeed->appends(['tab' => $tab])->links('custom-pagination-view') }}

                </div>
            </div>
            <div class="row m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #2f84bc;">
                    <div class="row ml-1">
                        <div class="col total-amount">Total Count : <strong>{{$totalICICICount}}</strong></div>
                        <div class="col total-amount">Total Amount : <strong>₹ {{ number_format($iciciFeedAllTransAmt, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount">Total Diff Amount : <strong>₹ {{ number_format($diffAmount, 0, '.', ',') }}</strong></div>
                    </div>
                    <hr style="margin: 0px;padding:0px">
                    <div class="row ml-1">
                        <div class="col total-amount">Matched Count : <strong>{{$matchedTxnIdsForICICI}}</strong></div>
                        <div class="col total-amount">UnMatched Count : <strong>{{ number_format($unmatchedTxnIdsForICICI, 0, '.', ',') }}</strong></div>
                        <div class="col total-amount"></strong></div>
                    </div>
                </div>
            </div>
            <div class="row m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #2f84bc; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                    <h6 style="width: 100%; text-align: start; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px;font-size:0.6rem"><strong>ICICI UNMatched List</strong></h6>
                    <table class="custom-table1">
                        <thead>
                            <tr style="background-color: #2f84bc;color:white;height:47px;">
                                <th>Id</th>
                                <th>Transaction Date</th>
                                <th>Type Of Transaction</th>
                                <th>Txn Id</th>
                                <th>Amount</th>
                                <th>Bank Transaction Id</th>
                                <th>Merchant Id</th>
                                <th>Transaction Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unmatchedTxnIdsForICICIList as $index => $feed)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $feed->date }}</td>
                                <td>{{ $feed->Remark }}</td>
                                <td>{{ $feed->merchantTranID}}</td>
                                <td><strong>₹ {{ number_format($feed->amount, 0, '.', ',') }}</strong></td>
                                <td>{{ $feed->bankTranID }}</td>
                                <td>{{ $feed->merchantID }}</td>
                                <td>{{ $feed->status }}</td>
                            </tr>
                            @empty
                            <td colspan="8">No records found</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-12 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 240px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: start; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px"><strong>PayG Feed (ICICI)</strong></h6>
                <table class="custom-table2">
                    <thead>
                        <tr style="background-color: #6b0aac;color:white;height:40px">
                            <th>All</th>
                            <th>Acquirer Data</th>
                            <th>Acquirer Settlement</th>
                            <th>Merchant Settlement</th>
                            <th>Transaction Date Time</th>
                            <th>Payment Type</th>
                            <th>Processor Request ID</th>
                            <th>Authorized Amount</th>
                            <th>Fee Amount</th>
                            <th>Gst Amount</th>
                            <th>Total Fee Amount</th>
                            <th>Request UniqueId</th>
                            <th>Processed DateTime</th>
                            <th>Transaction Reference No</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($paygIciciFeed as $index => $feed)


                        <tr>
                            <td>
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                            </td>
                            <td>
                                @if($feed->highlightRowForProcessorRequestId($feed->{'Processor RequestId'}) == 'highlight-green')
                                <input disabled type="checkbox" name="" id="myCheckbox" checked>
                                @else
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                                @endif
                            </td>
                            <td>
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                            </td>
                            <td>
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                            </td>
                            <td>{{ $feed->{'Transaction Datetime'} }}</td>
                            <td>{{ $feed->{'Payment Type'} }}</td>
                            <td>{{ $feed->{'Processor RequestId'} }}</td>
                            <td><strong>₹ {{ number_format($feed->{'Authorized Amount'}, 0, '.', ',') }}</strong></td>
                            <td><strong>₹ {{ number_format($feed->{'Fee Amount'}, 0, '.', ',') }}</strong></td>
                            <td><strong>₹ {{ number_format($feed->{'Gst Amount'}, 0, '.', ',') }}</strong></td>
                            <td><strong>₹ {{ number_format($feed->{'Total Fee Amount'}, 0, '.', ',') }}</strong></td>
                            <td>{{$feed->{'Request UniqueId'} }}</td>
                            <td>{{$feed->{'Processed DateTime'} }}</td>
                            <td>{{ $feed->{'TransactionReference Number'} }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $paygIciciFeed->appends(['tab' => $tab])->links('custom-pagination-view') }}

                </div>
            </div>
            <div class="row  m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #6b0aac;">
                    <div class="row ml-1">
                        <div class="col total-amount">Total Count : <strong>{{$totalPaygICICIcount}}</strong></div>
                        <div class="col total-amount">Total Amount: <strong>₹ {{ number_format($paygIciciFeedAllTransAmt, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount">Total Diff Amount: <strong>₹ {{ number_format($diffAmountt, 0, '.', ',') }}</strong></div>
                    </div>
                    <hr style="margin: 0px;padding:0px">
                    <div class="row ml-1">
                        <div class="col total-amount">Matched Count : <strong>{{$matchedTxnIdsForPaygICICI}}</strong></div>
                        <div class="col total-amount">UnMatched Count : <strong>{{ number_format($unmatchedTxnIdsForPaygICICI, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount"></strong></div>
                    </div>
                </div>
            </div>
            <div class="row m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                    <h6 style="width: 100%; text-align: start; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px;font-size:0.6rem"><strong>PayG (ICICI) UNMatched List</strong></h6>
                    <table class="custom-table2">
                        <thead>
                            <tr style="background-color: #6b0aac;color:white;height:40px">
                                <th>ID</th>
                                <th>Transaction Date Time</th>
                                <th>Payment Type</th>
                                <th>Processor Request ID</th>
                                <th>Authorized Amount</th>
                                <th>Total Fee Amount</th>
                                <th>Request UniqueId</th>
                                <th>Processed DateTime</th>
                                <th>Transaction Reference No</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unmatchedTxnIdsForPaygICICIList as $index=> $feed)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $feed->{'Transaction Datetime'} }}</td>
                                <td>{{ $feed->{'Payment Type'} }}</td>
                                <td>{{ $feed->{'Processor RequestId'} }}</td>
                                <td><strong>₹ {{ number_format($feed->{'Authorized Amount'}, 0, '.', ',') }}</strong></td>
                                <td><strong>₹ {{ number_format($feed->{'Total Fee Amount'}, 0, '.', ',') }}</strong></td>
                                <td>{{$feed->{'Request UniqueId'} }}</td>
                                <td>{{$feed->{'Processed DateTime'} }}</td>
                                <td>{{ $feed->{'TransactionReference Number'} }}</td>
                            </tr>
                            @empty
                            <td colspan="9">No records found</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @elseif($tab=="Induslnd")
        <div class="row">
            <div class="col-md-12 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 240px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align:  start; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px"><strong>Induslnd Feed</strong></h6>
                <table class="custom-table1">
                    <thead>
                        <tr style="background-color: #2f84bc;color:white;height:47px">
                            <th>Acquirer Data</th>
                            <th>RefId</th>
                            <th>RRN</th>
                            <th>TRANSACTION AMOUNT</th>
                            <th>MERCHANT TYPE</th>
                            <th>ORG ID</th>
                            <th>OUTLET ID</th>
                            <th>OUTLET NAME</th>
                            <th>MERCHANT ID</th>
                            <th>MERCHANT NAME</th>
                            <th>TRANSACTION DATE</th>
                            <th>PAYMENT MODE</th>
                            <th>MERCHANT OUTLET ID</th>
                            <th>CUSTOMER PAYMENT ID</th>
                            <th>TRANSACTION TIME</th>
                            <th>TRANSACTION ID</th>
                            <th>GST AMOUNT</th>
                            <th>FROM ACCOUNT</th>
                            <th>TO ACCOUNT</th>
                            <th>TRANSACTION STATUS</th>
                            <th>TRANSACTION DESCRIPTION</th>
                            <th>APPLICATION ORIGIN</th>
                            <th>TransactionSettlementDate</th>
                            <th>TransactionType</th>
                            <th>CUSTOMER_BANK</th>
                            <th>REMARKS</th>
                            <th>MerchantVPA</th>
                            <th>TxnNote</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach($induslndFeeds as $index => $feed)


                        <tr class="{{ $feed->highlightRowForProcessorRequestId($feed->{'Ref Id'}) == 'highlight-green' ? 'highlight-green' : '' }}">
                            <td>
                                @if($feed->highlightRowForProcessorRequestId($feed->{'Ref Id'}) == 'highlight-green')
                                <input disabled type="checkbox" name="" id="myCheckbox" checked>
                                @else
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                                @endif
                            </td>
                            <td>{{ $feed->{'Ref Id'} }}</td>
                            <td>{{ $feed->RRN }}</td>
                            <td><strong>{{ $feed->{'TRANSACTION AMOUNT'} }}</strong></td>
                            <td>{{ $feed->{'MERCHANT TYPE'} }}</td>
                            <td>{{ $feed->{'ORG ID'} }}</td>
                            <td>{{ $feed->{'OUTLET ID'} }}</td>
                            <td>{{ $feed->{'OUTLET NAME'} }}</td>
                            <td>{{ $feed->{'MERCHANT ID'} }}</td>
                            <td>{{ $feed->{'MERCHANT NAME'} }}</td>
                            <td>{{ $feed->{'TRANSACTION DATE'} }}</td>
                            <td>{{ $feed->{'PAYMENT MODE'} }}</td>
                            <td>{{ $feed->{'MERCHANT OUTLET ID'} }}</td>
                            <td>{{ $feed->{'CUSTOMER PAYMENT ID'} }}</td>
                            <td>{{ $feed->{'TRANSACTION TIME'} }}</td>
                            <td>{{ $feed->{'TRANSACTION ID'} }}</td>
                            <td>{{ $feed->{'GST AMOUNT'} }}</td>
                            <td>{{ $feed->{'FROM ACCOUNT'} }}</td>
                            <td>{{ $feed->{'TO ACCOUNT'} }}</td>
                            <td>{{ $feed->{'TRANSACTION STATUS'} }}</td>
                            <td>{{ $feed->{'TRANSACTION DESCRIPTION'} }}</td>
                            <td>{{ $feed->{'APPLICATION ORIGIN'} }}</td>
                            <td>{{ $feed->{'Transaction Settlement Date'} }}</td>
                            <td>{{ $feed->{'Transaction Type'} }}</td>
                            <td>{{ $feed->{'CUSTOMER BANK'} }}</td>
                            <td>{{ $feed->REMARKS }}</td>
                            <td>{{ $feed->{'Merchant VPA'} }}</td>
                            <td>{{ $feed->{'Txn Note'} }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $induslndFeeds->appends(['tab' => $tab])->links('custom-pagination-view') }}

                </div>

            </div>
            <div class="row m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #2f84bc;">
                    <div class="row ml-1">
                        <div class="col total-amount">Total Count : <strong>{{$totalInduslndCount}}</strong></div>
                        <div class="col total-amount">Total Amount : <strong>₹ {{ number_format($induslndFeedAllTransAmt, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount">Total Diff Amount : <strong>₹ {{ number_format($induslndDiffAmount, 0, '.', ',') }}</strong></div>
                    </div>
                    <hr style="margin: 0px;padding:0px">
                    <div class="row ml-1">
                        <div class="col total-amount">Matched Count : <strong>{{$matchedTxnIdsForInduslnd}}</strong></div>
                        <div class="col total-amount">UnMatched Count : <strong>{{ number_format($unmatchedTxnIdsForInduslnd, 0, '.', ',') }}</strong></div>
                        <div class="col total-amount"></strong></div>
                    </div>
                </div>
            </div>

            <div class="row  m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #2f84bc; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                    <h6 style="width: 100%; text-align: start; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px;font-size:0.6rem"><strong>Induslnd UNMatched List</strong></h6>
                    <table class="custom-table1">
                        <thead>
                            <tr style="background-color: #2f84bc;color:white;height:47px;">
                                <th>Id</th>
                                <th>RefId</th>
                                <th>RRN</th>
                                <th>TRANSACTION AMOUNT</th>
                                <th>MERCHANT TYPE</th>
                                <th>ORG ID</th>
                                <th>OUTLET ID</th>
                                <th>OUTLET NAME</th>
                                <th>MERCHANT ID</th>
                                <th>MERCHANT NAME</th>
                                <th>TRANSACTION DATE</th>
                                <th>PAYMENT MODE</th>
                                <th>MERCHANT OUTLET ID</th>
                                <th>CUSTOMER PAYMENT ID</th>
                                <th>TRANSACTION TIME</th>
                                <th>TRANSACTION ID</th>
                                <th>GST AMOUNT</th>
                                <th>FROM ACCOUNT</th>
                                <th>TO ACCOUNT</th>
                                <th>TRANSACTION STATUS</th>
                                <th>TRANSACTION DESCRIPTION</th>
                                <th>APPLICATION ORIGIN</th>
                                <th>TransactionSettlementDate</th>
                                <th>TransactionType</th>
                                <th>CUSTOMER_BANK</th>
                                <th>REMARKS</th>
                                <th>MerchantVPA</th>
                                <th>TxnNote</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unmatchedTxnIdsForInduslndList as $index => $feed)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $feed->{'Ref Id'} }}</td>
                                <td>{{ $feed->RRN }}</td>
                                <td><strong>{{ $feed->{'TRANSACTION AMOUNT'} }}</strong></td>
                                <td>{{ $feed->{'MERCHANT TYPE'} }}</td>
                                <td>{{ $feed->{'ORG ID'} }}</td>
                                <td>{{ $feed->{'OUTLET ID'} }}</td>
                                <td>{{ $feed->{'OUTLET NAME'} }}</td>
                                <td>{{ $feed->{'MERCHANT ID'} }}</td>
                                <td>{{ $feed->{'MERCHANT NAME'} }}</td>
                                <td>{{ $feed->{'TRANSACTION DATE'} }}</td>
                                <td>{{ $feed->{'PAYMENT MODE'} }}</td>
                                <td>{{ $feed->{'MERCHANT OUTLET ID'} }}</td>
                                <td>{{ $feed->{'CUSTOMER PAYMENT ID'} }}</td>
                                <td>{{ $feed->{'TRANSACTION TIME'} }}</td>
                                <td>{{ $feed->{'TRANSACTION ID'} }}</td>
                                <td>{{ $feed->{'GST AMOUNT'} }}</td>
                                <td>{{ $feed->{'FROM ACCOUNT'} }}</td>
                                <td>{{ $feed->{'TO ACCOUNT'} }}</td>
                                <td>{{ $feed->{'TRANSACTION STATUS'} }}</td>
                                <td>{{ $feed->{'TRANSACTION DESCRIPTION'} }}</td>
                                <td>{{ $feed->{'APPLICATION ORIGIN'} }}</td>
                                <td>{{ $feed->TransactionSettlementDate }}</td>
                                <td>{{ $feed->TransactionType }}</td>
                                <td>{{ $feed->{'CUSTOMER BANK'} }}</td>
                                <td>{{ $feed->REMARKS }}</td>
                                <td>{{ $feed->MerchantVPA }}</td>
                                <td>{{ $feed->TxnNote }}</td>
                            </tr>
                            @empty
                            <td colspan="29">No records found</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-12 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 240px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align:  start; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px"><strong>PayG Feed (Induslnd)</strong></h6>
                <table class="custom-table2">
                    <thead>
                        <tr style="background-color: #6b0aac;color:white;height:40px">
                            <th>All</th>
                            <th>Acquirer Data</th>
                            <th>Acquirer Settlement</th>
                            <th>Merchant Settlement</th>
                            <th>ProcessorRequestId</th>
                            <th>AuthorizedAmount</th>
                            <th>TransactionReferenceNumber</th>
                            <th>BatchId</th>
                            <th>ProcessorName</th>
                            <th>RequestUniqueId</th>
                            <th>ReconTransactionId</th>
                            <th>TransactionId</th>
                            <th>TransactionDatetime</th>
                            <th>ProcessedDateTime</th>
                            <th>PaymentType</th>
                            <th>TransactionType</th>
                            <th>Diff</th>
                            <th>FeeAmount</th>
                            <th>GstAmount</th>
                            <th>TotalFeeAmount</th>
                            <th>SettlementVerified</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($paygInduslndFeeds as $index => $feed)

                        <tr>
                            <td>
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                            </td>
                            <td>
                                @if($feed->highlightRowForProcessorRequestId($feed->{'Processor RequestId'}) == 'highlight-green')
                                <input disabled type="checkbox" name="" id="myCheckbox" checked>
                                @else
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                                @endif
                            </td>
                            <td>
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                            </td>
                            <td>
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                            </td>
                            <td>{{ $feed->{'Processor RequestId'} }}</td>
                            <td><strong>{{ $feed->{'Authorized Amount'} }}</strong></td>
                            <td>{{ $feed->{'TransactionReference Number'} }}</td>
                            <td>{{ $feed->{'Batch Id'} }}</td>
                            <td>{{ $feed->{'Processor Name'} }}</td>
                            <td>{{ $feed->{'Request UniqueId'} }}</td>
                            <td>{{ $feed->{'Recon TransactionId'} }}</td>
                            <td>{{ $feed->{'Transaction Id'} }}</td>
                            <td>{{ $feed->{'Transaction Datetime'} }}</td>
                            <td>{{ $feed->{'Processed DateTime'} }}</td>
                            <td>{{ $feed->{'Payment Type'} }}</td>
                            <td>{{ $feed->{'Transaction Type'} }}</td>
                            <td>{{ $feed->Diff }}</td>
                            <td>{{ $feed->{'Fee Amount'} }}</td>
                            <td>{{ $feed->{'Gst Amount'} }}</td>
                            <td>{{ $feed->{'Total Fee Amount'} }}</td>
                            <td>{{ $feed->{'Settlement Verified'} }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $paygInduslndFeeds->appends(['tab' => $tab])->links('custom-pagination-view') }}

                </div>
            </div>
            <div class="row m-0 p-0" style="font-size: 0.6rem;">
                <div class="col-md-12" style="border: 8px solid #6b0aac;">
                    <div class="row ml-1">
                        <div class="col total-amount">Total Count : <strong>{{$totalPaygInduslndCount}}</strong></div>
                        <div class="col total-amount">Total Amount: <strong>₹ {{ number_format($paygInduslndFeedAllTransAmt, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount">Total Diff Amount : <strong>₹ {{ number_format($paygInduslndDiffAmount, 0, '.', ',') }}</strong></div>

                    </div>
                    <hr style="margin: 0px;padding:0px">
                    <div class="row ml-1">
                        <div class="col total-amount">Matched Count : <strong>{{$matchedTxnIdsForPaygInduslnd}}</strong></div>
                        <div class="col total-amount">UnMatched Count : <strong>{{ number_format($unmatchedTxnIdsForPaygInduslnd, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount"></strong></div>
                    </div>
                </div>
            </div>
            <div class="row m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                    <h6 style="width: 100%; text-align: start; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px;font-size:0.6rem"><strong>PayG (Induslnd) UNMatched List</strong></h6>
                    <table class="custom-table2">
                        <thead>
                            <tr style="background-color: #6b0aac;color:white;height:40px">
                                <th>ID</th>
                                <th>ProcessorRequestId</th>
                                <th>AuthorizedAmount</th>
                                <th>TransactionReferenceNumber</th>
                                <th>BatchId</th>
                                <th>ProcessorName</th>
                                <th>RequestUniqueId</th>
                                <th>ReconTransactionId</th>
                                <th>TransactionId</th>
                                <th>TransactionDatetime</th>
                                <th>ProcessedDateTime</th>
                                <th>PaymentType</th>
                                <th>TransactionType</th>
                                <th>Diff</th>
                                <th>FeeAmount</th>
                                <th>GstAmount</th>
                                <th>TotalFeeAmount</th>
                                <th>SettlementVerified</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unmatchedTxnIdsForPaygInduslndList as $index=> $feed)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $feed->{'Processor RequestId'} }}</td>
                                <td><strong>{{ $feed->{'Authorized Amount'} }}</strong></td>
                                <td>{{ $feed->{'TransactionReference Number'} }}</td>
                                <td>{{ $feed->{'Batch Id'} }}</td>
                                <td>{{ $feed->{'Processor Name'} }}</td>
                                <td>{{ $feed->{'Request UniqueId'} }}</td>
                                <td>{{ $feed->{'Recon TransactionId'} }}</td>
                                <td>{{ $feed->{'Transaction Id'} }}</td>
                                <td>{{ $feed->{'Transaction Datetime'} }}</td>
                                <td>{{ $feed->{'Processed DateTime'} }}</td>
                                <td>{{ $feed->{'Payment Type'} }}</td>
                                <td>{{ $feed->{'Transaction Type'} }}</td>
                                <td>{{ $feed->Diff }}</td>
                                <td>{{ $feed->{'Fee Amount'} }}</td>
                                <td>{{ $feed->{'Gst Amount'} }}</td>
                                <td>{{ $feed->{'Total Fee Amount'} }}</td>
                                <td>{{ $feed->{'Settlement Verified'} }}</td>
                            </tr>
                            @empty
                            <td colspan="18">No records found</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @elseif($tab=="Kotak")
        <div class="row">
            <div class="col-md-12 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 240px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align:  start; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px"><strong>Kotak Feed</strong></h6>
                <table class="custom-table1">
                    <thead>
                        <tr style="background-color: #2f84bc;color:white;height:47px">
                            <th>Acquirer Data</th>
                            <th>NVL TSDK ORDERID</th>
                            <th>REFID</th>
                            <th>AMOUNT</th>
                            <th>AGGREGATORCODE</th>
                            <th>MERCHANTID</th>
                            <th>TRANSACTION DATE</th>
                            <th>PAYEE VPA</th>
                            <th>Payee ACCOUNT NUMBER</th>
                            <th>Payee IFSC Code</th>
                            <th>PAYER ACCOUNT NUMBER</th>
                            <th>PAYER IFSC</th>
                            <th>PAYER VPA</th>
                            <th>PAYER NAME</th>
                            <th>RESPONSE CODE</th>
                            <th>TRANSACTION ID</th>
                            <th>DEBIT NBIN</th>
                            <th>TRANSACTION STATUS</th>
                            <th>MCC CODE</th>
                            <th>MDR CHARGED</th>
                            <th>GST</th>
                            <th>NET AMOUNT</th>
                            <th>NVL TSDK REMARKS CBS REMARKS</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($kotakFeeds as $index => $feed)


                        <tr class="{{ $feed->highlightRowForProcessorRequestId($feed->{'NVL_TSDK ORDERID'}) == 'highlight-green' ? 'highlight-green' : '' }}">
                            <td>
                                @if($feed->highlightRowForProcessorRequestId($feed->{'NVL_TSDK ORDERID'}) == 'highlight-green')
                                <input disabled type="checkbox" name="" id="myCheckbox" checked>
                                @else
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                                @endif
                            </td>
                            <td>{{ $feed->{'NVL_TSDK ORDERID'} }}</td>
                            <td>{{ $feed->REFID }}</td>
                            <td><strong>{{ $feed->AMOUNT }}</strong></td>
                            <td>{{ $feed->AGGREGATORCODE }}</td>
                            <td>{{ $feed->MERCHANTID }}</td>
                            <td>{{ $feed->TRANSACTION_DATE }}</td>
                            <td>{{ $feed->PAYEE_VPA }}</td>
                            <td>{{ $feed->Payee_ACCOUNT_NUMBER }}</td>
                            <td>{{ $feed->Payee_IFSC_Code }}</td>
                            <td>{{ $feed->PAYER_ACCOUNT_NUMBER }}</td>
                            <td>{{ $feed->PAYER_IFSC }}</td>
                            <td>{{ $feed->PAYER_VPA }}</td>
                            <td>{{ $feed->PAYER_NAME }}</td>
                            <td>{{ $feed->RESPONSE_CODE }}</td>
                            <td>{{ $feed->TRANSACTION_ID }}</td>
                            <td>{{ $feed->DEBIT_NBIN }}</td>
                            <td>{{ $feed->TRANSACTION_STATUS }}</td>
                            <td>{{ $feed->MCC_CODE }}</td>
                            <td>{{ $feed->MDR_CHARGED }}</td>
                            <td>{{ $feed->GST }}</td>
                            <td>{{ $feed->NET_AMOUNT }}</td>
                            <td>{{ $feed->NVL_TSDK_REMARKS_CBS_REMARKS_ }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $kotakFeeds->appends(['tab' => $tab])->links('custom-pagination-view') }}

                </div>
            </div>
            <div class="row m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #2f84bc;">
                    <div class="row ml-1">
                        <div class="col total-amount">Total Count : <strong>{{$totalKotakCount}}</strong></div>
                        <div class="col total-amount">Total Amount : <strong>₹ {{ number_format($kotakFeedAllTransAmt, 0, '.', ',') }}</strong></div>
                        <div class="col diff-amount">Total Diff Amount : <strong>₹ {{ number_format($diffKotakAmount, 0, '.', ',') }}</strong></div>
                    </div>
                    <hr style="margin: 0px;padding:0px">
                    <div class="row ml-1">
                        <div class="col total-amount">Matched Count : <strong>{{$matchedTxnIdsForKotak}}</strong></div>
                        <div class="col total-amount">UnMatched Count : <strong>{{ number_format($unmatchedTxnIdsForKotak, 0, '.', ',') }}</strong></div>
                        <div class="col total-amount"></strong></div>
                    </div>
                </div>
            </div>

            <div class="row  m-0 p-0">
                <div class="col-md-12" style="border: 8px solid #2f84bc; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                    <h6 style="width: 100%; text-align: start; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px;font-size:0.6rem"><strong>Kotak UNMatched List</strong></h6>
                    <table class="custom-table1">
                        <thead>
                            <tr style="background-color: #2f84bc;color:white;height:47px;">
                                <th>Id</th>
                                <th>NVL TSDK ORDERID</th>
                                <th>REFID</th>
                                <th>AMOUNT</th>
                                <th>AGGREGATORCODE</th>
                                <th>MERCHANTID</th>
                                <th>TRANSACTION DATE</th>
                                <th>PAYEE VPA</th>
                                <th>Payee ACCOUNT NUMBER</th>
                                <th>Payee IFSC Code</th>
                                <th>PAYER ACCOUNT NUMBER</th>
                                <th>PAYER IFSC</th>
                                <th>PAYER VPA</th>
                                <th>PAYER NAME</th>
                                <th>RESPONSE CODE</th>
                                <th>TRANSACTION ID</th>
                                <th>DEBIT NBIN</th>
                                <th>TRANSACTION STATUS</th>
                                <th>MCC CODE</th>
                                <th>MDR CHARGED</th>
                                <th>GST</th>
                                <th>NET AMOUNT</th>
                                <th>NVL TSDK REMARKS CBS REMARKS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($unmatchedTxnIdsForKotakList as $index => $feed)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $feed->{'NVL_TSDK ORDERID'} }}</td>
                                <td>{{ $feed->REFID }}</td>
                                <td><strong>{{ $feed->AMOUNT }}</strong></td>
                                <td>{{ $feed->AGGREGATORCODE }}</td>
                                <td>{{ $feed->MERCHANTID }}</td>
                                <td>{{ $feed->TRANSACTION_DATE }}</td>
                                <td>{{ $feed->PAYEE_VPA }}</td>
                                <td>{{ $feed->Payee_ACCOUNT_NUMBER }}</td>
                                <td>{{ $feed->Payee_IFSC_Code }}</td>
                                <td>{{ $feed->PAYER_ACCOUNT_NUMBER }}</td>
                                <td>{{ $feed->PAYER_IFSC }}</td>
                                <td>{{ $feed->PAYER_VPA }}</td>
                                <td>{{ $feed->PAYER_NAME }}</td>
                                <td>{{ $feed->RESPONSE_CODE }}</td>
                                <td>{{ $feed->TRANSACTION_ID }}</td>
                                <td>{{ $feed->DEBIT_NBIN }}</td>
                                <td>{{ $feed->TRANSACTION_STATUS }}</td>
                                <td>{{ $feed->MCC_CODE }}</td>
                                <td>{{ $feed->MDR_CHARGED }}</td>
                                <td>{{ $feed->GST }}</td>
                                <td>{{ $feed->NET_AMOUNT }}</td>
                                <td>{{ $feed->NVL_TSDK_REMARKS_CBS_REMARKS_ }}</td>
                            </tr>
                            @empty
                            <td colspan="23">No records found</td>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-md-12" style="border: 8px solid rgb(161, 59, 105);">
                        <h6 style="width: 100%; text-align: start; margin: 0px; color: rgb(161, 59, 105); padding: 0px;margin-top:5px;font-size:0.6rem"><strong>Total Difference Amount List</strong></h6>
                        <table class="custom-table1">
                            <thead>
                                <tr style="background-color:rgb(161, 59, 105);color:white;height:47px;">
                                    <th>NVL TSDK ORDERID</th>
                                    <th>Amount</th>
                                    <th>Processor RequestId</th>
                                    <th>Authorized Amount</th>
                                    <th>Amount Difference</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($results as $result)
                                <tr>
                                    <td>{{ $result->{'NVL_TSDK ORDERID'} }}</td>
                                    <td>{{ $result->AMOUNT }}</td>
                                    <td>{{ $result->{'Processor RequestId'} }}</td>
                                    <td>{{ $result->{'Authorized Amount'} }}</td>
                                    <td>{{ $result->{'Amount Difference'} }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 240px; max-height: auto; max-width: auto">
                    <h6 style="width: 100%; text-align:  start; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px"><strong>PayG Feed (Kotak)</strong></h6>
                    <table class="custom-table2">
                        <thead>
                            <tr style="background-color: #6b0aac;color:white;height:40px">
                                <th>All</th>
                                <th>Acquirer Data</th>
                                <th>Acquirer Settlement</th>
                                <th>Merchant Settlement</th>
                                <th>Transaction Reference Number</th>
                                <th>Processor Request Id</th>
                                <th>Authorized Amount</th>
                                <th>Batch Id</th>
                                <th>Processor Name</th>
                                <th>Request Unique Id</th>
                                <th>Recon Transaction Id</th>
                                <th>Transaction Id</th>
                                <th>Transaction Datetime</th>
                                <th>Processed Datetime</th>
                                <th>Payment Type</th>
                                <th>Transaction Type</th>
                                <th>Diff</th>
                                <th>Fee Amount</th>
                                <th>Gst Amount</th>
                                <th>Total Fee Amount</th>
                                <th>Settlement Verified</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($paygKotakFeeds as $index => $feed)

                            <tr>
                                <td><input disabled type="checkbox" name="" id="myUnCheckbox"></td>
                                <td>
                                    @if($feed->highlightRowForProcessorRequestId($feed->{'Processor RequestId'}) == 'highlight-green')
                                    <input disabled type="checkbox" name="" id="myCheckbox" checked>
                                    @else
                                    <input disabled type="checkbox" name="" id="myUnCheckbox">
                                    @endif
                                </td>
                                <td><input disabled type="checkbox" name="" id="myUnCheckbox"></td>
                                <td><input disabled type="checkbox" name="" id="myUnCheckbox"></td>
                                <td>{{ $feed->{'TransactionReference Number'} }}</td>
                                <td>{{ $feed->{'Processor RequestId'} }}</td>
                                <td><strong>{{ $feed->{'Authorized Amount'} }}</strong></td>
                                <td>{{ $feed->{'Batch Id'} }}</td>
                                <td>{{ $feed->{'Processor Name'} }}</td>
                                <td>{{ $feed->{'Request UniqueId'} }}</td>
                                <td>{{ $feed->{'ReconTransaction Id'} }}</td>
                                <td>{{ $feed->{'Transaction Id'} }}</td>
                                <td>{{ $feed->{'Transaction Datetime'} }}</td>
                                <td>{{ $feed->{'Processed DateTime'} }}</td>
                                <td>{{ $feed->{'Payment Type'} }}</td>
                                <td>{{ $feed->{'Transaction Type'} }}</td>
                                <td>{{ $feed->{'Diff'} }}</td>
                                <td>{{ $feed->{'Fee Amount'} }}</td>
                                <td>{{ $feed->{'Gst Amount'} }}</td>
                                <td>{{ $feed->{'Total Fee Amount'} }}</td>
                                <td>{{ $feed->{'Settlement Verified'} }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination">
                        {{ $paygKotakFeeds->appends(['tab' => $tab])->links('custom-pagination-view') }}

                    </div>
                </div>
                <div class="row m-0 p-0" style="font-size: 0.6rem;">
                    <div class="col-md-12" style="border: 8px solid #6b0aac;">
                        <div class="row ml-1">
                            <div class="col total-amount">Total Count : <strong>{{$totalPaygKotakCount}}</strong></div>
                            <div class="col total-amount">Total Amount: <strong>₹ {{ number_format($paygKotakFeedAllTransAmt, 0, '.', ',') }}</strong></div>
                            <div class="col diff-amount">Total Diff Amount : <strong>₹ {{ number_format($diffPaygKotakAmount, 0, '.', ',') }}</strong></div>

                        </div>
                        <hr style="margin: 0px;padding:0px">
                        <div class="row ml-1">
                            <div class="col total-amount">Matched Count : <strong>{{$matchedTxnIdsForPaygKotak}}</strong></div>
                            <div class="col total-amount">UnMatched Count : <strong>{{ number_format($unmatchedTxnIdsForPaygKotak, 0, '.', ',') }}</strong></div>
                            <div class="col diff-amount"></strong></div>
                        </div>
                    </div>
                </div>
                <div class="row m-0 p-0">
                    <div class="col-md-12" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                        <h6 style="width: 100%; text-align: start; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px;font-size:0.6rem"><strong>PayG (Kotak) UNMatched List</strong></h6>
                        <table class="custom-table2">
                            <thead>
                                <tr style="background-color: #6b0aac;color:white;height:40px">
                                    <th>Id</th>
                                    <th>Transaction Reference Number</th>
                                    <th>Processor Request Id</th>
                                    <th>Authorized Amount</th>
                                    <th>Batch Id</th>
                                    <th>Processor Name</th>
                                    <th>Request Unique Id</th>
                                    <th>Recon Transaction Id</th>
                                    <th>Transaction Id</th>
                                    <th>Transaction Datetime</th>
                                    <th>Processed Datetime</th>
                                    <th>Payment Type</th>
                                    <th>Transaction Type</th>
                                    <th>Diff</th>
                                    <th>Fee Amount</th>
                                    <th>Gst Amount</th>
                                    <th>Total Fee Amount</th>
                                    <th>Settlement Verified</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($unmatchedTxnIdsForPaygKotakList as $index => $feed)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $feed->{'TransactionReference Number'} }}</td>
                                    <td>{{ $feed->{'Processor RequestId'} }}</td>
                                    <td><strong>{{ $feed->{'Authorized Amount'} }}</strong></td>
                                    <td>{{ $feed->{'Batch Id'} }}</td>
                                    <td>{{ $feed->{'Processor Name'} }}</td>
                                    <td>{{ $feed->{'Request UniqueId'} }}</td>
                                    <td>{{ $feed->{'ReconTransaction Id'} }}</td>
                                    <td>{{ $feed->{'Transaction Id'} }}</td>
                                    <td>{{ $feed->{'Transaction Datetime'} }}</td>
                                    <td>{{ $feed->{'Processed DateTime'} }}</td>
                                    <td>{{ $feed->{'Payment Type'} }}</td>
                                    <td>{{ $feed->{'Transaction Type'} }}</td>
                                    <td>{{ $feed->{'Diff'} }}</td>
                                    <td>{{ $feed->{'Fee Amount'} }}</td>
                                    <td>{{ $feed->{'Gst Amount'} }}</td>
                                    <td>{{ $feed->{'Total Fee Amount'} }}</td>
                                    <td>{{ $feed->{'Settlement Verified'} }}</td>
                                </tr>
                                @empty
                                <td colspan="18">No records found</td>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
</body>

</html>
@endsection