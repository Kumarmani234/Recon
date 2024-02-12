<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayGCosmosFeed extends Model
{
    use HasFactory;
    protected $table = "payg_cosmos_feed";
    protected $primaryKey = "ProcessorRequestId";
    public $incrementing = false;
    protected $fillable = [
        'ProcessorRequestId',
        'Transactionid',
        'MerchantKeyId',
        'PaymentType',
        'TransactionDateTime',
        'AuthorizedAmount',
        'ResponseCode',
        'ResponseText',
        'TransactionReferenceNo',
        'NPCITxnId',
        'ProcessedDateTime',
        'ProcessorId',
        // Add other fields as needed
    ];
    public function highlightRowForProcessorRequestId($processorId)
    {
        $feed = CosmosFeed::where('Ext Id', $processorId)->first();
        $data = PayGCosmosFeed::where('ProcessorRequestId', $processorId)
            ->first();

        if ($feed && $data && $feed->{'Ext Id'} === $data->ProcessorRequestId) {
            return 'highlight-green';
        } else {
            return 'default-color';
        }
    }
}
