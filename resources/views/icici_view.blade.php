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
                <h6 style="width: 100%; text-align: center; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px"><strong>ICICI Feed</strong></h6>
                <table class="custom-table1">
                    <thead>
                        <tr style="background-color: #2f84bc;color:white;height:47px">
                            <th>Acquirer Data</th>
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
                            <td>{{ $feed->bankTranID }}</td>
                            <td>{{ $feed->merchantID }}</td>
                            <td>{{ $feed->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $iciciFeed->links('custom-pagination-view') }}
                </div>
            </div>
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 520px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: center; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px"><strong>PayG Feed (ICICI)</strong></h6>
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
                            <td><strong>₹ {{ number_format($feed->{'Total Fee Amount'}, 0, '.', ',') }}</strong></td>
                            <td>{{$feed->{'Request UniqueId'} }}</td>
                            <td>{{$feed->{'Processed DateTime'} }}</td>
                            <td>{{ $feed->{'TransactionReference Number'} }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $paygIciciFeed->links('custom-pagination-view') }}
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 0.5rem;">
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #2f84bc;">
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
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac;">
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


        <div class="row">
            <div class="col-md-6 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align: center; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px;font-size:0.6rem"><strong>ICICI UNMatched List</strong></h6>
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
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: center; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px;font-size:0.6rem"><strong>PayG (ICICI) UNMatched List</strong></h6>
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
</body>

</html>
@endsection