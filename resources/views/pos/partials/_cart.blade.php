 <div class="col-lg-4 col-xl-4 d-flex flex-column h-100 p-3 bg-light">
     <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
         <h5 class="fw-bold mb-0"><i class="bi bi-cart3 me-1"></i>ការកម្ម៉ង់</h5>
         <button class="btn btn-sm btn-danger rounded-0" id="btnClearCart">
             <i class="bi bi-trash"></i>ដកទំនិញចេញទាំងអស់
         </button>
     </div>

     <div class="mb-2">
         <select class="form-select form-select-sm" id="customerSelect">
             <option value="walkin" selected>អតិថិជនទូទៅ</option>
             <option value="vip">VIP Member</option>
         </select>
     </div>

     <div class="cart-table-wrapper flex-grow-1 bg-white border rounded mb-3">
         <table class="table table-hover align-middle mb-0" id="cartTable">
             <thead class="table-light sticky-top">
                 <tr class="small">
                     <th>ទំនិញ</th>
                     <th class="text-center" style="width: 90px;">ចំនួន</th>
                     <th class="text-end" style="width: 100px;">តម្លៃរាយ</th>
                     <th class="text-end" style="width: 110px;">សរុប</th>
                     <th></th>
                 </tr>
             </thead>
             <tbody id="cartBody">
                 <tr id="emptyCartRow">
                     <td colspan="5" class="text-center text-muted py-4">
                         <i class="bi bi-basket fs-3 d-block mb-1"></i>
                         មិនមានទំនិញក្នុងកន្ទ្រក់នៅឡើយ
                     </td>
                 </tr>
             </tbody>
         </table>
     </div>

     <div class="card border-0 shadow-sm p-3 mb-3">
         <div class="d-flex justify-content-between mb-1">
             <span class="text-muted">ទឹកលុយសរុស:</span>
             <span class="fw-bold" id="subtotalAmount">$0.00</span>
         </div>
         <hr class="my-2">
         <div class="d-flex justify-content-between align-items-center">
             <span class="fw-bold fs-5">សរុបដុល្លា:</span>
             <span class="fw-bold fs-4 text-success" id="totalUSD">$0.00</span>
         </div>
         <div class="d-flex justify-content-between align-items-center">
             <span class="text-muted small">សរុបរៀល (4,000៛/$):</span>
             <span class="fw-bold text-secondary" id="totalKHR">0 ៛</span>
         </div>
     </div>
     <div class="col-12">
         <button class="btn w-100 py-2 fw-bold shadow-sm rounded-0 btn-primary" id="btnPay" disabled>
             <i class="bi bi-credit-card me-1"></i>បង់ប្រាក់
         </button>
     </div>
 </div>
