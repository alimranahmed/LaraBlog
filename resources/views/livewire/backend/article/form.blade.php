<div x-data="{ editor_functions: { photo: false, preview: false } }">
    <form wire:submit.prevent="submit">
        <div class="mb-3">
            <x-backend.form.label :required="true">Language</x-backend.form.label>
            <x-backend.form.select required
                                   name="language"
                                   class="w-1/3"
                                   wire:model.live="articleData.language" aria-label="Language">
                <option value="">Select Language</option>
                @foreach(config('fields.lang') as $key => $language)
                    <option value="{{$key}}">{{$language}}</option>
                @endforeach
            </x-backend.form.select>
        </div>

        <div class="mb-3">
            <x-backend.form.label :required="true">Title</x-backend.form.label>
            <x-backend.form.input type="text" name="heading"
                                  required
                                  class="w-full"
                                  name="articleData.heading"
                                  wire:model.live.debounce.500ms="articleData.heading"
                                  aria-label="Heading"
                                  placeholder="Heading..."/>
        </div>

        <div class="mb-5">
            <x-backend.form.label :required="true">Slug</x-backend.form.label>
            <x-backend.form.input type="text" name="slug"
                                  required
                                  class="w-full"
                                  name="articleData.slug"
                                  wire:model="articleData.slug"
                                  aria-label="slug"
                                  placeholder="Slug..."/>
        </div>

        <div class="mb-3"
             style="display: none"
             x-show="editor_functions.photo"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-90"
             x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100"
             x-transition:leave-end="opacity-0 transform scale-90"
        >
            <livewire:backend.article.image-form/>
        </div>

        <div class="mb-3">
            <x-backend.form.label :required="true">Content</x-backend.form.label>

            <!-- Editor Control: Preview and Photo -->
            <div>
                <div @click="editor_functions.photo = !editor_functions.photo"
                     class="inline text-xs py-1 px-1 rounded-tl cursor-pointer bg-indigo-300 text-slate-600 hover:text-slate-800 hover:bg-indigo-400"
                >Photo</div>

                <div @click="editor_functions.preview = !editor_functions.preview"
                     class="inline text-xs py-1 px-1 rounded-tr cursor-pointer bg-indigo-300 text-slate-600 hover:text-slate-800 hover:bg-indigo-400"
                >
                    <span x-text="editor_functions.preview ? 'Edit' : 'Preview'">Preview</span>
                </div>
            </div>

            <x-backend.form.textarea class="w-full border-x-0 border-y outline-none"
                                     :rounded="false"
                                     required
                                     name="articleData.content"
                                     wire:model.live.debounce.1500ms="articleData.content"
                                     x-show="!editor_functions.preview"
                                     aria-label="Content"
                                     rows="35"
                                     placeholder="Write your article here..."></x-backend.form.textarea>

            <!-- Content Preview -->
            <div class="border border-indigo-300 w-full border-x-0 border-y"
                 x-show="editor_functions.preview"
                 style="display: none">
                <div class="max-w-2xl mx-auto px-5 py-5">
                    <h1 class="sm:text-xl md:text-2xl mb-3 leading-tight">
                        {{$articleData['heading'] ?? ''}}
                    </h1>
                    <div class="text-sm leading-relaxed md:text-lg article-content">
                        {!! $contentPreview !!}
                    </div>
                </div>
            </div>

        </div>

        <div class="mb-3 p-3 border rounded-md">
            <div class="text-center underline underline-offset-2">Social Meta</div>
            <div class="mb-2">
                <x-backend.form.label>Description</x-backend.form.label>
                <x-backend.form.textarea
                    class="w-full"
                    wire:model="articleData.meta.description"
                    name="articleData.meta.description"
                    placeholder="Description for Social Media/SEO"/>
            </div>
            <div class="mb-2">
                <x-backend.form.label>Image URL</x-backend.form.label>
                <x-backend.form.input
                    class="w-full"
                    wire:model="articleData.meta.image_url"
                    name="articleData.meta.image_url"
                    placeholder="URL for image of social media thumbnail"/>
            </div>
        </div>

        <div class="mb-3">
            <x-backend.form.label :required="true">Category</x-backend.form.label>
            <x-backend.form.select name="category" required
                                   wire:model="articleData.category_id"
                                   class="w-1/3"
                                   aria-label="Category">
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </x-backend.form.select>
        </div>

        <div class="mb-3">
            <x-backend.form.label>Keywords</x-backend.form.label>
            @forelse($this->getKeywords() as $keyword)
                <x-status state="neutral" :text="$keyword" class="ml-1 py-1"></x-status>
            @empty

            @endforelse
            <x-backend.form.input class="w-full mt-2"
                                  type="text"
                                  name="articleData.keywords"
                                  wire:model.live.debounce.500ms="articleData.keywords"
                                  placeholder="Keywords" aria-label="Keywords"/>
            <span class="text-sm italic text-gray-500">*Separate the keywords using space</span>
        </div>

        <div class="mb-3">
            <input type="checkbox"
                   name="articleData.is_comment_enabled"
                   id="is-comment-enabled"
                   wire:model="articleData.is_comment_enabled"
                   aria-label="Comment Enable">
            <x-backend.form.label for="is-comment-enabled">Comment enable</x-backend.form.label>
        </div>

        <x-backend.form.button>Submit</x-backend.form.button>
    </form>
</div>
