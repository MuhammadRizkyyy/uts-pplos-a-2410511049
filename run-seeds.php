<?php

echo "==========================================\n";
echo "  RUNNING ALL DATABASE SEEDS\n";
echo "==========================================\n\n";

$config = [
    'host' => 'localhost',
    'user' => 'root',
    'pass' => '',
];

$seeds = [
    [
        'name' => 'Auth Service (kos_auth)',
        'file' => 'services/auth-service/src/database/seeds/001_seed_users.sql',
    ],
    [
        'name' => 'Property Service (kos_property)',
        'file' => 'services/property-service/database/seeds/001_seed_properties_rooms.sql',
    ],
    [
        'name' => 'Booking Service (kos_booking)',
        'file' => 'services/booking-service/src/database/seeds/001_seed_bookings_payments.sql',
    ],
];

$success = 0;
$failed = 0;

foreach ($seeds as $index => $seed) {
    $num = $index + 1;
    echo "[$num/3] Seeding {$seed['name']}...\n";
    
    if (!file_exists($seed['file'])) {
        echo "✗ File not found: {$seed['file']}\n\n";
        $failed++;
        continue;
    }
    
    try {
        $sql = file_get_contents($seed['file']);
        
        $mysqli = new mysqli($config['host'], $config['user'], $config['pass']);
        
        if ($mysqli->connect_error) {
            throw new Exception("Connection failed: " . $mysqli->connect_error);
        }
        
        if ($mysqli->multi_query($sql)) {
            do {
                if ($result = $mysqli->store_result()) {
                    while ($row = $result->fetch_assoc()) {
                        if (isset($row['message'])) {
                            echo "  → {$row['message']}\n";
                        }
                        if (isset($row['total_properties'])) {
                            echo "  → Total properties: {$row['total_properties']}\n";
                        }
                        if (isset($row['total_rooms'])) {
                            echo "  → Total rooms: {$row['total_rooms']}\n";
                        }
                        if (isset($row['total_bookings'])) {
                            echo "  → Total bookings: {$row['total_bookings']}\n";
                        }
                        if (isset($row['total_payments'])) {
                            echo "  → Total payments: {$row['total_payments']}\n";
                        }
                    }
                    $result->free();
                }
                
                if (!$mysqli->more_results()) {
                    break;
                }
            } while ($mysqli->next_result());
            
            echo "✓ {$seed['name']} seeded successfully\n\n";
            $success++;
        } else {
            throw new Exception($mysqli->error);
        }
        
        $mysqli->close();
        
    } catch (Exception $e) {
        echo "✗ {$seed['name']} seeding failed\n";
        echo "  Error: " . $e->getMessage() . "\n\n";
        $failed++;
    }
}

echo "==========================================\n";
echo "  SEEDING COMPLETED!\n";
echo "==========================================\n\n";
echo "Results:\n";
echo "Success: $success\n";
echo "Failed: $failed\n\n";

if ($success === 3) {
    echo "Summary:\n";
    echo "- Auth Service: 5 users, 5 refresh tokens\n";
    echo "- Property Service: 5 properties, 25 rooms\n";
    echo "- Booking Service: 5 bookings, 10 payments\n\n";
    echo "All seeds completed successfully!\n";
} else {
    echo "Some seeds failed. Please check the errors above.\n";
}
