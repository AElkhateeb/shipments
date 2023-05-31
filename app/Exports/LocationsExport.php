<?php

namespace App\Exports;

use App\Models\Location;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LocationsExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection()
    {
        return Location::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            trans('admin.location.columns.id'),
            trans('admin.location.columns.state'),
            trans('admin.location.columns.city'),
            trans('admin.location.columns.street'),
            trans('admin.location.columns.location'),
            trans('admin.location.columns.lng'),
            trans('admin.location.columns.lat'),
            trans('admin.location.columns.for_type'),
            trans('admin.location.columns.for_id'),
        ];
    }

    /**
     * @param Location $location
     * @return array
     *
     */
    public function map($location): array
    {
        return [
            $location->id,
            $location->state,
            $location->city,
            $location->street,
            $location->location,
            $location->lng,
            $location->lat,
            $location->for_type,
            $location->for_id,
        ];
    }
}
