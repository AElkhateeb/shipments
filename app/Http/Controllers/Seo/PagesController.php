<?php

namespace App\Http\Controllers\Seo;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seo\Page\BulkDestroyPage;
use App\Http\Requests\Seo\Page\DestroyPage;
use App\Http\Requests\Seo\Page\IndexPage;
use App\Http\Requests\Seo\Page\StorePage;
use App\Http\Requests\Seo\Page\UpdatePage;
use App\Models\Page;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PagesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPage $request
     * @return array|Factory|View
     */
    public function index(IndexPage $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Page::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'title', 'description', 'h1', 'body', 'is_published'],

            // set columns to searchIn
            ['id', 'title', 'description', 'h1', 'body']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('seo.page.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('seo.page.create');

        return view('seo.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePage $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePage $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Page
        $page = Page::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('seo/pages'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('seo/pages');
    }

    /**
     * Display the specified resource.
     *
     * @param Page $page
     * @throws AuthorizationException
     * @return void
     */
    public function show(Page $page)
    {
        $this->authorize('seo.page.show', $page);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Page $page
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Page $page)
    {
        $this->authorize('seo.page.edit', $page);


        return view('seo.page.edit', [
            'page' => $page,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePage $request
     * @param Page $page
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePage $request, Page $page)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Page
        $page->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('seo/pages'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('seo/pages');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPage $request
     * @param Page $page
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyPage $request, Page $page)
    {
        $page->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPage $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyPage $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Page::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
