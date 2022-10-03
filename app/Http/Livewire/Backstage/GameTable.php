<?php

namespace App\Http\Livewire\Backstage;

use App\Models\Game;

class GameTable extends TableComponent
{
    public $sortField = 'revealed_at';

    public function render()
    {
        $columns = [
            [
                'title' => 'account',
                'sort' => true,
            ],

            [
                'title' => 'prize_id',
                'attribute' => 'prize_id',
                'sort' => true,
            ],

            [
                'title' => 'title',
                'attribute' => 'title',
                'sort' => true,
            ],

            [
                'title' => 'revealed at',
                'attribute' => 'revealed_at',
                'sort' => true,
            ],
        ];

        return view('livewire.backstage.table', [
            'columns' => $columns,
            'resource' => 'games',
            'rows' => Game::filter()
                ->orderBy($this->sortField, $this->sortAsc ? 'DESC' : 'ASC')
                ->paginate($this->perPage),
        ]);
    }
}