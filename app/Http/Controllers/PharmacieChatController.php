<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class PharmacieChatController extends Controller
{
    public function index()
    {
        $pharmacie = Auth::guard('pharmacie')->user();

        // Chats where the pharmacy is a participant
        $chats = Chat::where('pharmacie_id', $pharmacie->id)
            ->with([
                'patient',
                'medecin',
                'messages' => function ($q) {
                    $q->latest();
                }
            ])
            ->latest()
            ->get();

        return view('pharmacie.messages.index', compact('chats'));
    }

    public function show($id)
    {
        $pharmacie = Auth::guard('pharmacie')->user();
        $chat = Chat::where('id', $id)->where('pharmacie_id', $pharmacie->id)
            ->with(['messages.expediteur', 'patient', 'medecin'])
            ->firstOrFail();

        return view('pharmacie.messages.show', compact('chat'));
    }

    public function store(Request $request, $id)
    {
        $pharmacie = Auth::guard('pharmacie')->user();
        $chat = Chat::where('id', $id)->where('pharmacie_id', $pharmacie->id)->firstOrFail();

        $request->validate(['contenu' => 'required|string']);

        $chat->messages()->create([
            'chat_id' => $chat->id,
            'expediteur_type' => 'App\Models\Pharmacie', // Polymorphic mapping
            'expediteur_id' => $pharmacie->id,
            'contenu' => $request->contenu,
            'date_envoi' => now(),
            'lu' => false
        ]);

        return back();
    }
}
