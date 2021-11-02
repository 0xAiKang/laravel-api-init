<?php

namespace App\Services\Api;

use App\Models\UserModel;

/**
 * Class UserService
 *
 * @package App\Services\Api
 */
class UserService
{
    /**
     * @var UserModel
     */
    protected $userModel;

    /**
     * UserService constructor.
     *
     * @param UserModel $userModel
     */
    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return $this->userModel
            ->select(["id", "email", "name"])
            ->paginate();
    }

    /**
     * @param array $param
     */
    public function create(array $param)
    {
        $this->userModel->create($param);
    }

    /**
     * @param       $id
     * @param array $param
     */
    public function update($id, array $param)
    {
        $user = $this->userModel->find($id);
        $user->update($param);
    }

}