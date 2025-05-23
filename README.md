# 💸 TopUp Wallet API

RESTful API Dompet Digital sederhana yang dibangun menggunakan Laravel dan JWT Authentication.

---

## 🚀 Fitur Utama

| Fitur             | Deskripsi                                              |
|------------------|--------------------------------------------------------|
| ✅ Register       | Daftar user baru menggunakan UUID dan phone number  |
| ✅ Login (JWT)    | Autentikasi user menggunakan PIN dan JWT token         |
| ✅ Top Up         | Menambah saldo ke akun                                 |
| ✅ Transfer       | Kirim saldo ke user lain (background job menggunakan Queue) |
| ✅ Report         | Menampilkan seluruh riwayat transaksi user            |
| ✅ Update Profile | Ubah nama depan, belakang, dan alamat user            |

---

## ⚙️ Teknologi

- Laravel 10+
- MySQL
- Tymon JWT Auth
- Laravel Queue (for Transfer)
- Postman (API Testing)
- PHPUnit (Unit Testing)

---

## 🛠️ Instalasi & Setup

```bash
git clone https://github.com/username/topup-wallet.git
cd topup-wallet

composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan jwt:secret

php artisan serve
