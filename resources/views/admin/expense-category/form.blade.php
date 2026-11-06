<input type="hidden" name="company_id" value="{{ auth()->user()->company_id }}">
<div class="row">
    <x-form.input name="name" label="ឈ្មោះប្រភេទចំណាយ*" class="col-12 col-md-6 mb-2" :value="old('name', $expenseCategory->name ?? '')"
        placeholder="បញ្ចូលឈ្មោះប្រភេទចំណាយផ្សេងៗ" />

    <x-form.select name="active" label="ស្ថានភាព*" :options="[
        1 => 'សកម្ម',
        0 => 'អសកម្ម',
    ]" :selected="old('active', isset($expenseCategory) ? (int) $expenseCategory->active : 1)" class="col-12 col-md-6 mb-1 mt-0" />
</div>

<div class="d-flex justify-content-end gap-2 mt-4">
    <a href="{{ route('expense-categories.index') }}" class="btn btn-secondary rounded-0 btn-sm">
        បោះបង់ <x-svg.reset />
    </a>
    <button type="submit" class="btn btn-primary rounded-0 btn-sm">
        រក្សាទុក <x-svg.save />
    </button>
</div>
