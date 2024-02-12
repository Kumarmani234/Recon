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
                <h6 style="width: 100%; text-align: center; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px"><strong>Kotak Feed</strong></h6>
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
                    {{ $kotakFeeds->links('custom-pagination-view') }}
                </div>
            </div>
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 520px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: center; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px"><strong>PayG Feed (Kotak)</strong></h6>
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
                    {{ $paygKotakFeeds->links('custom-pagination-view') }}
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 0.5rem;">
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #2f84bc;">
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
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac;">
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


        <div class="row">
            <div class="col-md-6 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align: center; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px;font-size:0.6rem"><strong>Kotak UNMatched List</strong></h6>
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
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: center; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px;font-size:0.6rem"><strong>PayG (Kotak) UNMatched List</strong></h6>
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

        <div class="row">
            <div class="col-md-12 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto; border: 8px solid rgb(161, 59, 105); margin-left: 8px">
                <h6 style="width: 100%; text-align: center; margin: 0px; color: rgb(161, 59, 105); padding: 0px;margin-top:5px;font-size:0.6rem"><strong>Total Difference Amount List</strong></h6>
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
    </div>
</body>

</html>
@endsection