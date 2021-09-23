<?php


namespace App\Repositories;


use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Support\Traits\HasModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class UserRepository implements UserRepositoryInterface
{
    use HasModel;

    private $modelClass = User::class;

    /**
     * Valida e salva o registro no banco
     *
     * @param array $data
     * @param User|null $user
     * @return array
     */
    public function store(array $data, User $user = null): array
    {
        $validator = $this->validate($data, $user);

        if ($validator->fails()) {
            return [
                'success' => false,
                'errors' => $validator->errors()
            ];
        }

        $attributes = [
            'name'            => $data['name'],
            'email'           => $data['email'],
            'birth_date'      => $data['birth_date'],
            'phone'           => $data['phone'],
            'type_of_user_id' => $data['type_of_user_id'],
            'ra'              => $data['ra'] ?? null,
            'cpf'             => $data['cpf'] ?? null,
        ];

        if (is_null($user)) {
            $user = new User();

            $document = $data['cpf'] ?? $data['ra'];
            $password = $this->newPassword($document, $data['birth_date']);

            $attributes['password'] = Hash::make($password);
        }

        $user->fill($attributes)->save();

        return [
            'success' => true,
            'user' => $user,
        ];
    }

    /**
     * Aplica validações nos valores recebidos
     *
     * @param array $input
     * @param User|null $user
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validate(array $input, User $user = null)
    {
        return Validator::make(
            $input,
            [
                'name'            => ['required', 'max:255'],
                'email'           => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users', 'email')->ignoreModel($user)
                ],
                'birth_date'      => ['required'],
                'phone'           => ['required'],
                'type_of_user_id' => ['required', Rule::in([1, 2, 3, 4])],
                'ra'              => [
                    Rule::requiredIf($input['type_of_user_id'] == 1)
                ],
                'cpf'             => [
                    Rule::requiredIf($input['type_of_user_id'] != 1)
                ],
            ],
            [
                'name.required'            => 'Nomé é obrigatório',
                'name.max'                 => 'Tamanho máximo de 255 caracteres',
                'email.required'           => 'E-mail é obrigatório',
                'email.max'                => 'Tamanho máximo de 255 caracteres',
                'email.unique'             => 'Este email já está cadastrado',
                'birth_date.required'      => 'Data de nascimento é obrigatório',
                'phone.required'           => 'Telefone é obrigatório',
                'type_of_user_id.required' => 'Tipo de usuário é obrigatório',
                'ra.required_if'           => 'RA é obrigatório',
                'cpf.required_if'          => 'CPF é obrigatório',
            ]
        );
    }

    /**
     * Gerar senha para usuário
     *
     * @param string $document
     * @param string $birth_date
     * @return string
     */
    public function newPassword(string $document, string $birth_date): string
    {
        return Str::substr($document, 0, 4) . Str::substr($birth_date, 0, 4);
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
