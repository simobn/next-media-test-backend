<?php

namespace App\Console\Commands;

use App\Product;
use Illuminate\Console\Command;

class createproduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'it will crate a product';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        //ask user for required inputs
        $name = $this->ask('product name?');
        $description = $this->ask('product description?');
        $price = $this->ask('product price?');
        $category_id = $this->ask('product category_id?');
        $image = $this->ask('product image?');

        //validate the inputs
        $validator = \Validator::make([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category_id' => $category_id,
            'image' => $image,
        ], [
            'name' => ['required','min:2'],
            'description' => ['required','min:10'],
            'price' => ['required','regex:/^\d{1,13}(\.\d{1,4})?$/'],
            'category_id' => ['nullable','integer','exists:categories,id'],
            'image' => ['required', 'min:8'],
        ]);
        //check if errors exists
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }
        else{
            Product::create([
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'category_id' => $category_id,
                'image' => $image
            ]);
            //inform user that the producted is created
            $this->info('product created successfully');
        }
    }

}
