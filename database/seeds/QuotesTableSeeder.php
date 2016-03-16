<?php

use Illuminate\Database\Seeder;

class QuotesTableSeeder extends Seeder
{
    public function run()
    {
        app('db')->table('quotes')->insert([
            [
                'phrase' => 'When there is no desire, all things are at peace.',
                'author' => 'Laozi'
            ],
            [
                'phrase' => 'Simplicity is the ultimate sophistication.',
                'author' => 'Leonardo da Vinci'
            ],
            [
                'phrase' => 'Simplicity is the essence of happiness.',
                'author' => 'Cedric Bledsoe'
            ],
            [
                'phrase' => 'Smile, breathe, and go slowly.',
                'author' => 'Thich Nhat Hanh'
            ],
            [
                'phrase' => 'Simplicity is an acquired taste.',
                'author' => 'Katharine Gerould'
            ],
            [
                'phrase' => 'Well begun is half done.',
                'author' => 'Aristotle'
            ],
            [
                'phrase' => 'He who is contented is rich.',
                'author' => 'Laozi'
            ],
            [
                'phrase' => 'Very little is needed to make a happy life.',
                'author' => 'Marcus Antoninus'
            ],
        ]);
    }
}
