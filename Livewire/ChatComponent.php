<?php

namespace App\Livewire;
use App\Events\MailSentEvent;
use App\Models\User;
use Livewire\Component;
use App\Models\Mails;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
class ChatComponent extends Component
{
    public $user;
    public $sender_id;
    public $reciever_id;
    public $mail = '';
    public $mails = [];

    public function render()
    {
        return view('livewire.chat-component', [
            'mails' => $this->mails
        ]);
    }

    public function mount($user_id)
    {
        $this->sender_id = Auth::id();
        $this->reciever_id = $user_id;
        $this->user = User::find($user_id);

        $mails = Mails::where(function($query) {
            $query->where('sender_id', $this->sender_id)
                  ->where('reciever_id', $this->reciever_id);
        })->orWhere(function($query) {
            $query->where('sender_id', $this->reciever_id)
                  ->where('reciever_id', $this->sender_id);
        })->with('sender:id,name', 'reciever:id,name')->get();

        foreach($mails as $mail) {
            $this->appendChatMails($mail);
        }
    }

    public function sendMail()
    {
        $chatMail = new Mails();
        $chatMail->sender_id = $this->sender_id;
        $chatMail->reciever_id = $this->reciever_id;
        $chatMail->mail = $this->mail;
        $chatMail->save();

        $this->appendChatMails($chatMail);

        broadcast(new MailSentEvent($chatMail))->toOthers();
        $this->mail = '';
    }

    #On(['echo-private:chat-channel.{sender_id},MailSentEvent']);
    
     public function listenMail($mail)
    {
        $chatMail = Mails::find($mail['id']);
        if ($chatMail) {
            $this->appendChatMails($chatMail);
        }
    }

    public function appendChatMails($mail)
    {
        $this->mails[] = [
            'id' => $mail->id,
            'mail' => $mail->mail,
            'sender' => $mail->sender->name,
            'reciever' => $mail->reciever->name
        ];
    }
}
