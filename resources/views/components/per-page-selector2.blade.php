@props(['route'])

<div class="d-flex align-items-center gap-2">
    <label for="per_page" class="text-muted small mb-0">ចំនួនបង្ហាញ</label>
    <select name="per_page" id="per_page" class="form-select form-select-sm rounded-0" style="width: 80px;">
        @foreach ([1, 10, 25, 50, 100] as $limit)
            <option value="{{ $limit }}"
                {{ request('per_page', session('per_page', 10)) == $limit ? 'selected' : '' }}>
                {{ $limit }}
            </option>
        @endforeach
    </select>
    <span class="text-muted small">កំណត់ត្រា</span>
</div>
