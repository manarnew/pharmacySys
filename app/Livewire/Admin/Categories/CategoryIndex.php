<?php

namespace App\Livewire\Admin\Categories;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Category;
use Livewire\WithPagination;

class CategoryIndex extends Component
{
    use WithPagination;

    public $name, $description, $status = 'active';
    public $category_id;
    public $isEditing = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'status' => 'required|string',
    ];

    public function resetFields()
    {
        $this->reset(['name', 'description', 'status', 'category_id', 'isEditing']);
        $this->status = 'active';
    }

    public function openModal()
    {
        $this->resetFields();
    }

    public function store()
    {
        $this->validate();

        Category::create([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
        ]);

        $this->dispatch('category-saved', 'Category created successfully!');
        $this->resetFields();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->category_id = $id;
        $this->name = $category->name;
        $this->description = $category->description;
        $this->status = $category->status;
        $this->isEditing = true;

        $this->dispatch('open-edit-modal');
    }

    public function update()
    {
        $this->validate();

        if ($this->category_id) {
            $category = Category::findOrFail($this->category_id);
            $category->update([
                'name' => $this->name,
                'description' => $this->description,
                'status' => $this->status,
            ]);

            $this->dispatch('category-saved', 'Category updated successfully!');
            $this->resetFields();
        }
    }

    public function delete($id)
    {
        Category::findOrFail($id)->delete();
        $this->dispatch('category-deleted', 'Category deleted successfully!');
    }

    #[Layout('layouts.admin')]
    public function render()
    {
        $categories = Category::latest()->get();
        return view('livewire.admin.categories.category-index', compact('categories'));
    }
}
