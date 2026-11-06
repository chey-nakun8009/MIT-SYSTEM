<div class="row g-2 mb-3 d-flex justify-content-between align-items-center">
    <div class="col-md-4">
        <x-form.select name="unit_ids[]" label="Unit" :options="$units" />
    </div>
    <div class="col-md-3">
        <x-form.input name="factors[]" label="Factor" placeholder="e.g. 24" />
    </div>
    <div class="col-md-4">
        <x-form.input name="barcodes[]" label="Barcode" placeholder="Scan barcode" />
    </div>
    <div class="col-md-1 pb-2">
        <button type="button" class="btn mt-4 text-danger btn-outline-danger py-2" @click="$el.closest('.row').remove()">
            <x-icons.trash />
        </button>
    </div>
</div>
