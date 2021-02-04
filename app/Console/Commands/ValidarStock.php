<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libros;
use Illuminate\Support\Facades\Mail;
use App\Mail\ValidarStockMail;

class ValidarStock extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'validar:stock';

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
        $books = Libros::all();

        foreach($books as $book){
            if($book->Stock <= 10){
                Mail::to('delaserna@multiversolibreria.com')->send(new ValidarStockMail($book));
            }
        }
    }
}
