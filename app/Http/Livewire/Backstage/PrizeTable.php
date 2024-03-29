<?php

namespace App\Http\Livewire\Backstage;

use App\Models\Prize;

class PrizeTable extends TableComponent
{
    public $sortField = 'name';

    public function render()
    {
        $columns = [
            [
                'title' => 'name',
                'sort' => true,
            ],

            [
                'title' => 'title',
                'sort' => true,
            ],

            [
                'title' => 'level',
                'sort' => true,
            ],

            [
                'title' => 'weight',
                'sort' => true,
            ],

            [
                'title' => 'startDate',
                'attribute' => 'starts_at',
                'sort' => true,
            ],

            [
                'title' => 'endDate',
                'attribute' => 'ends_at',
                'sort' => true,
            ],
        ];

        if (request()->user()->isAdmin()) {
            $columns[] = [
                'title' => 'tools',
                'sort' => false,
                'tools' => ['show', 'edit', 'delete'],
            ];
        }

        return view('livewire.backstage.table', [
            'columns' => $columns,
            'resource' => 'prizes',
            'rows' => Prize::search($this->search)
                ->where('campaign_id', session('activeCampaign'))
                ->orderBy($this->sortField, $this->sortAsc ? 'DESC' : 'ASC')
                ->paginate($this->perPage),
        ]);
    }
}
