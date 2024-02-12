<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayGPayUFeed extends Model
{
    use HasFactory;
    protected $table = "payg_payu_feed";
    protected $primaryKey = "ProcessorRequestId";
    public $incrementing = false;
    protected $fillable = [
        'TransactionId',
        'MerchantKeyId',
        'TransactionType',
        'PaymentType',
        'TransactionDatetime',
        'TransactionAmount',
        'ResponseCode',
        'ResponseText',
        'PayUId',
        'ProcessorId',
        'ProcessorRequestId',
        'TransactionReferenceNo',
    ];
    public function highlightRowForProcessorRequestId($processorId)
    {
        $feed = PayUFeed::where('txnid', $processorId)->where('status', 'captured')->first();
        $data = PayGPayUFeed::where('ProcessorRequestId', $processorId)
            ->whereNotNull('TransactionAmount')
            ->first();

        if ($feed && $data && $feed->{'txnid'} === $data->ProcessorRequestId) {
            return 'highlight-green';
        } else {
            return 'default-color';
        }
    }
}
