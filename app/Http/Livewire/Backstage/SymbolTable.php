<?php

namespace App\Http\Livewire\Backstage;

use Livewire\WithFileUploads;
use Livewire\Component;
use App\Models\Symbol;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;

class SymbolTable extends TableComponent
{
    use WithFileUploads, WithPagination;

    protected $listeners = ['delete'];

    public $sortField = 'created_at';

    public $photo;

    public $point_3;

    public $point_4;

    public $point_5;

    public function save()
    {
        $this->validate([
            'photo' => 'image',
            'point_3' => 'required|integer',
            'point_4' => 'required|integer',
            'point_5' => 'required|integer',
        ]);

        $file = $this->photo->store('images', 'public');

        Symbol::create([
            'user_id'=>request()->user()->id,
            'image'=>$file,
            "points"=>[
                "three"=>$this->point_3,"four"=>$this->point_4,"five"=>$this->point_5,
            ]
            ]);

        $this->photo = null;
        $this->point_3 = null;
        $this->point_4 = null;
        $this->point_5 = null;
    }

    public function delete($id)
    {
        $symbol = Symbol::where('id', $id)->first();

        Storage::delete('storage/'.$symbol->image, 'public');
        $symbol->delete();
    }

    public function render()
    {
        return view('livewire.backstage.symbol-table', [
            'result' => Symbol::orderBy($this->sortField, $this->sortAsc ? 'DESC' : 'ASC')
                ->paginate(15),
        ])->extends('backstage.templates.backstage');
    }
}
