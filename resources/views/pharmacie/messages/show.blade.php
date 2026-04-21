@extends('layouts.pharmacie')

@section('title', 'Conversation - Medilink')

@section('content')
    <div style="display:flex; flex-direction:column; height:calc(100vh - 140px);">
        <header style="margin-bottom:20px; display:flex; align-items:center; gap:15px;">
            <a href="{{ route('pharmacie.messages') }}" style="color:#666; text-decoration:none;"><i
                    class="fas fa-arrow-left"></i> Retour</a>
            <h2 style="margin:0;">
                @if($chat->type === 'pharmacie-patient')
                    {{ $chat->patient->prenom ?? 'Patient' }} {{ $chat->patient->nom ?? 'Inconnu' }}
                @elseif($chat->type === 'pharmacie-medecin')
                    Dr. {{ $chat->medecin->nom ?? 'Inconnu' }}
                @else
                    Conversation
                @endif
            </h2>
        </header>

        <div
            style="flex-grow:1; background:white; border-radius:12px; border:1px solid #eee; display:flex; flex-direction:column; overflow:hidden;">
            <!-- Messages Area -->
            <div id="messages-container"
                style="flex-grow:1; overflow-y:auto; padding:20px; display:flex; flex-direction:column-reverse; gap:15px;">
                @foreach($chat->messages as $message)
                        <div
                            style="display:flex; flex-direction:column; max-width:70%; {{ $message->expediteur_id == Auth::guard('pharmacie')->id() && $message->expediteur_type == 'App\Models\Pharmacie' ? 'align-self:flex-end; align-items:flex-end;' : 'align-self:flex-start; align-items:flex-start;' }}">
                            <div style="padding:12px 16px; border-radius:12px; font-size:14px; line-height:1.5; 
                                        {{ $message->expediteur_id == Auth::guard('pharmacie')->id() && $message->expediteur_type == 'App\Models\Pharmacie'
                    ? 'background:#00A651; color:white; border-bottom-right-radius:2px;'
                    : 'background:#f1f3f4; color:#333; border-bottom-left-radius:2px;' }}">
                                {{ $message->contenu }}
                            </div>
                            <small style="color:#999; font-size:11px; margin-top:4px;">
                                {{ $message->date_envoi->format('H:i') }}
                            </small>
                        </div>
                @endforeach
            </div>

            <!-- Input Area -->
            <div style="padding:20px; border-top:1px solid #eee; background:#fafafa;">
                <form action="{{ route('pharmacie.messages.store', $chat->id) }}" method="POST"
                    style="display:flex; gap:10px;">
                    @csrf
                    <input type="text" name="contenu" placeholder="Écrivez votre message..." required
                        style="flex-grow:1; padding:12px 15px; border-radius:24px; border:1px solid #ddd; outline:none; transition:0.2s;"
                        onfocus="this.style.borderColor='#00A651'">
                    <button type="submit"
                        style="width:45px; height:45px; border-radius:50%; background:#00A651; color:white; border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:0.2s;">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection