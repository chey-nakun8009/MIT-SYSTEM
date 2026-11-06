<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h4 class="mb-1">
                    {{ Str::title($attribute->name) }}
                </h4>
            </div>

            <a href="{{ route('attributes.values.create', [
                'attribute' => $attribute->id,
                'page' => request('page', 1),
            ]) }}"
                class="btn btn-primary rounded-0">
                <i class="bi bi-plus-lg me-1"></i>
                Add Value
            </a>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead>
                    <tr>
                        <th class="col-no">#</th>

                        <th>
                            Value
                        </th>

                        <th class="txt-center">
                            {{ __('attribute.is_active') }}
                        </th>

                        <th class="txt-center">
                            {{ __('attribute.sort_order') }}
                        </th>

                        <th class="col-action">
                            {{ __('attribute.action') }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @include('admin.attribute-value.partials._row')
                </tbody>

            </table>

        </div>

    </div>
</div>
