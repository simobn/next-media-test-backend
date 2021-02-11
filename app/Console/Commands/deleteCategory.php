<?php

namespace App\Console\Commands;

use App\Category;
use Illuminate\Console\Command;

class deleteCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:category {category_id}';

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
            'category_id' => $this->argument('category_id'),

        ], [
            'category_id' => ['integer','exists:categories,id'],
        ]);

        //check if errors exists
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }
        else{
            Category::findOrFail($this->argument('category_id'))->delete();
            //inform user that the category is deleted
            $this->info('category deleted successfully');
        }
    }
}
