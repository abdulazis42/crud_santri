# 🚀 Database Migration: Discount System

## 📋 Overview
Migrasi database untuk menambahkan sistem diskon ke aplikasi pondok pesantren. Sistem ini memungkinkan pengaturan diskon berdasarkan kategori santri dan jenis tagihan.

## 📁 Files Included

1. **`migration_create_discount_tables.sql`** - File SQL murni untuk migrasi
2. **`run_migration.php`** - Script PHP dengan interface web
3. **`DISCOUNT_DATABASE_DOCUMENTATION.md`** - Dokumentasi lengkap struktur database
4. **`README_MIGRATION.md`** - File ini (instruksi penggunaan)

## 🎯 What Will Be Created

### New Tables:
- **`kategori_diskon`** - Tabel kategori diskon (Anak Yatim, Prestasi, dll.)
- **`diskon_rule`** - Tabel aturan diskon (kombinasi jenis tagihan + kategori)

### Modified Tables:
- **`santri`** - Ditambahkan kolom `kategori_diskon_id`

### Relationships:
- `santri.kategori_diskon_id` → `kategori_diskon.id`
- `diskon_rule.jenis_tagihan_id` → `jenis_tagihan.id`
- `diskon_rule.kategori_diskon_id` → `kategori_diskon.id`

## ⚠️ Prerequisites

1. **Database Connection**: Pastikan file `db.php` sudah dikonfigurasi dengan benar
2. **Existing Tables**: Tabel `santri` dan `jenis_tagihan` harus sudah ada
3. **Backup**: **PENTING!** Backup database sebelum menjalankan migrasi

## 🔧 How to Run Migration

### Option 1: Using Web Interface (Recommended)

1. **Open your browser**
2. **Navigate to**: `http://localhost/crud-santri/run_migration.php`
3. **Follow the on-screen instructions**
4. **Check the results** - You'll see detailed progress and validation

### Option 2: Using SQL File Directly

1. **Open MySQL client** (phpMyAdmin, MySQL Workbench, or command line)
2. **Select your database**
3. **Import/Execute**: `migration_create_discount_tables.sql`
4. **Check for any errors**

### Option 3: Using Command Line

```bash
# Navigate to your project directory
cd /path/to/crud-santri

# Run migration using MySQL command line
mysql -u your_username -p your_database_name < migration_create_discount_tables.sql
```

## ✅ Validation After Migration

### Check Tables Exist
```sql
SHOW TABLES LIKE 'kategori_diskon';
SHOW TABLES LIKE 'diskon_rule';
```

### Check Table Structure
```sql
DESCRIBE kategori_diskon;
DESCRIBE diskon_rule;
```

### Check Foreign Keys
```sql
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
```

### Check Sample Data
```sql
SELECT * FROM kategori_diskon ORDER BY id;
```

## 📊 Sample Data Inserted

The migration will automatically insert these discount categories:

| ID | Nama Kategori |
|----|---------------|
| 1 | Anak Yatim |
| 2 | Anak Piatu |
| 3 | Yatim Piatu |
| 4 | Keluarga Tidak Mampu |
| 5 | Prestasi Akademik |
| 6 | Prestasi Non-Akademik |
| 7 | Keluarga Guru/Staff |
| 8 | Saudara Kandung |
| 9 | Beasiswa Khusus |
| 10 | Diskon Umum |

## 🔄 Rollback (If Needed)

If you need to undo the migration:

```sql
-- Drop foreign key constraints
ALTER TABLE santri DROP FOREIGN KEY fk_santri_kategori_diskon;
ALTER TABLE diskon_rule DROP FOREIGN KEY fk_diskon_rule_jenis_tagihan;
ALTER TABLE diskon_rule DROP FOREIGN KEY fk_diskon_rule_kategori_diskon;

-- Drop column from santri
ALTER TABLE santri DROP COLUMN kategori_diskon_id;

-- Drop tables
DROP TABLE IF EXISTS diskon_rule;
DROP TABLE IF EXISTS kategori_diskon;
```

## 🚨 Troubleshooting

### Common Issues:

1. **"Table already exists"**
   - This is normal - the migration uses `IF NOT EXISTS`
   - The script will skip existing tables

2. **"Foreign key constraint fails"**
   - Make sure `jenis_tagihan` table exists
   - Check that referenced tables have data

3. **"Access denied"**
   - Check database user permissions
   - Ensure user has CREATE, ALTER, INSERT privileges

4. **"Connection failed"**
   - Verify `db.php` configuration
   - Check database server is running

### Error Logs:
- Check your web server error logs
- Check MySQL error logs
- The PHP script will show detailed error messages

## 📈 Next Steps

After successful migration:

1. **Update your application code** to use the new discount system
2. **Add discount management interface** to your dashboard
3. **Test discount calculations** with sample data
4. **Configure discount rules** for your specific needs

## 📞 Support

If you encounter issues:

1. **Check the documentation**: `DISCOUNT_DATABASE_DOCUMENTATION.md`
2. **Review error messages** carefully
3. **Verify database permissions**
4. **Check table relationships**

## 🎉 Success Indicators

You'll know the migration was successful when you see:

- ✅ "Migration Completed Successfully!" message
- ✅ All tables created with correct structure
- ✅ Foreign key constraints established
- ✅ Sample data inserted
- ✅ No error messages in the output

---

**Happy Migrating! 🚀**
