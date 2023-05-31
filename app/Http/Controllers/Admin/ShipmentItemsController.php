<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ShipmentItemsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ShipmentItem\BulkDestroyShipmentItem;
use App\Http\Requests\Admin\ShipmentItem\DestroyShipmentItem;
use App\Http\Requests\Admin\ShipmentItem\IndexShipmentItem;
use App\Http\Requests\Admin\ShipmentItem\StoreShipmentItem;
use App\Http\Requests\Admin\ShipmentItem\UpdateShipmentItem;
use App\Models\ShipmentItem;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\View\View;

class ShipmentItemsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexShipmentItem $request
     * @return array|Factory|View
     */
    public function index(IndexShipmentItem $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(ShipmentItem::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'shipment_id', 'name', 'enabled', 'price'],

            // set columns to searchIn
            ['id', 'name', 'description']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.shipment-item.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.shipment-item.create');

        return view('admin.shipment-item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreShipmentItem $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreShipmentItem $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the ShipmentItem
        $shipmentItem = ShipmentItem::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/shipment-items'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/shipment-items');
    }

    /**
     * Display the specified resource.
     *
     * @param ShipmentItem $shipmentItem
     * @throws AuthorizationException
     * @return void
     */
    public function show(ShipmentItem $shipmentItem)
    {
        $this->authorize('admin.shipment-item.show', $shipmentItem);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ShipmentItem $shipmentItem
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(ShipmentItem $shipmentItem)
    {
        $this->authorize('admin.shipment-item.edit', $shipmentItem);


        return view('admin.shipment-item.edit', [
            'shipmentItem' => $shipmentItem,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateShipmentItem $request
     * @param ShipmentItem $shipmentItem
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateShipmentItem $request, ShipmentItem $shipmentItem)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values ShipmentItem
        $shipmentItem->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/shipment-items'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/shipment-items');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyShipmentItem $request
     * @param ShipmentItem $shipmentItem
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyShipmentItem $request, ShipmentItem $shipmentItem)
    {
        $shipmentItem->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyShipmentItem $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyShipmentItem $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    ShipmentItem::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }

    /**
     * Export entities
     *
     * @return BinaryFileResponse|null
     */
    public function export(): ?BinaryFileResponse
    {
        return Excel::download(app(ShipmentItemsExport::class), 'shipmentItems.xlsx');
    }
}
