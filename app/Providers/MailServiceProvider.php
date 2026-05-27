<?php
namespace App\Providers;

use App\Models\SmtpSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        try {
            $smtp = SmtpSetting::where('active', true)->first();
            if ($smtp) {
                Config::set('mail.default', 'smtp');
                Config::set('mail.mailers.smtp', [
                    'transport'  => 'smtp',
                    'host'       => $smtp->host,
                    'port'       => $smtp->port,
                    'encryption' => $smtp->encryption === 'none' ? null : $smtp->encryption,
                    'username'   => $smtp->username,
                    'password'   => $smtp->password,
                    'timeout'    => null,
                ]);
                Config::set('mail.from', [
                    'address' => $smtp->from_address,
                    'name'    => $smtp->from_name,
                ]);
            }
        } catch (\Exception $e) {
            // Banco ainda não disponível (migrations etc) — ignora
        }
    }
}
