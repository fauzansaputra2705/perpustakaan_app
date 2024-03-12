<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomResetPasswordNotification extends Notification
{
    use Queueable;

    /** @var string */
    protected $urlPassword = '';

    /** @var User */
    protected $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(string $urlPassword, User $user)
    {
        $this->urlPassword = $urlPassword;
        $this->user = $user;
    }

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
            ->subject('Reset Kata Sandi PERPUSTAKAAN APP')
            ->greeting('Hello! ' . $this->user->name)
            ->line('Kami telah menerima permintaanmu untuk mengganti kata sandi akun PERPUSTAKAAN APP.')
            ->line('Kata sandi Anda dapat diatur ulang dengan mengklik tombol di bawah ini.
            Jika Anda tidak meminta kata sandi baru, harap abaikan email ini.')
            ->action('Ubah Kata Sandi', $this->urlPassword)
            ->line('Jika anda tidak bisa mengklik tombol di atas,
            Berikut ini adalah link url untuk mengubah kata sandi akun anda:')
            ->line($this->urlPassword);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
