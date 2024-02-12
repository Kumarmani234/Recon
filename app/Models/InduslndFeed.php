<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InduslndFeed extends Model
{
    use HasFactory;
    protected $table = 'induslnd_feed'; // Assuming your table name is 'transaction_details'

    protected $primaryKey = 'Ref Id';
    public $incrementing = false;

    protected $fillable = [
        'Ref Id',
        'RRN',
        'BUSINESS CATEGORY',
        'MERCHANT TYPE',
        'ORG ID',
        'ORG NAME',
        'OUTLET ID',
        'OUTLET NAME',
        'MERCHANT ID',
        'MERCHANT NAME',
        'TRANSACTION DATE',
        'PAYMENT MODE',
        'MERCHANT TERMINAL ID',
        'MERCHANT OUTLET ID',
        'CUSTOMER PAYMENT ID',
        'TRANSACTION TIME',
        'TRANSACTION ID',
        'TRANSACTION AMOUNT',
        'MDR AMOUNT',
        'GST AMOUNT',
        'CUSTOMER MOBILE NO',
        'FROM ACCOUNT',
        'TO ACCOUNT',
        'TRANSACTION STATUS',
        'TRANSACTION DESCRIPTION',
        'APPLICATION ORIGIN',
        'CHANNEL RESPONSE CODE',
        'CBS RESPONSE CODE',
        'TransactionSettlementDate',
        'TransactionType',
        'PayerAccountType',
        'NPCI RESPONSE CODE',
        'CUSTOMER BANK',
        'REMARKS',
        'MerchantVPA',
        'TxnNote'
    ];

    public function highlightRowForProcessorRequestId($processorId)
    {
        $feed = InduslndFeed::where('Ref Id', $processorId)->first();
        $data = PayGInduslndFeed::where('Processor RequestId', $processorId)
            ->first();

        if ($feed && $data && $feed->{'Ref Id'} === $data->{'Processor RequestId'}) {
            return 'highlight-green';
        } else {
            return 'default-color';
        }
    }
}


