<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayGKotakFeed extends Model
{
    use HasFactory;
    protected $table = 'payg_kotak_feed'; // Assuming your table name is 'transaction_details'
    public $incrementing = false;

    protected $primaryKey = 'Processor RequestId'; // Assuming 'TransactionReferenceNumber' is the primary key

    protected $fillable = [
        'TransactionReference Number',
        'Processor RequestId',
        'Batch Id',
        'Processor Name',
        'Request UniqueId',
        'ReconTransaction Id',
        'Transaction Id',
        'Transaction Datetime',
        'Processed DateTime',
        'Payment Type',
        'Transaction Type',
        'Authorized Amount',
        'Diff',
        'Fee Amount',
        'Gst Amount',
        'Total Fee Amount',
        'Settlement Verified',
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
