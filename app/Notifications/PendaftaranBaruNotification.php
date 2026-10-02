<?php

namespace App\Notifications;

use App\Models\PendaftaranJemaat;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PendaftaranBaruNotification extends Notification
{
    use Queueable;

    public function __construct(public PendaftaranJemaat $pendaftaran) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type'    => 'pendaftaran_baru',
            'judul'   => 'Pendaftaran Jemaat Baru',
            'pesan'   => "Pendaftaran atas nama {$this->pendaftaran->nama_lengkap} menunggu persetujuan.",
            'url'     => route('majelis.pendaftaran.index'),
            'icon'    => '👤',
        ];
    }
}
