<?php

namespace App\Exports;

use App\Models\ShipmentItem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ShipmentItemsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return ShipmentItem::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('admin.shipment-item.columns.id'),
            trans('admin.shipment-item.columns.shipment_id'),
            trans('admin.shipment-item.columns.name'),
            trans('admin.shipment-item.columns.description'),
            trans('admin.shipment-item.columns.enabled'),
            trans('admin.shipment-item.columns.price'),
        ];
    }

    /**
     * @param ShipmentItem $shipmentItem
     * @return array
     *
     */
    public function map($shipmentItem): array
    {
        return [
            $shipmentItem->id,
            $shipmentItem->shipment_id,
            $shipmentItem->name,
            $shipmentItem->description,
            $shipmentItem->enabled,
            $shipmentItem->price,
        ];
    }
}
