<?php

namespace App\Http\Controllers;

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
        return view('messages.index');
    }

    public function new()
    {

    }

    public function send(Request $request)
    {
        $response = $this->repository->sendByRequest($request);
        return response()->json($response);
    }
}
