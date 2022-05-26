<?php
namespace App\Service;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EnvoieNoteService {

    private $mailer;
    
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function envoyezNotes($tabNotes)
    {
        foreach ($tabNotes as $tab) {
            $emailParent = $tab["email"];
            $note = $tab["note"];
            $matiere = $tab["matiere"];
            $eleve = $tab["eleve"];

            //on genere le mail

            $msg = "Note de $eleve : $note en $matiere";

            $mail = new Email();

            $mail->from("yentemasabidani@gmail.com")
            ->to($emailParent)
            ->subject("Email des notes")
            ->text($msg);

            $this->mailer->send($mail);
        }
    }
}