<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Illuminate\Support\Collection;
use function view;
use App\Livewire\Forms\CategoryForm;
use ArrayObject;

class CategoriesList extends Component
{
    use WithPagination;

    public CategoryForm $form;

    public Category $category;

    public Collection $categories;

    public array $active;

    public int $editedCategoryId = 0;

    public bool $showModal = false;

    protected $listeners = ['delete'];


    public function mount(Category $category)
    {
        $this->form->setCategory($category, $this->editedCategoryId);
    }


    public function render()
    {
        $cats = Category::orderBy('position')->paginate(10);
        $links = $cats->links();
        $this->categories = collect($cats->items());


        $this->active = $this->categories->mapWithKeys(
            fn ($item) => [$item['id'] => (bool) $item['is_active']]
        )->toArray();

        return view('livewire.categories-list', [
            'links' => $links,
        ]);
    }

    public function openModal()
    {
        $this->showModal = true;

        $this->category = new Category();
    }

    public function updatedCategoryName()
    {
        $this->category->slug = Str::slug($this->category->name);
    }

    public function save()
    {
        if ($this->editedCategoryId === 0) {
            $this->form->position = Category::max('position') + 1;
        }

        $this->form->update();

        $this->reset();
    }

    public function toggleIsActive($categoryId)
    {
        Category::where('id', $categoryId)->update([
            'is_active' => $this->active[$categoryId],
        ]);
    }

    public function editCategory($categoryId)
    {
        $this->editedCategoryId = $categoryId;

        $this->category = Category::find($categoryId);
        $this->form->setCategory(Category::find($categoryId),  $this->editedCategoryId);
    }

    public function cancelCategoryEdit()
    {
        $this->reset('editedCategoryId');
    }

    public function deleteConfirm($method, $id = null)
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type'  => 'warning',
            'title' => 'Are you sure?',
            'text'  => '',
            'id'    => $id,
            'method' => $method,
        ]);
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
    }

    public function updateOrder($list)
    {
        foreach ($list as $item) {
            $cat = $this->categories->firstWhere('id', $item['value']);

            if ($cat['position'] != $item['order']) {
                Category::where('id', $item['value'])->update(['position' => $item['order']]);
            }
        }
    }

    protected function rules(): array
    {
        return [
            'category.name'     => ['required', 'string', 'min:3'],
            'category.slug'     => ['nullable', 'string'],
            'category.position' => ['nullable', 'integer'],
        ];
    }
}
