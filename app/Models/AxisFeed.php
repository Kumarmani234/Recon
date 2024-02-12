<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AxisFeed extends Model
{
    use HasFactory;
    protected $table="axis_feed";
    protected $primaryKey = "Txn Id";
    public $incrementing = false;
    protected $fillable = [
        'Order Id',
        'Txn Id',
        'RRN',
        'Amount',
        'Txn Type',
        'Txn Date',
        'Merchant Id',
        'Channel Id',
        'Response Code',
        'Aggregator Code',
        'Remarks',
        'Response',
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
