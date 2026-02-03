<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientChatController extends Controller
{
    public function index()
    {
        $user = Auth::guard('patient')->user();

        $chats = Chat::where('patient_id', $user->id)
            ->with([
                'medecin',
                'messages' => function ($q) {
                    $q->latest()->limit(1);
                }
            ])
            ->latest()
            ->get();

        return view('patient.messages.index', compact('chats', 'user'));
    }

    public function show($id)
    {
        $user = Auth::guard('patient')->user();
        $chat = Chat::with(['messages', 'medecin'])->findOrFail($id);

        if ($chat->patient_id !== $user->id) {
            abort(403);
        }

        $chats = Chat::where('patient_id', $user->id)->latest()->get();

        return view('patient.messages.index', compact('chat', 'chats', 'user'));
    }

    public function store(Request $request, $id)
    {
        $request->validate(['contenu' => 'required|string']);
        $user = Auth::guard('patient')->user();
        $chat = Chat::findOrFail($id);

        if ($chat->patient_id !== $user->id) {
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
