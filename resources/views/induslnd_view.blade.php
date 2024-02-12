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
                <h6 style="width: 100%; text-align: center; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px"><strong>Induslnd Feed</strong></h6>
                <table class="custom-table1">
                    <thead>
                        <tr style="background-color: #2f84bc;color:white;height:40px">
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
                            <td>{{ $feed->TransactionSettlementDate }}</td>
                            <td>{{ $feed->TransactionType }}</td>
                            <td>{{ $feed->{'CUSTOMER BANK'} }}</td>
                            <td>{{ $feed->REMARKS }}</td>
                            <td>{{ $feed->MerchantVPA }}</td>
                            <td>{{ $feed->TxnNote }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="pagination">
                    {{ $induslndFeeds->links('custom-pagination-view') }}
                </div>

            </div>
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 520px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: center; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px"><strong>PayG Feed (Induslnd)</strong></h6>
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
                    {{ $paygInduslndFeeds->links('custom-pagination-view') }}
                </div>
            </div>
        </div>
        <div class="row" style="font-size: 0.5rem;">
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #2f84bc;">
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
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac;">
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


        <div class="row">
            <div class="col-md-6 m-0 p-0" style="overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto; border: 8px solid #2f84bc; margin-left: 8px">
                <h6 style="width: 100%; text-align: center; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px;font-size:0.6rem"><strong>Induslnd UNMatched List</strong></h6>
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
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 150px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: center; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px;font-size:0.6rem"><strong>PayG (Induslnd) UNMatched List</strong></h6>
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
</body>

</html>
@endsection