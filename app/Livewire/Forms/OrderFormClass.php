<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Order;
// use Illuminate\Support\Collection;


class CategoryForm extends Form
{

    public ?Order $order;
    // public ?Collection $categoryFormData;

    #[Validate('required|min:1')]
    public $id = '';

    #[Validate('required|min:3')]
    public $user_id = '';

    #[Validate('required|min:3')]
    public $order_date = '';

    #[Validate('sometimes|required')]
    public $subtotal = '';

    #[Validate('sometimes|required')]
    public $taxes = '';

    #[Validate('sometimes|required')]
    public $total = '';


    public function setOrder(Order $order)
    {
        $this->order = $order;

        $this->name = $order->name;

        $this->slug = $order->slug;

        $this->is_active = $order->is_active;

        $this->id = $order->id;

        $this->position = $order->position;
    }

    public function store()
    {
        $this->validate();

        Order::create($this->only(['name', 'slug']));
    }


    public function update()
    {

        $this->order->update($this->all());
    }
}
