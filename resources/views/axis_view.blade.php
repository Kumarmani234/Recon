@extends('home')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cosmos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('/css/app.css');
    </style>
</head>

<body>
    <div style="margin-left: 12px;">
        <div class="row">
            <div class="col-md-6 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 520px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align: center; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px"><strong>Axis Feed</strong></h6>
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
                            <td>{{ $feed->Response }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $axisFeeds->links('custom-pagination-view') }}
                </div>
            </div>
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 520px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: center; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px"><strong>PayG Feed (Axis)</strong></h6>
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
                            <td>{{$feed->{'Request UniqueId'} }}</td>
                            <td>{{$feed->{'Processed DateTime'} }}</td>
                            <td>{{ $feed->{'TransactionReference Number'} }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $paygAxisFeeds->links('custom-pagination-view') }}
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 0.5rem;">
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #2f84bc;">
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
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac;">
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


        <div class="row">
            <div class="col-md-6 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align: center; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px;font-size:0.6rem"><strong>Axis UNMatched List</strong></h6>
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
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: center; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px;font-size:0.6rem"><strong>PayG (Axis) UNMatched List</strong></h6>
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
</body>

</html>
@endsection