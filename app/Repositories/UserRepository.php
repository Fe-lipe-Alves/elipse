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

        $validator = $this->validate($input);


        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        $user = User::query()->create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'birth_date' => $input['birth_date'],
            'phone' => $input['phone'],
            'type_of_user_id' => $input['type_of_user_id'],
            'ra' => $input['ra'] ?? null,
            'cpf' => $input['cpf'] ?? null,
        ]);

        return [
            'success' => true,
            'user' => $user,
        ];
    }

    /**
     * Aplica validações nos valores recebidos
     *
     * @param array $input
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $input)
    {
        return Validator::make(
            $input,
            [
                'name'            => ['required', 'max:255'],
                'email'           => ['required', 'email', 'max:255', 'unique:users'],
                'password'        => ['required'],
                'birth_date'      => ['required'],
                'phone'           => ['required'],
                'type_of_user_id' => ['required', Rule::in([1, 2, 3, 4])],
                'ra'              => [ Rule::requiredIf($input['type_of_user_id'] == 1) ],
                'cpf'             => [ Rule::requiredIf($input['type_of_user_id'] != 1) ],
            ],
            [
                'name.required' => 'Nomé é obrigatório',
                'name.max' => 'Tamanho máximo de 255 caracteres',
                'email.required' => 'E-mail é obrigatório',
                'email.max' => 'Tamanho máximo de 255 caracteres',
                'email.unique' => 'Este email já está cadastrado',
                'password.required' => 'Senha é obrigatório',
                'birth_date.required' => 'Data de nascimento é obrigatório',
                'phone.required' => 'Telefone é obrigatório',
                'type_of_user_id.required' => 'Tipo de usuário é obrigatório',
                'ra.required_if' => 'RA é obrigatório',
                'cpf.required_if' => 'CPF é obrigatório',
            ]
        );
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
