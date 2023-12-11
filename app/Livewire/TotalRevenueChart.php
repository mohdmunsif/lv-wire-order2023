<?php

namespace App\Livewire;

use Livewire\Component;

class TotalRevenueChart extends Component
{
    public function render()
    {
        return view('livewire.total-revenue-chart');
    }

    public function update()
    {
        $this->emit('chartUpdate');
    }
}
