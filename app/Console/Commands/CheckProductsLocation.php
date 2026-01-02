<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class CheckProductsLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-products-location';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check which products have location data set';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $total = Product::count();
        $withVille = Product::whereNotNull('ville_id')->count();
        $withCommune = Product::whereNotNull('commune_id')->count();
        $withBoth = Product::whereNotNull('ville_id')->whereNotNull('commune_id')->count();

        $this->info("Total products: $total");
        $this->info("Products with ville_id: $withVille");
        $this->info("Products with commune_id: $withCommune");
        $this->info("Products with both ville_id and commune_id: $withBoth");

        if ($withBoth < $total) {
            $this->warn("Some products are missing location data. This may cause search issues.");
        }
    }
}
