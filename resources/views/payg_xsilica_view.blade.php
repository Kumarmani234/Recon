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
                <h6 style="width: 100%; text-align: center; margin: 0px; color: #2f84bc; padding: 0px;margin-top:5px"><strong>PaygXsilica Feed</strong></h6>
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
                        <tr>
                            <td colspan="8">No Data Found</td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac; overflow-y: auto; overflow-x: auto; height: 520px; max-height: auto; max-width: auto">
                <h6 style="width: 100%; text-align: center; margin: 0px; padding: 0px; color: #6b0aac;margin-top:5px"><strong>PayG Feed (PaygXsilica)</strong></h6>
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
                        <tr>
                            <td colspan="11">No Data Found</td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="row" style="font-size: 0.5rem;">
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #2f84bc;">
                <div class="row ml-1">
                    No Data Found
                </div>
            </div>
            <div class="col-md-6 m-0 p-0" style="border: 8px solid #6b0aac;">
                <div class="row ml-1">
                    No Data Found
                </div>
            </div>
        </div>
    </div>
</body>

</html>
@endsection