
try {
    echo "--- business_package_features ---\n";
    $columns = DB::select('DESCRIBE business_package_features');
    foreach ($columns as $col) {
        echo $col->Field . " (" . $col->Type . ")\n";
    }
} catch (\Exception $e) {
    echo "Error business_package_features: " . $e->getMessage() . "\n";
}

try {
    echo "\n--- business_feature_usages ---\n";
    $columns = DB::select('DESCRIBE business_feature_usages');
    foreach ($columns as $col) {
        echo $col->Field . " (" . $col->Type . ")\n";
    }
} catch (\Exception $e) {
    echo "Error business_feature_usages: " . $e->getMessage() . "\n";
}
