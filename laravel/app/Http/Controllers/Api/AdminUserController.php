<?php

namespace App\Http\Controllers\Api;

use App\AdminUser;
use App\Http\Requests\AdminUserRequest;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminUserController extends ApiController
{
    /**
     * 管理者一覧
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = AdminUser::all();

        return $this->respond([
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminUserRequest $request)
    {
        try {
            $validated = $request->validated();
            $AdminUser = new AdminUser($validated);
            $AdminUser->save();
        } catch (QueryException $e) {
            return $this->respondInvalidQuery($e);
        }

        return $this->respondWithOK(['true']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * 管理者編集
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        \Log::debug($request->all());

        try {
            $validated = $request->all();
            $adminUser = AdminUser::findOrFail($id);
            $adminUser->fill($validated);
            $adminUser->save();
        } catch (QueryException $e) {
            return $this->respondInvalidQuery();
        }

        return $this->respond(['true']);
    }

    /**
     * 管理者削除
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $adminUser = AdminUser::findOrFail($id);
            $adminUser->delete();

            return $this->respondObjectDeleted($id);
        } catch (\Throwable $e) {
            return $this->respondNotFound();
        }
    }
}
