# Database Documentation: Discount System

## Overview
Sistem diskon untuk pondok pesantren yang memungkinkan pengaturan diskon berdasarkan kategori santri dan jenis tagihan.

## Table Structure

### 1. Tabel `kategori_diskon`
Tabel untuk menyimpan kategori-kategori diskon yang tersedia.

| Column | Type | Null | Key | Default | Extra | Description |
|--------|------|------|-----|---------|-------|-------------|
| `id` | int(11) | NO | PRI | NULL | auto_increment | Primary key |
| `nama` | varchar(100) | NO | | NULL | | Nama kategori diskon |
| `is_deleted` | tinyint(1) | NO | | 0 | | Soft delete flag |
| `created_at` | timestamp | NO | | CURRENT_TIMESTAMP | | Waktu pembuatan record |
| `updated_at` | timestamp | NO | | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP | Waktu update terakhir |

**Sample Data:**
- Anak Yatim
- Anak Piatu
- Yatim Piatu
- Keluarga Tidak Mampu
- Prestasi Akademik
- Prestasi Non-Akademik
- Keluarga Guru/Staff
- Saudara Kandung
- Beasiswa Khusus
- Diskon Umum

### 2. Tabel `diskon_rule`
Tabel untuk menyimpan aturan diskon berdasarkan kombinasi jenis tagihan dan kategori diskon.

| Column | Type | Null | Key | Default | Extra | Description |
|--------|------|------|-----|---------|-------|-------------|
| `id` | int(11) | NO | PRI | NULL | auto_increment | Primary key |
| `jenis_tagihan_id` | int(11) | NO | MUL | NULL | | Foreign key ke jenis_tagihan |
| `kategori_diskon_id` | int(11) | NO | MUL | NULL | | Foreign key ke kategori_diskon |
| `diskon_persen` | decimal(5,2) | NO | | 0.00 | | Persentase diskon (0.00 - 100.00) |
| `is_aktif` | tinyint(1) | NO | MUL | 1 | | Status aktif aturan diskon |
| `is_deleted` | tinyint(1) | NO | MUL | 0 | | Soft delete flag |
| `created_at` | timestamp | NO | | CURRENT_TIMESTAMP | | Waktu pembuatan record |
| `updated_at` | timestamp | NO | | CURRENT_TIMESTAMP | on update CURRENT_TIMESTAMP | Waktu update terakhir |

### 3. Modifikasi Tabel `santri`
Kolom baru ditambahkan ke tabel santri yang sudah ada:

| Column | Type | Null | Key | Default | Extra | Description |
|--------|------|------|-----|---------|-------|-------------|
| `kategori_diskon_id` | int(11) | YES | MUL | NULL | | Foreign key ke kategori_diskon |

## Relationships

### Foreign Key Constraints

1. **santri → kategori_diskon**
   ```sql
   CONSTRAINT `fk_santri_kategori_diskon` 
   FOREIGN KEY (`kategori_diskon_id`) 
   REFERENCES `kategori_diskon`(`id`) 
   ON DELETE SET NULL ON UPDATE CASCADE
   ```

2. **diskon_rule → jenis_tagihan**
   ```sql
   CONSTRAINT `fk_diskon_rule_jenis_tagihan` 
   FOREIGN KEY (`jenis_tagihan_id`) 
   REFERENCES `jenis_tagihan`(`id`) 
   ON DELETE CASCADE ON UPDATE CASCADE
   ```

3. **diskon_rule → kategori_diskon**
   ```sql
   CONSTRAINT `fk_diskon_rule_kategori_diskon` 
   FOREIGN KEY (`kategori_diskon_id`) 
   REFERENCES `kategori_diskon`(`id`) 
   ON DELETE CASCADE ON UPDATE CASCADE
   ```

### Unique Constraints

1. **diskon_rule unique combination**
   ```sql
   CONSTRAINT `uk_diskon_rule_unique` 
   UNIQUE KEY (`jenis_tagihan_id`, `kategori_diskon_id`)
   ```
   - Mencegah duplikasi aturan diskon untuk kombinasi yang sama

## Indexes

### Performance Indexes

1. **kategori_diskon**
   - `PRIMARY KEY` on `id`

2. **diskon_rule**
   - `PRIMARY KEY` on `id`
   - `idx_jenis_tagihan_id` on `jenis_tagihan_id`
   - `idx_kategori_diskon_id` on `kategori_diskon_id`
   - `idx_is_aktif` on `is_aktif`
   - `idx_is_deleted` on `is_deleted`
   - `idx_diskon_rule_active` on (`is_aktif`, `is_deleted`)
   - `idx_diskon_rule_percentage` on `diskon_persen`

3. **santri**
   - `MUL` on `kategori_diskon_id`

## Business Logic

### Cara Kerja Sistem Diskon

1. **Kategori Santri**: Setiap santri dapat memiliki satu kategori diskon (atau tidak ada)
2. **Jenis Tagihan**: Setiap jenis tagihan dapat memiliki aturan diskon berbeda
3. **Aturan Diskon**: Kombinasi jenis tagihan + kategori diskon menentukan persentase diskon
4. **Perhitungan**: Diskon = (Jumlah Tagihan × Persentase Diskon) / 100

### Contoh Penggunaan

```sql
-- Contoh: Santri dengan kategori "Anak Yatim" mendapat diskon 50% untuk SPP
INSERT INTO diskon_rule (jenis_tagihan_id, kategori_diskon_id, diskon_persen, is_aktif) 
VALUES (1, 1, 50.00, 1);

-- Contoh: Santri dengan kategori "Prestasi Akademik" mendapat diskon 25% untuk semua tagihan
INSERT INTO diskon_rule (jenis_tagihan_id, kategori_diskon_id, diskon_persen, is_aktif) 
VALUES (1, 5, 25.00, 1); -- SPP
INSERT INTO diskon_rule (jenis_tagihan_id, kategori_diskon_id, diskon_persen, is_aktif) 
VALUES (2, 5, 25.00, 1); -- Uang Makan
```

### Query untuk Menghitung Diskon

```sql
-- Query untuk mendapatkan diskon berdasarkan santri dan jenis tagihan
SELECT 
    s.nama as nama_santri,
    jt.nama as jenis_tagihan,
    kd.nama as kategori_diskon,
    dr.diskon_persen,
    (jt.jumlah * dr.diskon_persen / 100) as jumlah_diskon
FROM santri s
LEFT JOIN kategori_diskon kd ON s.kategori_diskon_id = kd.id
LEFT JOIN diskon_rule dr ON kd.id = dr.kategori_diskon_id 
    AND dr.jenis_tagihan_id = ? -- ID jenis tagihan
WHERE s.id = ? -- ID santri
    AND dr.is_aktif = 1 
    AND dr.is_deleted = 0;
```

## Migration Files

### 1. `migration_create_discount_tables.sql`
File SQL murni untuk migrasi database. Dapat dijalankan langsung di MySQL client.

### 2. `run_migration.php`
File PHP dengan interface web untuk menjalankan migrasi dengan:
- Error handling yang baik
- Progress reporting
- Validasi setiap langkah
- Tampilan hasil yang informatif

## Cara Menjalankan Migrasi

### Opsi 1: Menggunakan PHP Script (Recommended)
1. Buka browser
2. Akses: `http://localhost/crud-santri/run_migration.php`
3. Ikuti instruksi yang muncul

### Opsi 2: Menggunakan SQL File
1. Buka MySQL client (phpMyAdmin, MySQL Workbench, atau command line)
2. Import file: `migration_create_discount_tables.sql`
3. Jalankan script

## Validasi Migrasi

Setelah migrasi berhasil, Anda dapat memvalidasi dengan query berikut:

```sql
-- Cek struktur tabel
DESCRIBE kategori_diskon;
DESCRIBE diskon_rule;

-- Cek foreign key constraints
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    CONSTRAINT_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = DATABASE()
AND REFERENCED_TABLE_NAME IS NOT NULL
AND TABLE_NAME IN ('santri', 'diskon_rule');

-- Cek sample data
SELECT * FROM kategori_diskon ORDER BY id;
```

## Maintenance

### Backup Sebelum Migrasi
```bash
mysqldump -u username -p database_name > backup_before_migration.sql
```

### Rollback (Jika Diperlukan)
```sql
-- Hapus foreign key constraints
ALTER TABLE santri DROP FOREIGN KEY fk_santri_kategori_diskon;
ALTER TABLE diskon_rule DROP FOREIGN KEY fk_diskon_rule_jenis_tagihan;
ALTER TABLE diskon_rule DROP FOREIGN KEY fk_diskon_rule_kategori_diskon;

-- Hapus kolom dari santri
ALTER TABLE santri DROP COLUMN kategori_diskon_id;

-- Hapus tabel
DROP TABLE IF EXISTS diskon_rule;
DROP TABLE IF EXISTS kategori_diskon;
```

## Security Considerations

1. **Input Validation**: Pastikan semua input divalidasi sebelum disimpan
2. **SQL Injection**: Gunakan prepared statements untuk query dinamis
3. **Access Control**: Implementasikan role-based access control
4. **Audit Trail**: Pertimbangkan untuk menambahkan log perubahan data

## Performance Considerations

1. **Indexes**: Semua foreign key dan kolom yang sering di-query sudah di-index
2. **Query Optimization**: Gunakan EXPLAIN untuk menganalisis query performance
3. **Caching**: Pertimbangkan caching untuk data yang jarang berubah
4. **Pagination**: Implementasikan pagination untuk data yang banyak
