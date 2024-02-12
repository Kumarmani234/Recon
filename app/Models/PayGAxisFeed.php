<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayGAxisFeed extends Model
{
    use HasFactory;
    protected $table="payg_axis_feed";
    protected $primaryKey = "Processor RequestId";
    public $incrementing = false;
    protected $fillable = [
        'Batch Id',
        'Processor Name',
        'Request UniqueId',
        'Recon TransactionId',
        'Transaction Id',
        'Transaction Datetime',
        'Processed DateTime',
        'Payment Type',
        'Transaction Type',
        'Authorized Amount',
        'Fee Amount',
        'Gst Amount',
        'Total Fee Amount',
        'Processor RequestId',
        'TransactionReference Number',
        'Settlementverified',
        'Settlement Verified',
    ];

    public function highlightRowForProcessorRequestId($processorId)
    {
        $feed = AxisFeed::where('Response','Success')->where('Txn Id', $processorId)->first();
        $data = PayGAxisFeed::where('Processor RequestId', $processorId)
            ->first();

        if ($feed && $data && $feed->{'Txn Id'} === $data->{'Processor RequestId'}) {
            return 'highlight-green';
        } else {
            return 'default-color';
        }
    }

}
