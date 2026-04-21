@extends('layouts.pharmacie')

@section('title', 'Messagerie - Medilink')

@section('content')
    <header style="margin-bottom:25px;">
        <h1 style="margin:0;">Messagerie</h1>
        <p style="color:#666;">Vos conversations avec les patients et médecins</p>
    </header>

    <div style="background:white; border-radius:12px; border:1px solid #eee; overflow:hidden;">
        @forelse($chats as $chat)
            <a href="{{ route('pharmacie.messages.show', $chat->id) }}"
                style="display:block; padding:20px; border-bottom:1px solid #eee; text-decoration:none; color:inherit; transition:0.2s;"
                onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='white'">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <div style="display:flex; align-items:center; gap:15px;">
                        <div
                            style="width:50px; height:50px; background:#e0f2f1; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#00A651; font-weight:bold; font-size:18px;">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <div style="font-weight:700; font-size:16px;">
                                @if($chat->type === 'pharmacie-patient')
                                    {{ $chat->patient->prenom ?? 'Patient' }} {{ $chat->patient->nom ?? 'Inconnu' }}
                                @elseif($chat->type === 'pharmacie-medecin')
                                    Dr. {{ $chat->medecin->nom ?? 'Inconnu' }}
                                @else
                                    Utilisateur
                                @endif
                            </div>
                            <div style="color:#666; font-size:14px; margin-top:4px;">
                                {{ Str::limit($chat->messages->first()->contenu ?? 'Nouvelle conversation', 50) }}
                            </div>
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <div style="font-size:12px; color:#999;">
                            {{ $chat->updated_at->diffForHumans() }}
                        </div>
                        @if($chat->messages->where('lu', false)->where('expediteur_type', '!=', 'App\Models\Pharmacie')->count() > 0)
                            <span
                                style="display:inline-block; background:#d32f2f; color:white; font-size:11px; padding:2px 8px; border-radius:10px; margin-top:5px;">
                                {{ $chat->messages->where('lu', false)->where('expediteur_type', '!=', 'App\Models\Pharmacie')->count() }}
                                new
                            </span>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div style="padding:40px; text-align:center; color:#999;">
                <i class="far fa-comments" style="font-size:3em; margin-bottom:15px;"></i>
                <p>Aucune conversation pour le moment.</p>
            </div>
        @endforelse
    </div>
@endsection