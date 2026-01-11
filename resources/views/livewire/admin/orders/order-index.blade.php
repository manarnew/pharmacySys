    <div class="max-w-5xl mx-auto">
        <!-- Main Form Container -->
        <div class="bg-white rounded-2xl form-shadow overflow-hidden">
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100 p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">New Optical Order</h2>
                        <p class="text-gray-600 mt-1">Complete patient information and lens specifications</p>
                    </div>
                    <div class="mt-4 md:mt-0 flex items-center space-x-3">
                        <div class="text-sm text-gray-500">
                            <i class="far fa-calendar-alt mr-1"></i>
                            <span id="current-date"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-6 space-y-8">
                <!-- Patient Information Section -->
              <div class="space-y-5">
    <!-- Section Header -->
    <div class="flex items-center">
        <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center mr-4">
            <i class="fas fa-user-injured text-blue-600"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-800">Patient Information</h3>
    </div>

    <!-- Patient Info Grid -->
 <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

    <!-- Invoice No (INPUT) -->
    <div class="bg-white p-4 rounded-lg border border-blue-200">
        <label class="block text-xs font-medium text-gray-500 mb-1">
            Invoice No <span class="text-red-500">*</span>
        </label>
        <div class="relative">
            <input
                type="text"
                placeholder="INV-000123"
                class="w-full text-lg font-semibold text-gray-900 border-gray-300 rounded-lg pl-10 pr-3 py-2
                       focus:border-blue-500 focus:ring-blue-500 transition"
            />
            <i class="fas fa-receipt absolute left-3 top-1/2 -translate-y-1/2 text-blue-500"></i>
        </div>
    </div>

</div>



            <div class="space-y-5">
    <!-- Section Header -->
    <div class="flex items-center">
        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center mr-4">
            <i class="fas fa-glasses text-indigo-600"></i>
        </div>
        <h3 class="text-lg font-semibold text-gray-800">Lens Specifications</h3>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto bg-white rounded-lg shadow border">
        <table class="min-w-full border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Frame</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Index</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Type</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Photo</th>
                    <th class="px-4 py-3 text-sm font-medium text-gray-700">Package</th>
                </tr>
            </thead>

            <tbody>
                <tr class="border-t">
                    <!-- Frame -->
                    <td class="px-4 py-3">
                        <select
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select</option>
                            <option>Dry Root</option>
                            <option>Full Rim</option>
                            <option>Semi-Rimless</option>
                            <option>Rimless</option>
                            <option>Sports</option>
                            <option>Children</option>
                        </select>
                    </td>

                    <!-- Index -->
                    <td class="px-4 py-3">
                        <select
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select</option>
                            <option>1.56</option>
                            <option>1.59 </option>
                            <option>1.67</option>
                            <option>1.74</option>
                        </select>
                    </td>

                    <!-- Type -->
                    <td class="px-4 py-3">
                        <select
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select</option>
                            <option>Single Vision</option>
                            <option>Bifocal</option>
                            <option>Progressive</option>
                            <option>Occupational</option>
                        </select>
                    </td>

                    <!-- Photo -->
                    <td class="px-4 py-3">
                        <select
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select</option>
                            <option>Yes</option>
                            <option>No</option>
                        </select>
                    </td>

                    <!-- Package -->
                    <td class="px-4 py-3">
                        <select
                            class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Select</option>
                            <option>Prime</option>
                            <option>Plus</option>
                            <option>Premium</option>
                            <option>Ultra</option>
                        </select>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

                <!-- Additional Details -->
                <div class="space-y-5">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-amber-100 flex items-center justify-center mr-4">
                            <i class="fas fa-sticky-note text-amber-600"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-800">Additional Details</h3>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes & Special Instructions</label>
                        <div class="relative">
                            <textarea rows="4" class="w-full p-3 border border-gray-300 rounded-lg input-focus focus:border-blue-500 transition" placeholder="Any special requirements, patient preferences, or additional notes..."></textarea>
                            <div class="absolute right-3 top-3 text-gray-400">
                                <i class="fas fa-edit"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Maximum 500 characters</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Send Order To</label>
                        <div class="relative">
                            <select class="w-full p-3 border border-gray-300 rounded-lg appearance-none input-focus focus:border-blue-500 transition bg-white">
                                <option value="" disabled selected>Select destination</option>
                                <option selected>مصنع النور </option>
                                <option>زرقاء اليمامة </option>
                                <option>الدهلوي </option>
                                <option>Express Lab</option>
                            </select>
                            <div class="absolute right-3 top-3 text-gray-400 pointer-events-none">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Estimated delivery: 3-5 business days</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-gray-50 border-t border-gray-200 p-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between">
                    <div class="flex space-x-4">
                        <button class="px-6 py-3 border border-gray-300 rounded-lg font-medium text-gray-700 hover:bg-gray-50 transition flex items-center">
                            <i class="fas fa-times mr-2"></i>
                            Cancel
                        </button>
                        <button class="px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-indigo-700 transition flex items-center shadow-md hover:shadow-lg">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Send Order
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Set current date
        const now = new Date();
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        document.getElementById('current-date').textContent = now.toLocaleDateString('en-US', options);
        
        // Auto-generate invoice number
        const invoiceInput = document.querySelector('input[placeholder*="INV-"]');
        const randomInvoice = `INV-${Math.floor(100000 + Math.random() * 900000)}`;
        invoiceInput.value = randomInvoice;
        
        // Update last save time
        function updateSaveTime() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
            document.getElementById('last-save-time').textContent = timeString;
        }
        
        // Simulate auto-save every 30 seconds
        setInterval(updateSaveTime, 30000);
        
        // Add input focus effects
        const inputs = document.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-blue-200', 'rounded-lg');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-blue-200', 'rounded-lg');
            });
        });
        
        // Branch info - from auth (simulated)
        console.log("User info loaded from authentication system");
        console.log("Branch: Main Optical Center (auto-detected from user profile)");
    </script>