<div>
    <form wire:submit.prevent="submit">
        <div class="mb-3">
            <x-backend.form.input type="text" name="heading"
                                  required
                                  class="w-full"
                                  name="article.heading"
                                  wire:model.defer="article.heading"
                                  aria-label="Heading"
                                  placeholder="*Heading..."/>
        </div>

        <div class="mb-3">
            <x-backend.form.select name="category" required
                                   wire:model.defer="article.category_id"
                                   aria-label="Category">
                <option value="">*Select Category</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </x-backend.form.select>
        </div>

        <div class="mb-3">
            <x-backend.form.textarea class="w-full" required
                                     name="article.content"
                                     wire:model.defer="article.content"
                                     aria-label="Content" rows="12"
                                     placeholder="*Content"></x-backend.form.textarea>
        </div>

        <div class="mb-3">
            <x-backend.form.input class="w-full"
                                  type="text"
                                  name="article.keywords"
                                  wire:model.defer="article.keywords"
                                  placeholder="Keywords" aria-label="Keywords"/>
        </div>

        <div class="mb-3">
            <x-backend.form.select required
                name="category"
                wire:model.defer="article.language" aria-label="*Language">
                <option value="">*Select Language</option>
                @foreach(config('fields.lang') as $key => $language)
                    <option value="{{$key}}">{{$language}}</option>
                @endforeach
            </x-backend.form.select>
        </div>

        <div class="mb-3">
            <input type="checkbox"
                   name="article.is_comment_enabled"
                   id="is-comment-enabled"
                   wire:model.defer="article.is_comment_enabled"
                   aria-label="Comment Enable">
            <label for="is-comment-enabled">Comment enable</label>
        </div>

        <x-backend.form.button>Submit</x-backend.form.button>
    </form>
</div>
