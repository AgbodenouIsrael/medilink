<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedecinChatController extends Controller
{
    public function index()
    {
        $user = Auth::guard('medecin')->user();

        $chats = Chat::where('medecin_id', $user->id)
            ->with([
                'patient',
                'messages' => function ($q) {
                    $q->latest()->limit(1);
                }
            ])
            ->latest()
            ->get();

        return view('medecin.messages.show', compact('chats', 'user'));
    }

    public function show($id)
    {
        $user = Auth::guard('medecin')->user();
        $chat = Chat::with(['messages', 'patient'])->findOrFail($id);

        if ($chat->medecin_id !== $user->id) {
            abort(403);
        }

        $chats = Chat::where('medecin_id', $user->id)->latest()->get();

        return view('medecin.messages.show', compact('chat', 'chats', 'user'));
    }

    public function store(Request $request, $id)
    {
        $request->validate(['contenu' => 'required|string']);
        $user = Auth::guard('medecin')->user();
        $chat = Chat::findOrFail($id);

        if ($chat->medecin_id !== $user->id) {
            abort(403);
        }

        Message::create([
            'chat_id' => $chat->id,
            'expediteur_type' => get_class($user),
            'expediteur_id' => $user->id,
            'contenu' => $request->contenu,
            'lu' => false,
        ]);

        return redirect()->back();
    }
}
