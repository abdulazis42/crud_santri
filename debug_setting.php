<?php
require_once 'db.php';

echo "<h2>🔍 Debug Form Setting</h2>";
echo "<hr>";

// 1. Test Database Connection
echo "<h3>1. Database Connection</h3>";
if ($conn) {
    echo "<p style='color: green;'>✅ Database connection successful</p>";
} else {
    echo "<p style='color: red;'>❌ Database connection failed</p>";
    exit;
}

// 2. Check Setting Table
echo "<h3>2. Setting Table Check</h3>";
$table_check = $conn->query("SHOW TABLES LIKE 'setting'");
if ($table_check->num_rows > 0) {
    echo "<p style='color: green;'>✅ Setting table exists</p>";
    
    // Check table structure
    $structure = $conn->query("DESCRIBE setting");
    echo "<h4>Table Structure:</h4>";
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>";
    while ($row = $structure->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['Field']}</td>";
        echo "<td>{$row['Type']}</td>";
        echo "<td>{$row['Null']}</td>";
        echo "<td>{$row['Key']}</td>";
        echo "<td>{$row['Default']}</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check data count
    $count = $conn->query("SELECT COUNT(*) as total FROM setting");
    $total = $count->fetch_assoc()['total'];
    echo "<p>Total records: <strong>$total</strong></p>";
    
    // Show sample data
    if ($total > 0) {
        $data = $conn->query("SELECT * FROM setting ORDER BY id LIMIT 5");
        echo "<h4>Sample Data:</h4>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Key</th><th>Value</th><th>Deskripsi</th></tr>";
        while ($row = $data->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['key']}</td>";
            echo "<td>{$row['value']}</td>";
            echo "<td>{$row['deskripsi']}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='color: orange;'>⚠️ No data found in setting table</p>";
    }
    
} else {
    echo "<p style='color: red;'>❌ Setting table does not exist</p>";
    
    // Try to create table
    echo "<p>Creating setting table...</p>";
    $create_sql = "CREATE TABLE `setting` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `key` varchar(100) NOT NULL,
        `value` text NOT NULL,
        `deskripsi` text,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `unique_key` (`key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    if ($conn->query($create_sql)) {
        echo "<p style='color: green;'>✅ Setting table created successfully</p>";
        
        // Insert sample data
        $sample_data = [
            ['app_name', 'Sistem Pondok Pesantren', 'Nama aplikasi yang ditampilkan di header dan title'],
            ['app_version', '1.0.0', 'Versi aplikasi saat ini'],
            ['max_students', '500', 'Jumlah maksimal santri yang dapat didaftarkan'],
            ['academic_year', '2024/2025', 'Tahun ajaran saat ini'],
            ['school_address', 'Jl. Pesantren No. 123, Kota Santri', 'Alamat lengkap pondok pesantren'],
            ['school_phone', '+62 123 456 789', 'Nomor telepon pondok pesantren'],
            ['school_email', 'info@pondokpesantren.com', 'Email resmi pondok pesantren']
        ];
        
        foreach ($sample_data as $data) {
            $stmt = $conn->prepare("INSERT INTO setting (`key`, `value`, `deskripsi`) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $data[0], $data[1], $data[2]);
            if ($stmt->execute()) {
                echo "<p style='color: green;'>✅ Inserted: {$data[0]}</p>";
            } else {
                echo "<p style='color: red;'>❌ Failed to insert: {$data[0]} - {$stmt->error}</p>";
            }
            $stmt->close();
        }
    } else {
        echo "<p style='color: red;'>❌ Failed to create setting table: {$conn->error}</p>";
    }
}

// 3. Test API Function
echo "<h3>3. Test API Function</h3>";
echo "<p>Testing getSetting() function...</p>";

// Simulate the getSetting function
function testGetSetting($conn) {
    $query = "SELECT * FROM setting ORDER BY `key`";
    $result = $conn->query($query);
    
    if (!$result) {
        return ['success' => false, 'message' => 'Database error: ' . $conn->error];
    }
    
    $html = '';
    if ($result->num_rows > 0) {
        $html .= '<div class="table-responsive">';
        $html .= '<table class="table table-hover">';
        $html .= '<thead class="table-light">';
        $html .= '<tr>';
        $html .= '<th width="8%"><i class="fas fa-hashtag me-2"></i>ID</th>';
        $html .= '<th width="25%"><i class="fas fa-key me-2"></i>Kunci</th>';
        $html .= '<th width="30%"><i class="fas fa-tag me-2"></i>Nilai</th>';
        $html .= '<th width="25%"><i class="fas fa-info-circle me-2"></i>Deskripsi</th>';
        $html .= '<th width="12%"><i class="fas fa-cogs me-2"></i>Aksi</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        
        while ($row = $result->fetch_assoc()) {
            $html .= '<tr>';
            $html .= '<td><span class="badge bg-primary rounded-pill">' . $row['id'] . '</span></td>';
            $html .= '<td><code class="setting-key">' . htmlspecialchars($row['key']) . '</code></td>';
            $html .= '<td><div class="setting-value" title="' . htmlspecialchars($row['value']) . '">' . htmlspecialchars($row['value']) . '</div></td>';
            $html .= '<td><small class="setting-description">' . htmlspecialchars($row['deskripsi'] ?? '') . '</small></td>';
            $html .= '<td>';
            $html .= '<div class="btn-group btn-group-sm" role="group">';
            $html .= '<button class="btn btn-warning" onclick="editSetting(' . $row['id'] . ', \'' . htmlspecialchars($row['key']) . '\', \'' . htmlspecialchars($row['value']) . '\', \'' . htmlspecialchars($row['deskripsi'] ?? '') . '\')" title="Edit">';
            $html .= '<i class="fas fa-edit"></i></button>';
            $html .= '<button class="btn btn-danger" onclick="deleteSetting(' . $row['id'] . ', \'' . htmlspecialchars($row['key']) . '\')" title="Hapus">';
            $html .= '<i class="fas fa-trash"></i></button>';
            $html .= '</div>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        
        $html .= '</tbody></table>';
        $html .= '</div>';
        
        return ['success' => true, 'html' => $html];
    } else {
        $html .= '<div class="empty-state">';
        $html .= '<i class="fas fa-cogs fa-3x text-muted mb-3"></i>';
        $html .= '<h5 class="text-muted">Belum ada pengaturan</h5>';
        $html .= '<p class="text-muted">Mulai dengan menambahkan pengaturan pertama</p>';
        $html .= '</div>';
        
        return ['success' => true, 'html' => $html];
    }
}

$test_result = testGetSetting($conn);
echo "<p>Function result: <strong>" . ($test_result['success'] ? 'SUCCESS' : 'FAILED') . "</strong></p>";

if ($test_result['success']) {
    echo "<p>HTML generated: <strong>" . strlen($test_result['html']) . " characters</strong></p>";
    echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; max-height: 300px; overflow-y: auto;'>";
    echo "<h5>Generated HTML Preview:</h5>";
    echo htmlspecialchars(substr($test_result['html'], 0, 500)) . "...";
    echo "</div>";
} else {
    echo "<p style='color: red;'>Error: " . $test_result['message'] . "</p>";
}

// 4. Test API Endpoint
echo "<h3>4. Test API Endpoint</h3>";
$api_url = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . "/api_handler.php?action=get_setting";
echo "<p>API URL: <a href='$api_url' target='_blank'>$api_url</a></p>";

// Test with file_get_contents first
$context = stream_context_create([
    'http' => [
        'timeout' => 10,
        'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
    ]
]);

$response = @file_get_contents($api_url, false, $context);
if ($response !== false) {
    echo "<p style='color: green;'>✅ API endpoint accessible with file_get_contents</p>";
    $data = json_decode($response, true);
    if ($data && isset($data['success'])) {
        if ($data['success']) {
            echo "<p style='color: green;'>✅ API response successful</p>";
            echo "<p>Response contains HTML: " . (isset($data['html']) ? 'Yes' : 'No') . "</p>";
            if (isset($data['html'])) {
                echo "<p>HTML length: " . strlen($data['html']) . " characters</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ API response failed: " . ($data['message'] ?? 'Unknown error') . "</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ API response format unexpected</p>";
        echo "<pre>" . htmlspecialchars($response) . "</pre>";
    }
} else {
    echo "<p style='color: red;'>❌ API endpoint not accessible with file_get_contents</p>";
    
    // Try with curl if available
    if (function_exists('curl_init')) {
        echo "<p>Trying with cURL...</p>";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($http_code == 200) {
            echo "<p style='color: green;'>✅ API endpoint accessible with cURL (HTTP $http_code)</p>";
            $data = json_decode($response, true);
            if ($data && isset($data['success'])) {
                if ($data['success']) {
                    echo "<p style='color: green;'>✅ API response successful</p>";
                    echo "<p>Response contains HTML: " . (isset($data['html']) ? 'Yes' : 'No') . "</p>";
                    if (isset($data['html'])) {
                        echo "<p>HTML length: " . strlen($data['html']) . " characters</p>";
                    }
                } else {
                    echo "<p style='color: red;'>❌ API response failed: " . ($data['message'] ?? 'Unknown error') . "</p>";
                }
            } else {
                echo "<p style='color: orange;'>⚠️ API response format unexpected</p>";
                echo "<pre>" . htmlspecialchars($response) . "</pre>";
            }
        } else {
            echo "<p style='color: red;'>❌ API endpoint not accessible with cURL (HTTP $http_code)</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠️ cURL not available</p>";
    }
}

// 5. Check for JavaScript errors
echo "<h3>5. JavaScript Debug</h3>";
echo "<p>Add this to browser console to debug JavaScript:</p>";
echo "<pre style='background: #f8f9fa; padding: 10px; border-radius: 5px;'>";
echo "// Debug loadSettingTable function
console.log('Testing loadSettingTable...');
fetch('api_handler.php?action=get_setting')
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            console.log('HTML length:', data.html ? data.html.length : 'No HTML');
        } else {
            console.log('Error:', data.message);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
    });";
echo "</pre>";

echo "<hr>";
echo "<h3>🔧 Quick Fixes to Try:</h3>";
echo "<ol>";
echo "<li><strong>Check Browser Console:</strong> Press F12 and look for JavaScript errors</li>";
echo "<li><strong>Check Network Tab:</strong> See if API calls are being made</li>";
echo "<li><strong>Check File Permissions:</strong> Ensure api_handler.php is readable</li>";
echo "<li><strong>Check .htaccess:</strong> If using Apache, ensure proper configuration</li>";
echo "</ol>";

echo "<p><a href='setting.php'>Go to Setting Page</a></p>";
echo "<p><a href='api_handler.php?action=get_setting' target='_blank'>Test API Directly</a></p>";
?>
