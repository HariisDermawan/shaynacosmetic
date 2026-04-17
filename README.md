<p align="center">
  <a href="#" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="ShaynaCosmetic Logo">
  </a>
</p>

<h1 align="center">SHAYNACOSMETIC</h1>

<p align="center">
  A modern cosmetic platform built with Laravel ecosystem and modern frontend technologies.
</p>

---

## SHAYNACOSMETIC

**SHAYNACOSMETIC** adalah aplikasi berbasis web yang dirancang untuk mengelola dan mengembangkan bisnis produk kosmetik secara digital. Platform ini mendukung pengelolaan produk, transaksi, serta integrasi API untuk kebutuhan frontend maupun pihak ketiga.

Project ini mengusung arsitektur modern dengan pemisahan backend dan frontend untuk performa serta skalabilitas yang lebih baik.

---

## 🚀 Tech Stack

Aplikasi ini dibangun menggunakan teknologi berikut:

### Backend

* **Laravel 13** — Framework utama untuk backend
* **RESTful API** — Sebagai penghubung antara backend dan frontend
* **Filament** — Admin panel untuk manajemen data

### Frontend

* **React JS** — Library untuk membangun user interface
* **TypeScript** — Superset JavaScript untuk code yang lebih aman dan scalable

---

## ✨ Features

* Manajemen produk kosmetik
* Dashboard admin (Filament)
* REST API untuk integrasi frontend
* Struktur scalable & clean architecture
* Modern UI dengan React + TypeScript

---

## 📦 Installation

Ikuti langkah berikut untuk menjalankan project secara lokal:

### 1. Clone Repository

```bash
git clone https://github.com/HariisDermawan/shaynacosmetic.git
cd shaynacosmetic
```

### 2. Install Dependencies Backend

```bash
composer install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Migrasi Database

```bash
php artisan migrate
```

### 5. Jalankan Server Backend

```bash
php artisan serve
```

---

### Frontend Setup

```bash
cd frontend
npm install
npm run dev
```

## 🛠️ Development Notes

* Gunakan Filament untuk mengelola data melalui admin panel
* Pastikan backend dan frontend berjalan bersamaan
* Gunakan TypeScript untuk menjaga konsistensi tipe data

---

