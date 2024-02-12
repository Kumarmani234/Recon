<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayGInduslndFeed extends Model
{
    use HasFactory;
    protected $table = 'payg_induslnd_feed'; // Assuming your table name is 'transactions'

    protected $primaryKey = 'Processor RequestId'; // Assuming 'TransactionReferenceNumber' is the primary key
    public $incrementing = false;

    protected $fillable = [
        'TransactionReference Number',
        'Processor RequestId',
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
        'Diff',
        'Fee Amount',
        'Gst Amount',
        'Total Fee Amount',
        'Settlement Verified'
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
