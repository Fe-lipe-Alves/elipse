<?php


namespace App\Repositories;


use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Support\Traits\HasModel;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class UserRepository implements UserRepositoryInterface
{
    use HasModel;
    use PasswordValidationRules;

    private $modelClass = User::class;

    /**
     * Validar e cadastrar novo usuário
     *
     * @param array $input
     * @return null
     */
    public function create(array $input)
    {
        $password = $this->newPassword(Arr::only($input, ['birth_date', 'cpf', 'ra']));
        $input = Arr::add($input, 'password', $password);
        $input = Arr::add($input, 'password_confirmation', $password);
        $input = Arr::add($input, 'type_of_user_id', $this->typeOfUser($input['userType']));

        $validator = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'birth_date' => ['required'],
            'phone' => ['required'],
            'ra' => [
                Rule::requiredIf($input['userType'] == 'user_type_student')
            ],
            'cpf' => [
                Rule::requiredIf($input['userType'] != 'user_type_student')
            ],
        ]);


        if ($validator->fails()) {
            return null;
        }

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'birth_date' => $input['birth_date'],
            'phone' => $input['phone'],
            'type_of_user_id' => $input['type_of_user_id'],
            'ra' => $input['ra'] ?? null,
            'cpf' => $input['cpf'] ?? null,
        ]);

        return $user;
    }

    /**
     * Validar e salvar usuário
     *
     * @param User $user
     * @param array $input
     * @return User|\Illuminate\Support\MessageBag
     */
    public function update(User $user, array $input)
    {
        $input = Arr::add($input, 'type_of_user_id', $this->typeOfUser($input['userType']));

        $validator = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'birth_date' => ['required'],
            'phone' => ['required'],
            'ra' => [
                Rule::requiredIf($input['userType'] == 'user_type_student')
            ],
            'cpf' => [
                Rule::requiredIf($input['userType'] != 'user_type_student')
            ],
        ]);


        if ($validator->fails()) {
            return $validator->errors();
        }

        $user->fill([
            'name' => $input['name'],
            'email' => $input['email'],
            'birth_date' => $input['birth_date'],
            'phone' => $input['phone'],
            'type_of_user_id' => $input['type_of_user_id'],
            'ra' => $input['ra'] ?? null,
            'cpf' => $input['cpf'] ?? null,
        ]);
        $user->save();

        return $user;
    }

    /**
     * Gerar senha para usuário
     *
     * @param array $data
     * @return string
     */
    public function newPassword(array $data): string
    {
        $doc = $data['cpf'] ?? $data['ra'];
        return Str::substr($doc, 0, 4) . Str::substr($data['birth_date'], 0, 4);
    }

    /**
     * Identificar tipo de usuário
     *
     * @param $userType
     * @return int|null
     */
    public function typeOfUser($userType): ?int
    {
        switch ($userType) {
            case 'user_type_admin' :
                return 1;
            case 'user_type_student' :
                return 2;
            case 'user_type_teacher' :
                return 3;
            case 'user_type_secretary' :
                return 4;
        }
        return null;
    }

    /**
     * Obter lista de usuários ativo
     *
     * @param null $type_of_users
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getActiveUser($type_of_users = null)
    {
        $users = User::query();

        if ($type_of_users) {
            $users->where('type_of_user_id', $type_of_users);
        }

        return $users->get();
    }
}
