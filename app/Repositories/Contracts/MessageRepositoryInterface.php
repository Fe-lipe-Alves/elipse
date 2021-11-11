<?php

namespace App\Repositories\Contracts;

use App\Models\Message;
use Illuminate\Http\Request;

interface MessageRepositoryInterface
{
    /**
     * Salva uma nova mensagem com base na requisição
     *
     * @param Request $request
     * @return array|bool[]|false[]
     */
    public function sendByRequest(Request $request): array;

    /**
     * Salva uma mensagem de texto
     *
     * @param string $content
     * @param int $receiver_id
     * @param int $sender_id
     * @return Message
     */
    public function sendText(string $content, int $receiver_id, int $sender_id);

    /**
     * Salva uma mensagem de arquivos
     *
     * @param $files
     * @param int $receiver_id
     * @param int $sender_id
     * @return array
     */
    public function sendFile($files, int $receiver_id, int $sender_id): array;

    /**
     * Aplica regras de validação nos dados da mensagem
     *
     * @param array $data
     * @return array
     */
    public function validate(array $data): array;

    /**
     * Obtém lista de conversas recentes
     *
     * @param int $user_id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function recent(int $user_id);

    /**
     * Obtém o histórico de mensagens dos usuários
     *
     * @param int $receiver_id
     * @param int $sender_id
     * @param int $offset
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function history(int $receiver_id, int $sender_id, int $offset);

    /**
     * Dispara o evento de notificar mensagens
     *
     * @param $message
     */
    public function dispatchEvent($message);
}
