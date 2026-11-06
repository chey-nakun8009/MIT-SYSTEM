@php
    $supplier = $supplier ?? null;
@endphp
<input type="hidden" name="page" value="{{ $page }}">
<div class="row g-3">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-0 mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">
                    <i class="material-icons align-middle me-2 text-danger"></i>
                    Supplier Information
                </h6>
            </div>
            <div class="card-body p-3 p-md-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input name="name" label="Supplier Name" placeholder="Enter supplier name"
                            :value="old('name', $supplier?->name ?? '')" />
                    </div>
                    <div class="col-md-6">
                        <x-input name="company_name" label="Company Name" placeholder="Enter company name"
                            :value="old('company_name', $supplier?->company_name ?? '')" />
                    </div>
                    <div class="col-md-6">
                        <x-input name="phone" label="Phone" type="tel" placeholder="Enter phone number"
                            :value="old('phone', $supplier?->phone ?? '')" />
                    </div>
                    <div class="col-md-6">
                        <x-input name="email" label="Email" type="email" placeholder="Enter email address"
                            :value="old('email', $supplier?->email ?? '')" />
                    </div>
                    <div class="col-12">
                        <x-input name="tax_number" label="Tax Number" placeholder="Enter tax number"
                            :value="old('tax_number', $supplier?->tax_number ?? '')" />
                    </div>
                    <div class="col-12">
                        <x-textarea name="address" label="Address" placeholder="Enter supplier address..."
                            :value="old('address', $supplier?->address ?? '')" rows="3" />
                    </div>
                    <div class="col-12">
                        <x-textarea name="notes" label="Notes" placeholder="Enter notes..." :value="old('notes', $supplier?->notes ?? '')"
                            rows="4" />
                    </div>
                    <div class="col-12">
                        <label class="form-label d-block">
                            Status
                        </label>
                        <div class="form-check form-switch">
                            <input type="checkbox" name="is_active" value="1" class="form-check-input"
                                id="is_active" @checked(old('is_active', $supplier?->is_active ?? 1) == 1)>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm rounded-0 mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">
                    <i class="material-icons align-middle me-2 text-danger"></i>
                    Supplier Details
                </h6>
            </div>
            <div class="card-body p-3">
                <div class="mb-3">
                    <div class="text-muted small mb-1">
                        Supplier Name
                    </div>
                    <div class="fw-semibold">
                        {{ Str::title($supplier?->name) ?? 'New Supplier' }}
                    </div>
                </div>
                @if ($supplier)
                    <div class="mb-3">
                        <div class="text-muted small mb-1">
                            Created
                        </div>

                        <div>
                            {{ $supplier->created_at?->format('d M Y, H:i') }}
                        </div>
                    </div>

                    <div>
                        <div class="text-muted small mb-1">
                            Last Updated
                        </div>

                        <div>
                            {{ $supplier->updated_at?->format('d M Y, H:i') }}
                        </div>
                    </div>
                @else
                    <div class="text-muted small">
                        Enter the supplier information and save the form.
                    </div>
                @endif

            </div>
        </div>
        <div class="card border-0 shadow-sm rounded-0">
            <div class="card-header bg-white py-3">
                <h6 class="fw-bold mb-0">
                    Form Actions
                </h6>
            </div>
            <div class="card-body p-3">
                <button type="submit" class="btn btn-primary rounded-0 w-100 mb-2">
                    <i class="material-icons align-middle me-1"></i>
                    {{ $supplier ? 'Update Supplier' : 'Save Supplier' }}
                </button>
                <a href="{{ route('suppliers.index') }}" class="btn btn-secondary rounded-0 w-100">
                    <i class="material-icons align-middle me-1"></i>
                    Cancel
                </a>
            </div>
        </div>
    </div>
</div>
