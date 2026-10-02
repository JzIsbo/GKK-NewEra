<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class JemaatDisetujuiNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public readonly string $password) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pendaftaran Jemaat Disetujui - GEMINDO Kawan Kasih')
            ->greeting("Shalom, {$notifiable->nama_lengkap}!")
            ->line('Selamat! Formulir pendaftaran keanggotaan jemaat Anda di Gereja GEMINDO Kawan Kasih telah disetujui oleh pihak Majelis.')
            ->line("**Nomor Induk Jemaat (NIJ):** {$notifiable->nomor_jemaat}")
            ->line("**Email Akun:** {$notifiable->email}")
            ->line("**Password Sementara:** `{$this->password}`")
            ->action('Masuk ke Portal GKK', route('login'))
            ->line('Demi keamanan akun Anda, silakan segera ubah password ini setelah berhasil login melalui halaman Profil Akun.')
            ->salutation("Tuhan Yesus Memberkati,\nMajelis Jemaat GEMINDO Kawan Kasih");
    }
}
