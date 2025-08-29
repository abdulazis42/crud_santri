# 🔧 Troubleshooting Form Setting

## ❌ **Masalah: "Terjadi kesalahan saat memuat data"**

### **Langkah-langkah Troubleshooting:**

#### **1. Test API Endpoint Langsung**
```bash
# Buka browser dan akses:
http://localhost/crud_santri/api_handler.php?action=get_setting
```

**Expected Response:**
```json
{
  "success": true,
  "html": "<div class='table-responsive'>...</div>"
}
```

**Jika Error:**
- Periksa apakah file `api_handler.php` ada
- Periksa apakah database bisa diakses
- Periksa error log PHP

#### **2. Test Database Connection**
```bash
# Buka file:
http://localhost/crud_santri/debug_setting.php
```

**Atau buat file test sederhana:**
```php
<?php
require_once 'db.php';
if ($conn) {
    echo "Database OK";
    $result = $conn->query("SELECT COUNT(*) as count FROM setting");
    $count = $result->fetch_assoc()['count'];
    echo " - Setting records: $count";
} else {
    echo "Database Error: " . $conn->error;
}
?>
```

#### **3. Check Browser Console (F12)**
```javascript
// Test API manually
fetch('api_handler.php?action=get_setting')
    .then(r => r.json())
    .then(data => console.log('API Response:', data))
    .catch(err => console.error('Error:', err));

// Check if function exists
console.log('loadSettingTable function:', typeof loadSettingTable);
```

#### **4. Check Network Tab**
- Buka Developer Tools (F12)
- Pilih tab Network
- Refresh halaman
- Lihat apakah ada request ke `api_handler.php`
- Periksa response status dan content

#### **5. Common Issues & Solutions**

##### **Issue 1: Database Table Not Found**
```sql
-- Create setting table manually
CREATE TABLE `setting` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `key` varchar(100) NOT NULL,
    `value` text NOT NULL,
    `deskripsi` text,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `unique_key` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data
INSERT INTO `setting` (`key`, `value`, `deskripsi`) VALUES
('app_name', 'Sistem Pondok Pesantren', 'Nama aplikasi yang ditampilkan di header dan title'),
('app_version', '1.0.0', 'Versi aplikasi saat ini'),
('max_students', '500', 'Jumlah maksimal santri yang dapat didaftarkan');
```

##### **Issue 2: PHP Error in API**
- Periksa error log PHP
- Tambahkan error reporting di `api_handler.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

##### **Issue 3: JavaScript Error**
- Periksa console browser
- Pastikan Bootstrap JS ter-load
- Pastikan fungsi `loadSettingTable` terdefinisi

##### **Issue 4: File Permissions**
- Pastikan `api_handler.php` readable
- Pastikan `db.php` accessible
- Periksa file ownership

#### **6. Alternative Testing Methods**

##### **Method 1: Simple HTML Test**
```html
<!DOCTYPE html>
<html>
<head><title>Test Setting</title></head>
<body>
    <h1>Test Setting API</h1>
    <button onclick="testAPI()">Test API</button>
    <div id="result"></div>
    
    <script>
    async function testAPI() {
        try {
            const response = await fetch('api_handler.php?action=get_setting');
            const data = await response.json();
            document.getElementById('result').innerHTML = 
                '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        } catch (error) {
            document.getElementById('result').innerHTML = 
                '<p style="color:red">Error: ' + error.message + '</p>';
        }
    }
    </script>
</body>
</html>
```

##### **Method 2: Direct PHP Test**
```php
<?php
// test_setting_direct.php
require_once 'db.php';

echo "<h2>Direct Test</h2>";

// Test database
if ($conn) {
    echo "<p style='color:green'>✓ Database OK</p>";
    
    // Test setting table
    $result = $conn->query("SHOW TABLES LIKE 'setting'");
    if ($result->num_rows > 0) {
        echo "<p style='color:green'>✓ Setting table exists</p>";
        
        // Test data
        $data = $conn->query("SELECT * FROM setting LIMIT 5");
        echo "<p>Records found: " . $data->num_rows . "</p>";
        
        while ($row = $data->fetch_assoc()) {
            echo "<p>• {$row['key']}: {$row['value']}</p>";
        }
    } else {
        echo "<p style='color:red'>✗ Setting table not found</p>";
    }
} else {
    echo "<p style='color:red'>✗ Database error</p>";
}
?>
```

#### **7. Quick Fix Checklist**

- [ ] Database connection working?
- [ ] Setting table exists?
- [ ] Setting table has data?
- [ ] API endpoint accessible?
- [ ] JavaScript functions defined?
- [ ] No console errors?
- [ ] Network requests successful?

#### **8. Debug Files Available**

1. **`debug_setting.php`** - Comprehensive debugging
2. **`test_setting_simple.html`** - Simple API test
3. **`setting_fixed.php`** - Enhanced version with debugging
4. **`test_setting.php`** - Database and API testing

#### **9. Next Steps**

1. **Run debug files** to identify the issue
2. **Check browser console** for JavaScript errors
3. **Test API directly** to see response
4. **Verify database** connection and data
5. **Fix identified issue** based on debug results

---

## 📞 **Need Help?**

Jika masih mengalami masalah, gunakan file-file debug yang tersedia:

1. **`http://localhost/crud_santri/debug_setting.php`** - Debug lengkap
2. **`http://localhost/crud_santri/test_setting_simple.html`** - Test API sederhana
3. **`http://localhost/crud_santri/setting_fixed.php`** - Versi yang diperbaiki

Semua file ini akan membantu mengidentifikasi dan memperbaiki masalah!
