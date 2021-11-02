<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Services\Admin\MenuService;

/**
 * Class MenuController
 *
 * @package App\Http\Controllers\Admin
 */
class MenuController extends Controller
{
    /**
     * @var \App\Services\Admin\MenuService
     */
    protected MenuService $service;

    /**
     * MenuController constructor.
     *
     * @param \App\Services\Admin\MenuService $service
     */
    public function __construct(MenuService $service)
    {
        $this->service = $service;
    }

    /**
     * @param \App\Http\Requests\Admin\MenuRequest $request
     *
     * @return mixed
     */
    public function index(MenuRequest $request)
    {
        $result = $this->service->index();
        return $this->success($result);
    }

    /**
     * @param \App\Http\Requests\Admin\MenuRequest $request
     *
     * @return mixed
     */
    public function list(MenuRequest $request)
    {
        $result = $this->service->list();
        return $this->success($result);
    }

    /**
     * @param \App\Http\Requests\Admin\MenuRequest $request
     *
     * @return mixed
     */
    public function create(MenuRequest $request)
    {
        try {
            $this->service->create($request->all());
        } catch (\Exception $exception) {
            return $this->failed($exception->getMessage());
        }
        return $this->success();
    }

    /**
     * @param \App\Http\Requests\Admin\MenuRequest $request
     *
     * @return mixed
     */
    public function update(MenuRequest $request)
    {
        $result = $this->service->update($request->all());
        return $this->success($result);
    }

    /**
     * @param \App\Http\Requests\Admin\MenuRequest $request
     *
     * @return mixed
     */
    public function edit(MenuRequest $request)
    {
        $result = $this->service->edit($request->all());
        return $this->success($result);
    }

    /**
     * @param \App\Http\Requests\Admin\MenuRequest $request
     *
     * @return mixed
     * @throws \App\Exceptions\InternalException
     */
    public function delete(MenuRequest $request)
    {
        $result = $this->service->delete($request->input('id'));
        return $this->success();
    }
}
