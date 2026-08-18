<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WaNotificationService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = 'https://api.fonnte.com';
        $this->token = env('FONNTE_TOKEN');
    }

    public function send($nomor, $pesan)
    {
        $response = Http::withHeaders([
            'Authorization' => $this->token,
        ])->post($this->baseUrl . '/send', [
            'target' => $nomor,
            'message' => $pesan,
        ]);

        return $response->successful();
    }

    public function sendGuruApproved($nomor, $nama)
    {
        $pesan = "Halo {$nama},\n\nAkun SiPANDU VIRTUAL Anda telah disetujui. Silakan login di http://sipandu.local/login";
        return $this->send($nomor, $pesan);
    }

    public function sendGuruRejected($nomor, $nama, $alasan)
    {
        $pesan = "Halo {$nama},\n\nMaaf, akun SiPANDU VIRTUAL Anda ditolak.\nAlasan: {$alasan}\n\nHubungi admin jika ada pertanyaan.";
        return $this->send($nomor, $pesan);
    }

    public function sendSubmissionReviewed($nomor, $nama, $triwulan, $status, $feedback)
    {
        $pesan = "Halo {$nama},\n\nSubmission TW {$triwulan} Anda telah {$status}.\nFeedback: {$feedback}\n\nSilakan cek di dashboard.";
        return $this->send($nomor, $pesan);
    }
}