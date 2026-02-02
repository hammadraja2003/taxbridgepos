
try {
    echo "--- business_feature_usage ---\n";
    $columns = DB::select('DESCRIBE business_feature_usage');
    foreach ($columns as $col) {
        echo $col->Field . " (" . $col->Type . ")\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
