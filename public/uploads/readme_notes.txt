INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (NULL, 'Admin', 'pranto@admin.com', '1', NULL, '$2y$10$1utA0urqBDCKwLfTW7c.VuIb4D5dE0KLdgukMfRBidf7ZlWKJHiiC', NULL, '2024-11-28 05:26:32', '2024-11-28 05:26:32')

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES (NULL, 'Pranto', 'pranto@client.com', '0', NULL, '$2y$10$0JxoULfkvJeCJEJb0Vh9e.cJfmxamV4XsLUvIG8RkPJheDLm8g8jW', NULL, '2024-11-28 05:27:21', '2024-11-28 05:27:21')


//adproduct-controller
public function addproductitem(Request $request)
{
    $rules = [
        'title' => 'required',
        'price' => 'required',
        'track_qty' => 'required|in:Yes,No',
        'category' => 'required|numeric',
        'sub_category' => 'required|numeric',
    ];

    if ($request->track_qty === 'Yes') {
        $rules['qty'] = 'required|numeric';
    }

    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'errors' => $validator->errors(),
        ]);
    }

    try {
        $product = new Product();
        $product->fill($request->only([
            'title', 'description', 'price', 'compare_price', 'sku', 'barcode',
            'track_qty', 'qty', 'uom', 'category', 'sub_category',
        ]));
        $product->sku = $request->sku ?? 'CHEFS-' . strtoupper(Str::random(3) . mt_rand(100, 999));
        $product->is_featured = $request->is_featured ?? '';
        $product->save();

        // Handle Gallery Images
        if (!empty($request->image_array)) {
            foreach ($request->image_array as $temp_image_id) {
                $tempImageInfo = TempImage::find($temp_image_id);
                if (!$tempImageInfo) continue; // Skip invalid IDs

                $extImage = pathinfo($tempImageInfo->name, PATHINFO_EXTENSION);
                $productImage = new ProductImage([
                    'product_id' => $product->id,
                    'image' => 'NULL',
                ]);
                $productImage->save();

                $imageName = "{$product->id}-{$productImage->id}-" . time() . ".{$extImage}";
                $productImage->image = $imageName;
                $productImage->save();

                $this->resizeAndSaveImage($tempImageInfo->name, $imageName);
            }
        }

        $request->session()->flash('success', 'Product added.');
        return response()->json([
            'status' => true,
            'message' => 'Product added.',
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => false,
            'message' => 'Error adding product: ' . $e->getMessage(),
        ]);
    }
}

// Helper Method for Image Resizing
protected function resizeAndSaveImage($sourceImage, $imageName)
{
    $sPath = public_path("/temp/{$sourceImage}");
    $largePath = public_path("/uploads/product/large/{$imageName}");
    $smallPath = public_path("/uploads/product/small/{$imageName}");

    $image = Image::read($sPath);
    $image->resize(800, 600)->save($largePath);
    $image->resize(69, 52)->save($smallPath);
}
