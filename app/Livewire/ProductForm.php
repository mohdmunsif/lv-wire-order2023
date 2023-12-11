<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Country;
use App\Models\Category;

class ProductForm extends Component
{
    public Product $product;

    public bool $editing = false;

    public array $categories = [];

    public array $listsForFields = [];

    public function mount(Product $product)
    {
        $this->product = $product;

        $this->initListsForFields();

        if ($this->product->exists) {
            $this->editing = true;

            $this->product->price = number_format($this->product->price / 100, 2);

            $this->categories = $this->product->categories()->pluck('id')->toArray();
        } else {
            $this->editing = false;
        }
    }

    public function save()
    {
        $this->validate();

        $this->product->price = $this->product->price * 100;

        $this->product->save();

        $this->product->categories()->sync($this->categories);

        return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.product-form');
    }

    protected function rules(): array
    {
        return [
            'product.name' => ['required', 'string'],
            'product.description' => ['required'],
            'product.country_id' => ['required', 'integer', 'exists:countries,id'],
            'product.price' => ['required'],
            'categories' => ['required', 'array']
        ];
    }

    protected function initListsForFields(): void
    {
        $this->listsForFields['countries'] = Country::pluck('name', 'id')->toArray();
        // dd($this->listsForFields['countries'] );
        $this->listsForFields['categories'] = Category::active()->pluck('name', 'id')->toArray();
    }
}
