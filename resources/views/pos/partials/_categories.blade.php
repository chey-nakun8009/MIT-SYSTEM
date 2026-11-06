<div class="col-md-6 d-flex flex-row gap-1 overflow-x-auto pb-2 align-items-center" id="categoryFilters"
    style="white-space: nowrap;">
    <input type="radio" class="btn-check category-filter" name="cat" id="cat-all" value="" checked>
    <label class="btn btn-outline-accent btn-sm rounded-pill text-nowrap px-3" for="cat-all">ទាំងអស់</label>
    @foreach ($categories as $category)
        <input type="radio" class="btn-check category-filter" name="cat" id="cat-{{ $category->id }}"
            value="{{ $category->id }}">
        <label class="btn btn-outline-accent btn-sm rounded-pill text-nowrap px-3"
            for="cat-{{ $category->id }}">{{ $category->name }}</label>
    @endforeach
</div>
