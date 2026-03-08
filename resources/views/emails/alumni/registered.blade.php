<x-mail::message>
# Halo, {{ $user->name }}

Selamat! Pendaftaran profil alumni Anda di sistem **siAlumni** telah berhasil.

Berikut adalah informasi akun Anda untuk login ke dalam sistem:
- **Email:** {{ $user->email }}
- **Password:** {{ $password }}

<x-mail::button :url="route('login')">
Login Sekarang
</x-mail::button>

*Catatan: Segera login dan ubah password Anda demi keamanan akun.*

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
