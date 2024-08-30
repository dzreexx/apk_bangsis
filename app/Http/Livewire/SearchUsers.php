<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class SearchUsers extends Component
{
    public $search = '';

    public function render()
    {
        $users = User::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('nrp', 'like', '%' . $this->search . '%')
            ->orWhere('satker', 'like', '%' . $this->search . '%')
            ->orWhere('pangkat', 'like', '%' . $this->search . '%')
            ->orWhere('korp', 'like', '%' . $this->search . '%')
            ->get();

        return view('livewire.search-users', [
            'users' => $users,
        ]);
    }
}
