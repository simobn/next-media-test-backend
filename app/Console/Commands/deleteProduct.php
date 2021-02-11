<?php

namespace App\Console\Commands;

use App\Product;
use Illuminate\Console\Command;

class deleteProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:product {product_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //validate the inputs
        $validator = \Validator::make([
            'product_id' => $this->argument('product_id'),

        ], [
            'product_id' => ['integer','exists:products,id'],
        ]);

        //check if errors exists
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }
        else{
            Product::findOrFail($this->argument('product_id'))->delete();
            //inform user that the category is deleted
            $this->info('category deleted successfully');
        }
    }
}
