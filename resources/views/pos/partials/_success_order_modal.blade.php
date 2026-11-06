<div id="successModal" class="fixed inset-0 bg-black/50 z-50 hidden items-start justify-center pt-12 p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-sm w-full p-5 text-center transform transition-all">

        <!-- Icon -->
        <div
            class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-3 text-xl shadow-sm">
            <i class="bi bi-check-lg font-bold"></i>
        </div>

        <h3 class="text-lg font-bold text-gray-900 mb-0.5">ការទូទាត់បានជោគជ័យ!</h3>
        <p class="text-xs text-gray-500 mb-4">Order completed successfully.</p>

        <!-- Details Card -->
        <div class="bg-gray-50 rounded-lg p-3 mb-4 text-left space-y-1.5 border text-xs">
            <div class="flex justify-between items-center">
                <span class="text-gray-500">លេខវិក្កយបត្រ / Invoice:</span>
                <span id="successInvoiceNo" class="font-bold text-gray-800">ORD-0000</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500">ប្រាក់អាប់ / Change (USD):</span>
                <span id="successChangeUSD" class="font-bold text-green-600">$0.000</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-gray-500">ប្រាក់អាប់ / Change (KHR):</span>
                <span id="successChangeKHR" class="font-bold text-green-600">៛0</span>
            </div>
        </div>

        <div class="flex gap-2">
            <button type="button" id="btnPrintReceipt"
                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 rounded-lg text-xs transition cursor-pointer">
                <i class="bi bi-printer me-1"></i> បោះពុម្ព
            </button>
            <button type="button" id="btnCloseSuccessModal"
                class="flex-1 main-bg text-white font-semibold py-2 rounded-lg text-xs transition shadow-sm cursor-pointer">
                បន្តលក់
            </button>
        </div>
    </div>
</div>
