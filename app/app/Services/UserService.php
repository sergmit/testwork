<?php


namespace App\Services;


use App\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;

class UserService
{
    public const COUNT_USERS_PAGE = 10;

    /**
     * Get Users
     *
     * @return mixed
     */
    public function getUsers()
    {
        return new UserCollection(User::paginate(self::COUNT_USERS_PAGE));
    }

    /**
     * Create User
     *
     * @param $data
     * @return User
     */
    public function createUser($data): User
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make('password');
        $user->save();

        return $user;
    }

    /**
     * Update user
     *
     * @param User $user
     * @param $data
     * @return User
     */
    public function updateUser(User $user, $data): User
    {
        $user->name = $data['name'];
        $user->email = $data['email'];
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return $user;
    }

    /**
     * User delete
     *
     * @param User $user
     * @throws Exception
     */
    public function destroyUser(User $user): void
    {
        $user->delete();
    }
}
