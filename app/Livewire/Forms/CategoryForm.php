<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use App\Models\Category;


class CategoryForm extends Form
{

    public ?Category $category;

    #[Validate('required|min:1')]
    public $id = '';

    #[Validate('required|min:3')]
    public $name = '';

    #[Validate('required|min:3')]
    public $slug = '';

    #[Validate('sometimes|required')]
    public $is_active = '';

    #[Validate('sometimes|required')]
    public $position = '';


    public function setCategory(Category $category, $selCategoryId)
    {
        $this->category = $category;

        $this->name = $category->name;

        $this->slug = $category->slug;

        $this->is_active = $category->is_active;

        $this->id = $category->id;

        $this->position = $category->position;

        if ($selCategoryId === 0) {
            $this->position = Category::max('position') + 1;
        }
    }


    public function store()
    {
        $this->validate();

        Category::create($this->only(['name', 'slug']));
    }


    public function update()
    {
        $this->category->update($this->all());
    }
}
