<div>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $editing ? 'Edit ' . $product->name : 'Create Product' }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <form wire:submit.prevent="save">
                        @csrf

                        <div>
                            <x-label for="name" :value="__('Name')" />

                            <x-input wire:model.defer="product.name" id="name" class="block mt-1 w-full" type="text" />
                            @error('product.name')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-label for="description" :value="__('Description')" />

                            <div wire:ignore>
                                <textarea wire:model.defer="product.description" data-description="@this" id="description" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{!! $product->description !!}</textarea>
                            </div>
                            @error('product.description')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-label for="price" :value="__('Price')" />

                            <x-input wire:model.defer="product.price" type="number" min="0" step="0.01" class="block mt-1 w-full" id="price" />
                            @error('product.price')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-label class="mb-1" for="categories" :value="__('Categories')" />

                            <x-select2 class="mt-1" id="categories" name="categories" :options="$this->listsForFields['categories']" wire:model="categories" multiple />
                            @error('categories')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-label class="mb-1" for="country" :value="__('Country')" />

                            <x-select2 class="mt-1" id="country" name="country" :options="$this->listsForFields['countries']" wire:model="product.country_id" />
                            @error('product.country_id')
                                <span class="text-sm text-red-500">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <x-button type="submit">
                                Save
                            </x-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/ckeditor.js"></script>
    <script>
        var ready = (callback) => {
            if (document.readyState != "loading") callback();
            else document.addEventListener("DOMContentLoaded", callback);
        }
        ready(() =>{
            ClassicEditor
                .create(document.querySelector('#description'))
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set('product.description', editor.getData());
                    })
                    Livewire.on('reinit', () => {
                        editor.setData('', '')
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        })
    </script>
@endpush