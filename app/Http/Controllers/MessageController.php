<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\Contracts\MessageRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    protected $repository;

    public function __construct(MessageRepositoryInterface $messageRepository)
    {
        $this->repository = $messageRepository;
    }

    public function index()
    {
        $recents = $this->repository->recent(Auth::id());
        $users = User::query()
            ->with('typeOfUser')
            ->where('id', '!=', Auth::id())
            ->orderBy('name')
            ->get();
        return view('messages.index', compact('recents', 'users'));
    }

    public function new()
    {

    }

    public function send(Request $request)
    {
        $response = $this->repository->sendByRequest($request);
        return response()->json($response);
    }

    public function history($receiver_id, $offset = 0)
    {
        if (!$receiver_id) {
            return ['success' => false, 'message' => 'Problemas ao encontrar usuário'];
        }

        $response = $this->repository->history($receiver_id, Auth::id(), $offset);

        return response()->json($response);
    }
}
