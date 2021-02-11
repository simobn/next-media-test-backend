<?php

namespace App\Console\Commands;

use App\Category;
use Illuminate\Console\Command;

class createCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:category';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command to create a category using command line';

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
        $name = $this->ask('category name?');
        $parent_id = $this->ask('category parent_id?');

        $validator = \Validator::make([
            'name' => $name,
            'parent_id' => $parent_id
        ], [
            'name' => ['required','min:2'],
            'parent_id' => ['nullable','integer','exists:categories,id'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }
        else{
            Category::create([
                'name' => $name,
                'parent_id' => $parent_id,
            ]);
            $this->info('category created successfully');
        }
    }
}
