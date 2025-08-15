# CRUD Jenis Tagihan - Pondok Pesantren

Sistem CRUD (Create, Read, Update, Delete) untuk mengelola jenis-jenis tagihan di pondok pesantren.

## Fitur

- ✅ **Create**: Tambah jenis tagihan baru
- ✅ **Read**: Lihat daftar semua jenis tagihan
- ✅ **Update**: Edit nama jenis tagihan
- ✅ **Delete**: Hapus jenis tagihan (soft delete)
- ✅ **Validation**: Validasi input dan duplikasi nama
- ✅ **Responsive**: Interface yang responsif dengan Bootstrap
- ✅ **Navigation**: Menu navigasi yang konsisten

## Struktur Database

Tabel `jenis_tagihan` dengan struktur:
- `id` (int, auto increment, primary key)
- `nama` (varchar 100, nama jenis tagihan)
- `is_deleted` (tinyint 1, flag soft delete)

## File yang Dibuat

1. **`pondok_pesantren.sql`** - Struktur database lengkap (sudah termasuk tabel jenis_tagihan)
2. **`jenis_tagihan.php`** - Halaman utama (list dan delete)
3. **`jenis_tagihan_tambah.php`** - Form tambah jenis tagihan
4. **`jenis_tagihan_edit.php`** - Form edit jenis tagihan
5. **`jenis_tagihan_hapus.php`** - Konfirmasi hapus jenis tagihan

## Cara Penggunaan

### 1. Setup Database
- Import file `pondok_pesantren.sql` ke database MySQL (sudah termasuk tabel jenis_tagihan)
- Pastikan database `pondok_pesantren` sudah ada
- Pastikan file `db.php` sudah dikonfigurasi dengan benar

### 2. Akses Sistem
- Buka `santri.php` untuk melihat menu navigasi
- Klik "Jenis Tagihan" untuk masuk ke sistem jenis tagihan
- Atau langsung buka `jenis_tagihan.php`

### 3. Operasi CRUD

#### Tambah Jenis Tagihan
1. Klik tombol "Tambah Jenis Tagihan"
2. Isi nama jenis tagihan (contoh: SPP, Uang Makan, Uang Asrama)
3. Klik "Simpan"

#### Edit Jenis Tagihan
1. Klik tombol "Edit" pada baris yang ingin diedit
2. Ubah nama jenis tagihan
3. Klik "Update"

#### Hapus Jenis Tagihan
1. Klik tombol "Hapus" pada baris yang ingin dihapus
2. Konfirmasi penghapusan
3. Klik "Ya, Hapus"

## Validasi

- Nama jenis tagihan tidak boleh kosong
- Nama jenis tagihan tidak boleh duplikat
- Soft delete (data tidak benar-benar dihapus dari database)

## Keamanan

- Menggunakan prepared statements untuk mencegah SQL injection
- Validasi input di sisi server
- Escape output HTML untuk mencegah XSS
- Soft delete untuk menjaga integritas data

## Dependencies

- PHP 7.2+
- MySQL/MariaDB
- Bootstrap 5.1.3
- Font Awesome 6.0.0

## Struktur File

```
crud-santri/
├── assets/
│   └── bootstrap.min.css
├── db.php
├── santri.php
├── pondok_pesantren.sql           # ← Database lengkap (santri + jenis_tagihan)
├── jenis_tagihan.php              # ← Halaman utama jenis tagihan
├── jenis_tagihan_tambah.php       # ← Form tambah
├── jenis_tagihan_edit.php         # ← Form edit
├── jenis_tagihan_hapus.php        # ← Konfirmasi hapus
└── README_JENIS_TAGIHAN.md        # ← Dokumentasi ini
```

## Catatan

- Sistem menggunakan soft delete (is_deleted = 1) bukan hard delete
- Data yang sudah dihapus tidak akan muncul di list
- Nama jenis tagihan harus unik untuk mencegah duplikasi
- Interface sudah responsive dan mobile-friendly 