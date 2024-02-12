@extends('home')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
@vite(['resources/css/app.css', 'resources/js/app.js'])
<style>
    @import url('/css/app.css');
</style>


<body>
    <div style="margin-left: 12px;">
        <div class="row">
            <div class="col-md-6 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 520px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align: center; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px"><strong>Cosmos Feed</strong></h6>
                <table class="custom-table1">
                    <thead>
                        <tr style="background-color: #2f84bc;color:white;height:47px">
                            <th>Acquirer Data</th>
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
                        @php
                        $matchedCount = 0;
                        $unmatchedCount = 0;
                        @endphp
                        @foreach($acquirerFeeds as $index => $feed)
                        @php
                        $highlightClass = $feed->highlightRowForProcessorRequestId($feed->{'Ext Id'}) ? 'highlight-green' : '';
                        if ($highlightClass === 'highlight-green') {
                        $matchedCount++;
                        } else {
                        $unmatchedCount++;
                        }
                        @endphp
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
                            <td>{{ $feed->{'Transaction Status'} }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $acquirerFeeds->links('custom-pagination-view') }}
                </div>
            </div>
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 520px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: center; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px"><strong>PayG Feed (Cosmos)</strong></h6>
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
                            <th>NPCI Txn ID</th>
                            <th>Transaction Reference No</th>
                            <th>Processed Date Time</th>
                            <th>Processor ID</th>
                            <th>Response Text</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $matchedCountt = 0;
                        $unmatchedCountt = 0;
                        @endphp
                        @foreach($mmsReconDats as $index=> $data)
                        @php
                        $highlightClass = $data->highlightRowForProcessorRequestId($data->ProcessorRequestId) ? 'highlight-green' : '';
                        if ($highlightClass === 'highlight-green') {
                        $matchedCountt++;
                        } else {
                        $unmatchedCountt++;
                        }
                        @endphp
                        <tr>
                            <td><input disabled type="checkbox" name="" id="myUnCheckbox"></td>
                            <td>
                                @if($data->highlightRowForProcessorRequestId($data->ProcessorRequestId) == 'highlight-green')
                                <input disabled type="checkbox" name="" id="myCheckbox" checked>
                                @else
                                <input disabled type="checkbox" name="" id="myUnCheckbox">
                                @endif
                            </td>
                            <td><input disabled type="checkbox" name="" id="myUnCheckbox"></td>
                            <td><input disabled type="checkbox" name="" id="myUnCheckbox"></td>
                            <td>{{ $data->TransactionDateTime }}</td>
                            <td>{{ $data->PaymentType }}</td>
                            <td>{{ $data->ProcessorRequestId }}</td>
                            <td><strong>₹ {{ number_format($data->AuthorizedAmount, 0, '.', ',') }}</strong></td>
                            <td>@if($data->NPCITxnId==null)
                                --
                                @else
                                {{ $data->NPCITxnId }}
                                @endif
                            </td>
                            <td>@if($data->TransactionReferenceNo==null)
                                --
                                @else
                                {{ $data->TransactionReferenceNo }}
                                @endif
                            </td>
                            <td>{{ $data->ProcessedDateTime }}</td>
                            <td>{{ $data->ProcessorId }}</td>
                            <td>{{ $data->ResponseText }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $mmsReconDats->links('custom-pagination-view') }}
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 0.5rem;">
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #2f84bc;">
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
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac;">
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



        <div class="row">
            <div class="col-md-6 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align: center; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px;font-size:0.6rem"><strong>Comsos UNMatched List</strong></h6>
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
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: center; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px;font-size:0.6rem"><strong>PayG (Comsos) UNMatched List</strong></h6>
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
        <div class="row">
            <div class="col-md-6 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align: center; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px;font-size:0.6rem"><strong>Comsos Matched List</strong></h6>
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
                        @forelse($matchedTxnIdsCosmos as $index => $feed)
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
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: center; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px;font-size:0.6rem"><strong>PayG (Comsos) Matched List</strong></h6>
                <table class="custom-table2">
                    <thead>
                        <tr style="background-color: #6b0aac;color:white;height:40px">
                            <th>ID</th>
                            <th>Transaction Date Time</th>
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
                        @forelse($matchedTxnIdsPaygCosmso as $index=> $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->TransactionDateTime }}</td>
                            <td>{{ $data->PaymentType }}</td>
                            <td>{{ $data->ProcessorRequestId }}</td>
                            <td><strong>₹ {{ number_format($data->AuthorizedAmount, 0, '.', ',') }}</strong></td>
                            <td>@if($data->NPCITxnId==null)
                                --
                                @else
                                {{ $data->NPCITxnId }}
                                @endif
                            </td>
                            <td>@if($data->TransactionReferenceNo==null)
                                --
                                @else
                                {{ $data->TransactionReferenceNo }}
                                @endif
                            </td>
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
</body>

</html>
@endsection