<?php

namespace App\Http\Controllers\Admin;

use App\Exports\WithdrawalsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Withdrawal\BulkDestroyWithdrawal;
use App\Http\Requests\Admin\Withdrawal\DestroyWithdrawal;
use App\Http\Requests\Admin\Withdrawal\IndexWithdrawal;
use App\Http\Requests\Admin\Withdrawal\StoreWithdrawal;
use App\Http\Requests\Admin\Withdrawal\UpdateWithdrawal;
use App\Models\PaymentMethod;
use App\Models\Wallet;
use App\Models\Withdrawal;
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

class WithdrawalsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexWithdrawal $request
     * @return array|Factory|View
     */
    public function index(IndexWithdrawal $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Withdrawal::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'price', 'reason_type', 'reason_id', 'made_type', 'made_id', 'in_out', 'enabled', 'from_id', 'to_id', 'payment_method_id'],

            // set columns to searchIn
            ['id', 'reason_type', 'made_type'],
            function ($query) use ($request) {
                $query->with(['from']);
                if($request->has('from')){
                    $query->whereIn('from_id', $request->get('from'));
                }
                $query->with(['to']);
                if($request->has('to')){
                    $query->whereIn('to_id', $request->get('to'));
                }
                $query->with(['paymentMethod']);
                if($request->has('paymentMethod')){
                    $query->whereIn('payment_method_id', $request->get('paymentMethod'));
                }
            }
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.withdrawal.index', [
            'data' => $data,
            'wallets' => Wallet::all(),
            'paymentMethods' => PaymentMethod::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.withdrawal.create');

        return view('admin.withdrawal.create',[
            'wallets' => Wallet::all(),
            'paymentMethods' => PaymentMethod::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWithdrawal $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreWithdrawal $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['from_id'] = $request->getFromId();
        $sanitized['to_id'] = $request->getToId();
        $sanitized['payment_method_id'] = $request->getPaymentMethodId();
        // Store the Withdrawal
        $withdrawal = Withdrawal::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/withdrawals'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/withdrawals');
    }

    /**
     * Display the specified resource.
     *
     * @param Withdrawal $withdrawal
     * @throws AuthorizationException
     * @return void
     */
    public function show(Withdrawal $withdrawal)
    {
        $this->authorize('admin.withdrawal.show', $withdrawal);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Withdrawal $withdrawal
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Withdrawal $withdrawal)
    {
        $this->authorize('admin.withdrawal.edit', $withdrawal);


        return view('admin.withdrawal.edit', [
            'withdrawal' => $withdrawal,
                'wallets' => Wallet::all(),
            'paymentMethods' => PaymentMethod::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateWithdrawal $request
     * @param Withdrawal $withdrawal
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateWithdrawal $request, Withdrawal $withdrawal)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();
        $sanitized['from_id'] = $request->getFromId();
        $sanitized['to_id'] = $request->getToId();
        $sanitized['payment_method_id'] = $request->getPaymentMethodId();
        // Update changed values Withdrawal
        $withdrawal->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/withdrawals'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/withdrawals');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyWithdrawal $request
     * @param Withdrawal $withdrawal
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyWithdrawal $request, Withdrawal $withdrawal)
    {
        $withdrawal->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyWithdrawal $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyWithdrawal $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Withdrawal::whereIn('id', $bulkChunk)->delete();

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
        return Excel::download(app(WithdrawalsExport::class), 'withdrawals.xlsx');
    }
}
