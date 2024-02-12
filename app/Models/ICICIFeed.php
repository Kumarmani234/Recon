<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ICICIFeed extends Model
{
    use HasFactory;
    protected $table="icici_feed";
    protected $primaryKey = "merchantTranID";
    public $incrementing = false;
    protected $fillable = [
        'accountNumber',
        'merchantID',
        'merchantName',
        'subMerchantID',
        'subMerchantName',
        'merchantTranID',
        'bankTranID',
        'date',
        'time',
        'amount',
        'payerVA',
        'status',
        'Commission',
        'Service tax',
        'Net amount',
        'Remark',
        'SeqNo',
        'AccountType',
    ];

    public function highlightRowForProcessorRequestId($processorId)
    {
        $feed = ICICIFeed::where('merchantTranID', $processorId)->first();
        $data = PayGICICIFeed::where('Processor RequestId', $processorId)
            ->first();

        if ($feed && $data && $feed->merchantTranID === $data->{'Processor RequestId'}) {
            return 'highlight-green';
        } else {
            return 'default-color';
        }
    }

}
