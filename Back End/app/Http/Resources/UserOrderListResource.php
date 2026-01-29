<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserOrderListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {


        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'invoice_id' => $this->invoice_id,
            'sell_type' => $this->sell_type,
            'sell_by' => $this->sell_by,
            'bank_id' => $this->bank_id,
            'total_discount' => $this->total_discount,
            'total_payable_amount' => $this->total_payable_amount,
            'total_paid' => $this->total_paid,
            'total_due' => $this->total_due,
            'payment_type' => $this->payment_type,
            'order_status' => $this->order_status,
            'date' => $this->date,
            'date_format' => date('d-M-y', strtotime($this->date)),
            'processing_at' => $this->processing_at,
            'processing_at_format' => $this->processing_at ? date('d-M-y h:i A', strtotime($this->processing_at)) : null,

            'on_the_way_at' => $this->on_the_way_at,
            'on_the_way_at_format' => $this->on_the_way_at ? date('d-M-y h:i A', strtotime($this->on_the_way_at)) : null,

            'out_for_delivery_at' => $this->out_for_delivery_at,
            'out_for_delivery_at_format' => $this->out_for_delivery_at ? date('d-M-y h:i A', strtotime($this->out_for_delivery_at)) : null,

            'delivered_at' => $this->delivered_at,
            'delivered_at_format' => $this->delivered_at ? date('d-M-y h:i A', strtotime($this->delivered_at)) : null,

            'cancel_requested_at' => $this->cancel_requested_at,
            'cancel_requested_at_format' => $this->cancel_requested_at ? date('d-M-y h:i A', strtotime($this->cancel_requested_at)) : null,

            'cancel_accepted_at' => $this->cancel_accepted_at,
            'cancel_accepted_at_format' => $this->cancel_accepted_at ? date('d-M-y h:i A', strtotime($this->cancel_accepted_at)) : null,

            'cancel_completed_at' => $this->cancel_completed_at,
            'cancel_completed_at_format' => $this->cancel_completed_at ? date('d-M-y h:i A', strtotime($this->cancel_completed_at)) : null,

            'return_requested_at' => $this->return_requested_at,
            'return_requested_at_format' => $this->return_requested_at ? date('d-M-y h:i A', strtotime($this->return_requested_at)) : null,

            'return_accepted_at' => $this->return_accepted_at,
            'return_accepted_at_format' => $this->return_accepted_at ? date('d-M-y h:i A', strtotime($this->return_accepted_at)) : null,

            'return_rejected_at' => $this->return_rejected_at,
            'return_rejected_at_format' => $this->return_rejected_at ? date('d-M-y h:i A', strtotime($this->return_rejected_at)) : null,

            'refund_completed_at' => $this->refund_completed_at,
            'refund_completed_at_format' => $this->refund_completed_at ? date('d-M-y h:i A', strtotime($this->refund_completed_at)) : null,


            // ⭐ ADD ITEMS HERE
            'items' => $this->items->map(function ($item) {
                return [
                    'sell_details_id' => $item->id,
                    'product_id'      => $item->product_id,
                    'qty'             => $item->sale_quantity,
                    'price'           => $item->unit_sell_price,
                    'total'           => $item->total_payable_amount,

                    'product' => $item->product ? [
                        'id'    => $item->product->id,
                        'name'  => $item->product->name,
                        'image' => $item->product->thumbnail,
                    ] : null
                ];
            }),

            'created_at' => $this->created_at,
        ];
    }
}
