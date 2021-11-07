<?php

namespace App\Repositories;

use App\Models\Message;
use App\Repositories\Contracts\FileRepositoryInterface;
use App\Repositories\Contracts\MessageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\FileBag;

class MessageRepository implements MessageRepositoryInterface
{

    public function sendByRequest(Request $request)
    {
        try {
            $validator = $this->validate($request->all());
            if (!$validator['success']) {
                return $validator;
            }

            $text = $request->text;
            $files = $request->files;
            if (!empty($text)) {
                $this->sendText($request->text, $request->receiver_id, Auth::id());
            } else if (!empty($files)) {
                $this->sendFile($request->files, $request->receiver_id, Auth::id());
            } else {
                return ['success' => false];
            }

            return [
                'success' => true
            ];
        } catch (\Exception $exception) {
            dd($exception);
            return [
                'success' => false
            ];
        }
    }

    public function sendText(string $content, int $receiver_id, int $sender_id)
    {
        $message = new Message([
            'receiver_id' => $receiver_id,
            'sender_id' => $sender_id,
            'content' => $content,
            'file' => false
        ]);

        $message->save();
    }

    public function sendFile($files, int $receiver_id, int $sender_id)
    {
        if ($files instanceof FileBag) {
            $files = $files->all();
        }

        foreach ($files as $file) {
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
        }
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
}
