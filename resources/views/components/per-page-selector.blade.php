 @props(['route'])

 <form method="GET" action="{{ $route }}" class="d-flex align-items-center gap-2">
     <label for="per_page" class="text-muted small mb-0">បង្ហាញ</label>
     <select name="per_page" id="per_page" class="form-select form-select-sm rounded-0" style="width: 80px;"
         onchange="this.form.submit()">
         @foreach ([15, 25, 50, 100] as $limit)
             <option value="{{ $limit }}"
                 {{ request('per_page', session('per_page', 10)) == $limit ? 'selected' : '' }}>
                 {{ $limit }}
             </option>
         @endforeach
     </select>
     <span class="text-muted small">ទិន្នន័យ</span>
 </form>
