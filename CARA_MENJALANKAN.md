# 🚀 CARA MENJALANKAN SISTEM BARU

## 📋 **Langkah-langkah Menjalankan**

### 1. **Setup Database**
```bash
# Buka browser dan akses:
http://localhost:8000/setup_database.php
```

**Hasil yang Diharapkan:**
- ✅ Database 'pondok_pesantren' ditemukan
- ✅ Query berhasil dijalankan
- ✅ Semua tabel tersedia (santri, jenis_tagihan, kategori_diskon, diskon_rule)

### 2. **Akses Dashboard Utama**
```bash
# Buka browser dan akses:
http://localhost:8000/dashboard.php
```

**Fitur yang Tersedia:**
- 📊 Overview sistem
- 🔗 Link ke semua halaman
- 📱 Responsive design

### 3. **Test Halaman Terpisah**

#### **A. Halaman Daftar Santri**
```bash
# Buka browser dan akses:
http://localhost:8000/index.php
```

**Test yang Bisa Dilakukan:**
- ✅ Lihat daftar santri
- ✅ Tambah santri baru
- ✅ Edit data santri
- ✅ Hapus santri
- ✅ Navigasi ke halaman lain

#### **B. Halaman Jenis Tagihan**
```bash
# Buka browser dan akses:
http://localhost:8000/jenis_tagihan.php
```

**Test yang Bisa Dilakukan:**
- ✅ Lihat daftar jenis tagihan
- ✅ Tambah jenis tagihan baru
- ✅ Edit jenis tagihan
- ✅ Hapus jenis tagihan
- ✅ Navigasi ke halaman lain

#### **C. Halaman Sistem Diskon**
```bash
# Buka browser dan akses:
http://localhost:8000/sistem_diskon.php
```

**Test yang Bisa Dilakukan:**
- ✅ Tab Kategori Diskon
- ✅ Tab Aturan Diskon
- ✅ Tab Kalkulator Diskon
- ✅ CRUD untuk semua fitur
- ✅ Navigasi ke halaman lain

## 🎯 **Test Fitur Utama**

### **Test CRUD Santri**
1. **Create**: Klik "Tambah Santri" → Isi form → Submit
2. **Read**: Lihat data di tabel
3. **Update**: Klik tombol "Edit" → Ubah data → Submit
4. **Delete**: Klik tombol "Hapus" → Konfirmasi

### **Test CRUD Jenis Tagihan**
1. **Create**: Klik "Tambah Jenis Tagihan" → Isi nama → Submit
2. **Read**: Lihat data di tabel
3. **Update**: Klik tombol "Edit" → Ubah nama → Submit
4. **Delete**: Klik tombol "Hapus" → Konfirmasi

### **Test Sistem Diskon**
1. **Kategori Diskon**:
   - Tambah kategori baru
   - Edit kategori yang ada
   - Hapus kategori

2. **Aturan Diskon**:
   - Tambah aturan baru
   - Pilih jenis tagihan
   - Pilih kategori diskon
   - Set persentase

3. **Kalkulator Diskon**:
   - Pilih santri
   - Pilih jenis tagihan
   - Masukkan jumlah tagihan
   - Lihat hasil perhitungan

## 🔍 **Troubleshooting**

### **Jika Database Error**
```bash
# 1. Pastikan XAMPP berjalan
# 2. Buka phpMyAdmin
# 3. Buat database 'pondok_pesantren'
# 4. Jalankan setup_database.php
```

### **Jika Halaman Tidak Muncul**
```bash
# 1. Cek file ada di folder yang benar
# 2. Pastikan nama file sesuai
# 3. Cek error di console browser
# 4. Cek error di log PHP
```

### **Jika Modal Tidak Bisa Ditutup**
```bash
# 1. Refresh halaman
# 2. Cek Bootstrap JS terload
# 3. Cek console untuk error JavaScript
```

## 📱 **Test Responsive Design**

### **Desktop (>768px)**
- Sidebar fixed di kiri
- Main content dengan margin
- Modal dengan padding untuk sidebar

### **Mobile (≤768px)**
- Sidebar menjadi header
- Main content full width
- Modal full width

### **Test Device**
- Desktop browser
- Mobile browser
- Tablet browser
- Resize browser window

## 🎨 **Test UI/UX**

### **Sidebar Navigation**
- ✅ Hover effect
- ✅ Active state
- ✅ Icon display
- ✅ Link functionality

### **Card Design**
- ✅ Gradient header
- ✅ Shadow effect
- ✅ Border radius
- ✅ Responsive layout

### **Modal Forms**
- ✅ Header gradient
- ✅ Form validation
- ✅ Button styling
- ✅ Close functionality

### **Tables**
- ✅ Header styling
- ✅ Row hover effect
- ✅ Action buttons
- ✅ Responsive design

## 🔧 **Test API Integration**

### **Check Network Tab**
1. Buka Developer Tools (F12)
2. Pilih tab Network
3. Lakukan operasi CRUD
4. Lihat request ke `api_handler.php`

### **Check Console**
1. Buka Developer Tools (F12)
2. Pilih tab Console
3. Lihat error atau log
4. Test JavaScript functions

### **Check Response**
1. Lihat response dari API
2. Pastikan format JSON
3. Cek success/error status
4. Validasi data yang dikembalikan

## 📊 **Expected Results**

### **Database Setup**
```
✅ Database 'pondok_pesantren' ditemukan
✅ Query berhasil: [jumlah] queries
✅ Tabel 'santri' - [jumlah] data
✅ Tabel 'jenis_tagihan' - [jumlah] data
✅ Tabel 'kategori_diskon' - 10 data
✅ Tabel 'diskon_rule' - 0 data
```

### **Halaman Loading**
```
✅ Sidebar muncul dengan semua menu
✅ Main content load dengan data
✅ Tables populate dengan data
✅ Modals berfungsi dengan baik
✅ Navigation antar halaman smooth
```

### **CRUD Operations**
```
✅ Create: Data tersimpan ke database
✅ Read: Data ditampilkan di tabel
✅ Update: Data berubah di database
✅ Delete: Data hilang dari tabel
```

## 🎉 **Success Criteria**

Sistem berhasil jika:

1. **✅ Database Setup**: Semua tabel terbuat dengan data
2. **✅ Navigation**: Semua halaman bisa diakses
3. **✅ CRUD Operations**: Semua operasi berfungsi
4. **✅ UI/UX**: Design konsisten dan responsif
5. **✅ API Integration**: Semua endpoint berfungsi
6. **✅ Error Handling**: Error ditampilkan dengan baik
7. **✅ Responsive**: Tampilan optimal di semua device

## 🚀 **Next Steps**

Setelah sistem berjalan dengan baik:

1. **Test Performance**: Cek loading time
2. **Test Security**: Validasi input dan output
3. **Test Edge Cases**: Data kosong, error handling
4. **User Training**: Demo ke pengguna
5. **Documentation**: Update dokumentasi
6. **Backup**: Backup database dan code

---

**🎯 Sistem siap untuk testing dan penggunaan!**
