<?php

namespace App\Repositories;

use App\Events\Chat\SendMessage;
use App\Models\Message;
use App\Models\User;
use App\Repositories\Contracts\FileRepositoryInterface;
use App\Repositories\Contracts\MessageRepositoryInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\FileBag;

class MessageRepository implements MessageRepositoryInterface
{
    /**
     * Salva uma nova mensagem com base na requisição
     *
     * @param Request $request
     * @return array|bool[]|false[]
     */
    public function sendByRequest(Request $request): array
    {
        try {
            $validator = $this->validate($request->all());
            if (!$validator['success']) {
                return $validator;
            }

            if (!empty($request->text)) {
                $messages = $this->sendText($request->text, $request->receiver_id, Auth::id());
            } else if (!empty($request->files)) {
                $messages = $this->sendFile($request->files, $request->receiver_id, Auth::id());
            } else {
                return ['success' => false];
            }

            if (!is_array($messages)) {
                $messages = [$messages];
            }

            $this->dispatchEvent($messages);

            return [
                'success' => true,
                'messages' => $messages,
            ];
        } catch (\Exception $exception) {
            return [
                'success' => false
            ];
        }
    }

    /**
     * Salva uma mensagem de texto
     *
     * @param string $content
     * @param int $receiver_id
     * @param int $sender_id
     * @return Message
     */
    public function sendText(string $content, int $receiver_id, int $sender_id)
    {
        $message = new Message([
            'receiver_id' => $receiver_id,
            'sender_id' => $sender_id,
            'content' => $content,
            'file' => false
        ]);

        $message->save();

        return $message;
    }

    /**
     * Salva uma mensagem de arquivos
     *
     * @param $files
     * @param int $receiver_id
     * @param int $sender_id
     * @return array
     */
    public function sendFile($files, int $receiver_id, int $sender_id): array
    {
        if ($files instanceof FileBag) {
            $files = $files->all();
        }

        $messages = [];
        foreach ($files['files'] as $file) {
            $message = new Message([
                'receiver_id' => $receiver_id,
                'sender_id' => $sender_id,
                'content' => '',
                'file' => true
            ]);

            $message->save();

            /** @var FileRepositoryInterface $fileRepository */
            $fileRepository = app(FileRepositoryInterface::class);

            $fileRepository->save($message, $file);

            if ($message->file && !empty($message->files)) {
                $message->files->source = url()->to('/') . Storage::url($message->files->source);
            }

            $messages[] = $message;
        }

        return $messages;
    }

    /**
     * Aplica regras de validação nos dados da mensagem
     *
     * @param array $data
     * @return array
     */
    public function validate(array $data): array
    {
        $errors = [];

        if (!isset($data['receiver_id'])) {
            $errors[] = 'Destinatário não encontrado';
        }

        if (!isset($data['text']) && !isset($data['files'])) {
            $errors[] = 'Nenhum conteúdo na mensagem';
        }

        return [
            'success' => empty($errors),
            'errors' => $errors,
        ];
    }

    /**
     * Obtém lista de conversas recentes
     *
     * @param int $user_id
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function recent(int $user_id)
    {
        return User::query()
            ->where('id', '!=', $user_id)
            ->whereIn('id', function(Builder $query) use ($user_id) {
                $query->select('messages.receiver_id')
                    ->from('messages')
                    ->where('messages.sender_id', '=', $user_id)
                    ->groupBy('messages.receiver_id');

            })
            ->orWhereIn('id', function(Builder $query) use ($user_id) {
                $query->select('messages.sender_id')
                    ->from('messages')
                    ->where('messages.receiver_id', '=', $user_id)
                    ->groupBy('messages.sender_id');

            })
            ->get();
    }

    /**
     * Obtém o histórico de mensagens dos usuários
     *
     * @param int $receiver_id
     * @param int $sender_id
     * @param int $offset
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function history(int $receiver_id, int $sender_id, int $offset)
    {
        $messages =  Message::query()
            ->where(function ($query) use ($receiver_id, $sender_id) {
                $query->where('receiver_id', '=', $receiver_id)
                    ->where('sender_id', '=', $sender_id);
            })
            ->orWhere(function ($query) use ($receiver_id, $sender_id) {
                $query->where('receiver_id', '=', $sender_id)
                    ->where('sender_id', '=', $receiver_id);
            })
            ->orderBy('id', 'desc')
            ->limit(3)
            ->offset($offset)
            ->with('files')
            ->get()
            ->map(function ($item) {
                if ($item->file && !empty($item->files)) {
                    $item->files->source = url()->to('/') . Storage::url($item->files->source);
                }

                return $item;
            });

        return [
            'success' => true,
            'messages' => $messages,
        ];
    }

    /**
     * Dispara o evento de notificar mensagens
     *
     * @param $message
     */
    public function dispatchEvent($message)
    {
        if (is_array($message)) {
            foreach ($message as $item) {
                $this->dispatchEvent($item);
            }
        } elseif ($message instanceof Message) {
            Event::dispatch(new SendMessage($message));
        }
    }
}
