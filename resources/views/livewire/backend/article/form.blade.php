<div>
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
            <x-backend.form.label :required="true">Title</x-backend.form.label>
            <x-backend.form.input type="text" name="heading"
                                  required
                                  class="w-full"
                                  name="articleData.heading"
                                  wire:model.live.debounce.500ms="articleData.heading"
                                  aria-label="Heading"
                                  placeholder="Heading..."/>
        </div>

        <div class="mb-3">
            <x-backend.form.label :required="true">Slug</x-backend.form.label>
            <x-backend.form.input type="text" name="slug"
                                  required
                                  class="w-full"
                                  name="articleData.slug"
                                  wire:model="articleData.slug"
                                  aria-label="slug"
                                  placeholder="Slug..."/>
        </div>

        <div class="mb-3">
            <x-backend.form.label :required="true">Content</x-backend.form.label>
            <x-backend.form.textarea class="w-full" required
                                     name="articleData.content"
                                     wire:model="articleData.content"
                                     aria-label="Content" rows="35"
                                     placeholder="Content"></x-backend.form.textarea>
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
