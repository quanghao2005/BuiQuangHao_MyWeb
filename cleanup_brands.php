<?php
use App\Models\Brand;
use App\Models\Product;

// Find all brands
$brands = Brand::all();
$deletedCount = 0;

foreach ($brands as $brand) {
    // Check if brand has any products associated
    $productCount = Product::where('brandid', $brand->brandid)->count();
    
    if ($productCount == 0) {
        // Delete brand if no products
        $brand->delete();
        $deletedCount++;
    }
}

echo "Deleted " . $deletedCount . " unused brands.\n";
