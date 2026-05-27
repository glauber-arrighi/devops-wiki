<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\SmtpSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;

class SmtpController extends Controller
{
    public function edit() {
        $smtp = SmtpSetting::first();
        return view('admin.smtp.edit', compact('smtp'));
    }
    public function update(Request $request) {
        $request->validate([
            'host'         => 'required|string|max:255',
            'port'         => 'required|integer|min:1|max:65535',
            'encryption'   => 'required|in:tls,ssl,none',
            'username'     => 'required|string|max:255',
            'from_address' => 'required|email',
            'from_name'    => 'required|string|max:255',
        ]);
        $data = $request->only('host','port','encryption','username','from_address','from_name');
        if ($request->filled('password')) $data['password'] = $request->password;
        SmtpSetting::updateOrCreate(['id' => 1], $data);
        return redirect()->route('admin.smtp.edit')->with('success', 'Configurações SMTP salvas!');
    }
    public function test(Request $request) {
        $smtp = SmtpSetting::first();
        if (!$smtp) return back()->withErrors(['error' => 'Configure o SMTP primeiro.']);
        try {
            Config::set('mail.mailers.smtp', [
                'transport'  => 'smtp',
                'host'       => $smtp->host,
                'port'       => $smtp->port,
                'encryption' => $smtp->encryption === 'none' ? null : $smtp->encryption,
                'username'   => $smtp->username,
                'password'   => $smtp->password,
            ]);
            Mail::raw('Teste de configuração SMTP — DevOps Wiki', function ($msg) use ($smtp) {
                $msg->to($smtp->username)->subject('Teste SMTP — DevOps Wiki');
            });
            $smtp->update(['tested_at' => now(), 'last_test_ok' => true]);
            return back()->with('success', 'E-mail de teste enviado com sucesso!');
        } catch (\Exception $e) {
            $smtp->update(['tested_at' => now(), 'last_test_ok' => false]);
            return back()->withErrors(['error' => 'Falha: ' . $e->getMessage()]);
        }
    }
}
