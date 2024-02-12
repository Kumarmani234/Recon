<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KotakFeed extends Model
{
    use HasFactory;
    protected $table = 'kotak_feed'; // Assuming your table name is 'transactions'

    protected $primaryKey = 'NVL_TSDK ORDERID'; // Assuming 'NVL_TSDK_ORDERID' is the primary key
    public $incrementing = false;

    protected $fillable = [
        'NVL_TSDK ORDERID',
        'REFID',
        'AGGREGATORCODE',
        'MERCHANTID',
        'TRANSACTION_DATE',
        'PAYEE_VPA',
        'Payee_ACCOUNT_NUMBER',
        'Payee_IFSC_Code',
        'PAYER_ACCOUNT_NUMBER',
        'PAYER_IFSC',
        'PAYER_VPA',
        'PAYER_NAME',
        'AMOUNT',
        'RESPONSE_CODE',
        'TRANSACTION_ID',
        'DEBIT_NBIN',
        'TRANSACTION_STATUS',
        'MCC_CODE',
        'MDR_CHARGED',
        'GST',
        'NET_AMOUNT',
        'NVL_TSDK_REMARKS_CBS_REMARKS_',
    ];

    public function highlightRowForProcessorRequestId($processorId)
    {
        $feed = KotakFeed::where('NVL_TSDK ORDERID', $processorId)->first();
        $data = PayGKotakFeed::where('Processor RequestId', $processorId)
            ->first();

        if ($feed && $data && $feed->{'NVL_TSDK ORDERID'} === $data->{'Processor RequestId'}) {
            return 'highlight-green';
        } else {
            return 'default-color';
        }
    }
}
