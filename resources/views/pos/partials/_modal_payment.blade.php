<div id="paymentModal" class="fixed inset-0 bg-black/50 hidden items-start justify-center pt-12 z-50 p-4">
    <div class="bg-white rounded-xl w-full max-w-2xl overflow-hidden shadow-2xl">

        <!-- Header -->
        <div class="flex justify-between items-center px-5 py-3 border-b bg-gray-50">
            <h2 class="text-lg font-bold text-gray-800">ការទូទាត់ / Payment</h2>
            <button type="button" id="closePaymentModal"
                class="text-gray-400 hover:text-red-500 font-bold text-xl cursor-pointer transition">✕</button>
        </div>

        <!-- Body -->
        <div class="p-5 space-y-4 max-h-[75vh] overflow-y-auto">

            <!-- Total Summary Card -->
            <div class="bg-gray-100 rounded-lg p-3 flex justify-between items-center border">
                <div>
                    <span class="text-xs text-gray-500 font-medium block">ប្រាក់សរុប / Total Due</span>
                    <span class="font-bold text-xl text-gray-900" id="paymentTotal">$0.000</span>
                </div>
                <div class="text-right">
                    <span class="text-xs text-gray-500 font-medium block">ប្រាក់រៀល / Total KHR</span>
                    <span class="font-bold text-lg text-gray-700" id="paymentTotalKHR">៛0</span>
                </div>
            </div>

            <!-- Grid Settings for Compact Two-Column Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Left Column: Discount & Currency -->
                <div class="space-y-3">
                    <!-- Discount Section -->
                    <div class="border rounded-lg p-3 bg-gray-50/50">
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-xs font-bold text-gray-700">បញ្ចុះតម្លៃ / Discount</label>
                            <span class="text-xs font-bold text-red-600" id="discountDisplay">$0.000</span>
                        </div>

                        <div class="grid grid-cols-2 gap-1.5 mb-2">
                            <button type="button"
                                class="discount-type main-bg text-white rounded py-1.5 text-xs font-semibold cursor-pointer transition"
                                data-type="amount">💲 Amount</button>
                            <button type="button"
                                class="discount-type border bg-white rounded py-1.5 text-xs font-semibold cursor-pointer transition text-gray-600"
                                data-type="percent">% Percent</button>
                        </div>
                        <input type="hidden" id="discountType" value="amount">

                        <input type="number" id="discountValue" step="0.001" min="0" value="0.000"
                            class="w-full border rounded px-2.5 py-1.5 text-sm bg-white focus:outline-none focus:ring-1 focus:ring-amber-500"
                            placeholder="0.000">

                        <div class="grid grid-cols-5 gap-1 mt-2">
                            <button type="button"
                                class="discount-preset border bg-white rounded py-1 text-xs cursor-pointer hover:bg-gray-100"
                                data-type="percent" data-value="5">5%</button>
                            <button type="button"
                                class="discount-preset border bg-white rounded py-1 text-xs cursor-pointer hover:bg-gray-100"
                                data-type="percent" data-value="10">10%</button>
                            <button type="button"
                                class="discount-preset border bg-white rounded py-1 text-xs cursor-pointer hover:bg-gray-100"
                                data-type="percent" data-value="15">15%</button>
                            <button type="button"
                                class="discount-preset border bg-white rounded py-1 text-xs cursor-pointer hover:bg-gray-100"
                                data-type="percent" data-value="20">20%</button>
                            <button type="button"
                                class="discount-preset border bg-white rounded py-1 text-xs text-red-600 cursor-pointer hover:bg-red-50"
                                data-type="amount" data-value="0">Clear</button>
                        </div>
                    </div>

                    <!-- Currency Toggle -->
                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1">រូបិយប័ណ្ណ / Currency</label>
                        <div class="grid grid-cols-2 gap-1.5">
                            <button type="button"
                                class="receive-currency border rounded py-2 main-bg text-white text-xs font-bold cursor-pointer transition"
                                data-currency="USD">$ USD</button>
                            <button type="button"
                                class="receive-currency border bg-white rounded py-2 text-xs font-bold text-gray-600 cursor-pointer transition"
                                data-currency="KHR">៛ KHR</button>
                        </div>
                        <input type="hidden" id="receiveCurrency" value="USD">
                    </div>
                </div>

                <!-- Right Column: Received, Change & Method -->
                <div class="space-y-3 flex flex-col justify-between">
                    <div class="space-y-3">
                        <!-- Received Amount -->
                        <div id="cashFields">
                            <div class="flex justify-between items-center mb-1">
                                <label class="text-xs font-bold text-gray-700">បានទទួល / Received</label>
                                <span class="text-xs text-gray-500" id="receivedDisplay">៛0</span>
                            </div>
                            <input type="number" id="receivedAmount" step="0.001"
                                class="w-full border rounded px-3 py-2 text-lg font-semibold bg-white focus:outline-none focus:ring-1 focus:ring-amber-500"
                                placeholder="0.000">
                        </div>

                        <!-- Change Box -->
                        <div
                            class="bg-emerald-50 rounded-lg p-3 border border-emerald-100 flex justify-between items-center">
                            <div>
                                <span class="text-xs text-emerald-700 font-medium block">លុយអាប់ / Change</span>
                                <span class="font-bold text-lg text-emerald-800" id="changeAmount">$0.000</span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-emerald-600 block" id="changeAmountKHR">៛0</span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div>
                        <label class="text-xs font-bold text-gray-700 block mb-1">វិធីទូទាត់ / Method</label>
                        <div class="grid grid-cols-2 gap-1.5">
                            <button type="button"
                                class="payment-method border rounded py-2 text-xs font-bold cursor-pointer main-bg text-white transition"
                                data-method="cash">💵 Cash</button>
                            <button type="button" id="btn-transfer"
                                class="payment-method border bg-white rounded py-2 text-xs font-bold text-gray-700 cursor-pointer transition"
                                data-method="transfer">🏦 Transfer</button>
                        </div>
                        <input type="hidden" id="paymentMethod" value="cash">
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Buttons -->
        <div class="flex gap-2 px-5 py-3 border-t bg-gray-50">
            <button type="button" id="cancelPayment"
                class="flex-1 border bg-white hover:bg-gray-100 text-gray-700 rounded py-2 text-sm font-semibold cursor-pointer transition">បោះបង់
                / Cancel</button>
            <button type="button" id="completeOrder"
                class="flex-1 main-bg text-white rounded py-2 text-sm font-semibold cursor-pointer shadow-sm transition">យល់ព្រម
                / OK</button>
        </div>
    </div>
</div>
