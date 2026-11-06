  @forelse ($products as $product)
      <tr data-id="{{ $product->id }}">
          <td>
              <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}"
                  style="width: 45px; height: 45px; object-fit: cover;" class="rounded-0 border">
          </td>
          <td class="txt-start">
              <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none fw-semibold">
                  {{ $product->name }}
              </a>
          </td>
          <td class="txt-start">
              <span class="text-muted">
                  {{ $product->sku }}
              </span>
          </td>
          <td class="txt-start">
              {{ $product->category?->name ?? '-' }}
          </td>
          <td class="txt-start">
              {{ $product->brand?->name ?? '-' }}
          </td>
          <td class="txt-center">
              @if ($product->type === 'glass')
                  <span class="badge bg-info rounded-0">
                      {{ __('product.glass') }}
                  </span>
              @else
                  <span class="badge bg-secondary rounded-0">
                      {{ __('product.standard') }}
                  </span>
              @endif
          </td>
          <td class="txt-center">
              @if ($product->is_active)
                  <span class="badge bg-success rounded-0">
                      {{ __('product.active') }}
                  </span>
              @else
                  <span class="badge bg-secondary rounded-0">
                      {{ __('product.inactive') }}
                  </span>
              @endif
          </td>
          <td class="txt-center">
              @php
                  $stockQty = $product->total_stock;
              @endphp

              @if ($stockQty > 0)
                  <span class="text-success fw-bold">
                      {{ number_format($stockQty, 2) }} {{ $product->baseUnit->symbol ?? '' }}
                  </span>
              @else
                  <span class="text-danger">
                      អស់ស្តុក
                  </span>
              @endif
          </td>
          <td class="text-center">

              <div class="d-flex justify-content-center align-items-center gap-1">
                  <a href="{{ route('products.show', [
                      'product' => $product->id,
                      'page' => $products->currentPage(),
                  ]) }}"
                      class="btn btn-sm btn-action" title="{{ __('product.view') }}">
                      <i class="bi bi-eye"></i>
                  </a>
                  <a href="{{ route('products.edit', [
                      'product' => $product->id,
                      'page' => $products->currentPage(),
                  ]) }}"
                      class="btn btn-sm btn-action btn-edit" title="{{ __('product.edit') }}">
                      <x-svg.edit />
                  </a>
                  <button type="button" class="btn btn-sm btn-action btn-delete delete-item"
                      data-id="{{ $product->id }}" data-url="{{ route('products.destroy', $product->id) }}"
                      data-page="{{ $products->currentPage() }}" title="{{ __('product.delete') }}">
                      <x-svg.trash />
                  </button>

              </div>

          </td>

      </tr>

  @empty
      <x-empty-row :colspan="8" />
  @endforelse
