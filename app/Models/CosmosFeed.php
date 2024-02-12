<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CosmosFeed extends Model
{
    use HasFactory;
    protected $table = "cosmos_feed";

    protected $primaryKey = "Ext Id";
    public $incrementing = false;
    protected $fillable = [
        'Date',
        'Amount',
        'RRN',
        'Ext Id',
        'Transaction Status',
        'NPCI Code',
        'Switch Code',
        'Switch Msg',
        'Payee Vpa',
        'Payer Vpa',
        'Txn Id',
        'MCC',
        'Remarks',
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
