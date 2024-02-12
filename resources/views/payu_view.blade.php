@extends('home')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PayU</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    @import url('/css/app.css');
</style>

<body>
    <div style="margin-left: 12px;">
        <div class="row">
            <div class="col-md-6 m-0 p-0" style="overflow-y: auto;overflow-x:auto;height:520px;max-height:auto;max-width:auto;border:8px solid #2f84bc;margin-left:8px">
                <h6 style="width:100%;text-align: center;margin:0px;color:  #2f84bc;padding:0px;margin-top:5px"><strong>PayU Feed</strong></h6>
                <table class="custom-table1">
                    <thead>
                        <tr style="background-color: #2f84bc;color:white;height:40px">
                            <th>Acquirer Data</th>
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
                            <td>{{ $feed->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $payuFeeds->links('custom-pagination-view') }}
                </div>

            </div>
            <div class="col-md-6 m-0 p-0" style="border:8px solid #6b0aac;overflow-y: auto;overflow-x:auto;height:520px;max-height:auto;max-width:auto">
                <h6 style="width:100%;text-align: center;margin:0px;padding:0px;color:#6b0aac;margin-top:5px"><strong>PayG Feed (PayU)</strong></h6>
                <table class="custom-table1">
                    <thead>
                        <tr style="background-color: #6b0aac;color:white;height:40px">
                            <th>All</th>
                            <th>Acquirer Data</th>
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
                            <th>Response Text</th>
                        </tr>
                    </thead>
                    <tbody>
                 
                        @foreach($paygPayUFeeds as $index=> $feed)
                
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
                                <strong> ₹ {{ number_format($feed->TransactionAmount, 0, '.', ',') }}</strong>
                                @else
                                --
                                @endif
                            </td>
                            <td>{{ $feed->TransactionReferenceNo }}</td>
                            <td>{{ $feed->MerchantKeyId }}</td>
                            <td>{{ $feed->ProcessorId }}</td>
                            <td>{{ $feed->ResponseText }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $paygPayUFeeds->links('custom-pagination-view') }}
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 0.5rem;">
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #2f84bc;">
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
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac;">
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

        
        <div class="row">
            <div class="col-md-6 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align: center; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px;font-size:0.6rem"><strong>PayU UNMatched List</strong></h6>
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
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: center; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px;font-size:0.6rem"><strong>PayG (PayU) UNMatched List</strong></h6>
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
</body>

</html>
@endsection