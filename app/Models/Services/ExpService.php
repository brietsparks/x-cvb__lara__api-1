<?php

namespace App\Models\Services;

use App\Models\Exp;
use Illuminate\Database\Eloquent\Collection;

class ExpService
{

    /**
     * @var UserService
     */
    protected $userService;

    /**
     * ExpService constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param array $expData
     * @param int $user_id
     * @return Exp
     */
    public function saveExp(array $expData, $user_id)
    {
        if(array_key_exists('id', $expData) && $expData['id']) {
            if ($exp = $this->getExpById($expData['id'])) {
                $exp->fill($expData)->save();

                return $this->getExpById($expData['id']);
            }
        } else {
            return $this->createExp($expData, $user_id);
        }
    }

    /**
     * @param array $expData
     * @param int $user_id
     * @return Exp
     */
    public function createExp(array $expData, $user_id)
    {
        $expData['user_id'] = $user_id;
        $exp = Exp::create($expData);

        return $exp;
    }

    /**
     * @param $user_id
     * @param bool $tree
     * @return Collection
     */
    public function getExpsByUserId($user_id, $tree = false)
    {
        $query = Exp::where('user_id', $user_id);

        if ($tree) {
            $query->whereNull('parent_id')->with(['children','skills']);
        }

        return $query->get();
    }

    /**
     * @param int $id
     * @return Exp
     */
    public function getExpById($id)
    {
        return Exp::find($id);
    }

    /**
     * @param int $id
     * @return boolean
     */
    public function deleteExpById($id)
    {
        $exp = Exp::find($id);
        return $exp->delete();
    }

    /**
     * @param Exp $exp
     * @param string $relationship  Name of the relationship defined in the Exp model
     * @param array $data           Data array containing the items to be synced with the exp
     * @param string $key           Key of the syncing model in the data array
     */
    public function syncExp(Exp $exp, $relationship, array $data, $key = 'id')
    {
        $keys = [];

        foreach ($data as $item) {
            $keys[] = $item[$key];
        }

        $exp->$relationship()->sync($keys);

    }

}