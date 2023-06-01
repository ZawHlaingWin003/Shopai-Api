<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Foldsack No.1 Backpack, Fits 15" Laptops',
            'slug' => str()->slug('Foldsack No. 1 Backpack, Fits 15" Laptops'),
            'description' => 'Your perfect pack for everyday use and walks in the forest. Stash your laptop (up to 15 inches) in the padded sleeve, your everyday.',
            'price' => 55.90,
            'discount_percentage' => 0,
            'quantity' => 30,
            'category_id' => 1,
            'sub_category_id' => 4
        ]);
        Media::create([
            'filepath' => str()->slug('Foldsack No. 1 Backpack, Fits 15" Laptops') . '/images/' . 'product5.png',
            'filetype' => 'png',
            'filesize' => '1.8',
            'mediable_id' => 1,
            'mediable_type' => Product::class
        ]);

        Product::create([
            'name' => 'Mens Casual Premium Slim Fit T-Shirts',
            'slug' => str()->slug('Mens Casual Premium Slim Fit T-Shirts'),
            'description' => 'Slim-fitting style, contrast raglan long sleeve, three-button henley placket, light weight & soft fabric for breathable and comfortable wearing. And Solid stitched shirts with round neck made for durability and a great fit for casual fashion wear and diehard baseball fans.',
            'price' => 55,
            'discount_percentage' => 3,
            'discount_price' => number_format(55 * (1 - 3 / 100), 2, '.', ''),
            'quantity' => 100,
            'category_id' => 1,
            'sub_category_id' => 1
        ]);
        Media::create([
            'filepath' => str()->slug('Mens Casual Premium Slim Fit T-Shirts') . '/images/' . 'shirt4.png',
            'filetype' => 'png',
            'filesize' => '1.2',
            'mediable_id' => 2,
            'mediable_type' => Product::class
        ]);

        Product::create([
            'name' => 'WD 2TB Elements Portable External Hard Drive',
            'slug' => str()->slug('WD 2TB Elements Portable External Hard Drive'),
            'description' => 'USB 3.0 and USB 2.0 Compatibility Fast data transfers Improve PC Performance High Capacity; Compatibility Formatted NTFS for Windows 10, Windows 8.1, Windows 7; Reformatting may be required for other operating systems; Compatibility may vary depending on user’s hardware configuration and operating system.',
            'price' => 85.99,
            'discount_percentage' => 10,
            'quantity' => 10,
            'discount_price' => number_format(85.99 * (1 - 10 / 100), 2, '.', ''),
            'category_id' => 3,
            'sub_category_id' => 17
        ]);
        Media::create([
            'filepath' => str()->slug('WD 2TB Elements Portable External Hard Drive') . '/images/' . 'speaker1.png',
            'filetype' => 'png',
            'filesize' => '0.8',
            'mediable_id' => 3,
            'mediable_type' => Product::class
        ]);

        Product::create([
            'name' => 'SanDisk SSD PLUS 1TB Internal SSD',
            'slug' => str()->slug('SanDisk SSD PLUS 1TB Internal SSD'),
            'description' => 'Easy upgrade for faster boot up, shutdown, application load and response (As compared to 5400 RPM SATA 2.5” hard drive; Based on published specifications and internal benchmarking tests using PCMark vantage scores) Boosts burst write performance.',
            'price' => 98,
            'discount_percentage' => 0,
            'quantity' => 50,
            'category_id' => 3,
            'sub_category_id' => 17
        ]);

        Media::create([
            'filepath' => str()->slug('SanDisk SSD PLUS 1TB Internal SSD') . '/images/' . 'keyboard2.png',
            'filetype' => 'png',
            'filesize' => '1.5',
            'mediable_id' => 4,
            'mediable_type' => Product::class
        ]);

        Product::create([
            'name' => 'Samsung 49" 144Hz Curved Gaming Monitor',
            'slug' => str()->slug('Samsung 49" 144Hz Curved Gaming Monitor'),
            'description' => '49 INCH SUPER ULTRAWIDE 32:9 CURVED GAMING MONITOR with dual 27 inch screen side by side QUANTUM DOT (QLED) TECHNOLOGY, HDR support and factory calibration provides stunningly realistic and accurate color and contrast 144HZ HIGH REFRESH RATE and 1ms ultra fast response time work to eliminate motion.',
            'price' => 959.99,
            'discount_percentage' => 15,
            'discount_price' => number_format(959.99 * (1 - 15 / 100), 2, '.', ''),
            'quantity' => 20,
            'category_id' => 3,
            'sub_category_id' => 16
        ]);

        Media::create([
            'filepath' => str()->slug('Samsung 49" 144Hz Curved Gaming Monitor') . '/images/' . 'computer1.png',
            'filetype' => 'png',
            'filesize' => '1.2',
            'mediable_id' => 5,
            'mediable_type' => Product::class
        ]);
    }
}
