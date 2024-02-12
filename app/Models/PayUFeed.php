<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayUFeed extends Model
{
    use HasFactory;
    protected $table = 'payu_feed';
    protected $primaryKey = "txnid";
    public $incrementing = false;
    protected $fillable = [
        'status', 'txnid', 'addedon', 'id', 'amount', 'productinfo', 'firstname', 'lastname',
        'email', 'phone', 'ip', 'city', 'merchant_name', 'merchant_id', 'bank_name', 'bank_ref_no',
        'card_type', 'mode', 'error_code', 'error_message', 'pgmid', 'pg_response', 'issuing_bank',
        'payment_source', 'name_on_card', 'card_number', 'address_line1', 'address_line2', 'state',
        'country', 'zipcode', 'shipping_firstname', 'shipping_lastname', 'shipping_address1',
        'shipping_address2', 'shipping_city', 'shipping_state', 'shipping_country', 'shipping_zipcode',
        'shipping_phone', 'transaction_fee', 'discount', 'additional_charges', 'amount_inr', 'udf1',
        'udf2', 'udf3', 'udf4', 'udf5', 'field0', 'field1', 'field2', 'field3', 'field4', 'field5',
        'field6', 'field7', 'field8', 'device_info', 'merchant_subvention_amount', 'utr',
        'settlement_amount', 'settlement_date', 'service_fees', 'tsp_charges', 'convenience_fee',
        'cgst', 'sgst', 'igst', 'token_bin', 'last_four_digits', 'arn', 'auth_code'
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
