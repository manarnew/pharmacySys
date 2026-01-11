<div class="space-y-6">
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Messages</h1>
        <p class="mt-1 text-sm text-gray-500">Send SMS messages to patients, doctors, or specific numbers.</p>
    </div>

    <!-- Send Message Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6" x-data="{ recipientType: 'patients' }">
        <h2 class="text-lg font-medium text-gray-900 mb-4">New Message</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-4">
                <!-- Recipient Type -->
                <div>
                    <label for="recipient_type" class="block text-sm font-medium text-gray-700">Recipient Type</label>
                    <select id="recipient_type" x-model="recipientType" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                        <option value="patients">All Patients</option>
                        <option value="doctors">All Doctors</option>
                        <option value="number">By Number</option>
                    </select>
                </div>

                <!-- Manual Numbers (Conditional) -->
                <div x-show="recipientType === 'number'" x-transition class="space-y-1">
                    <label for="numbers" class="block text-sm font-medium text-gray-700">Phone Numbers</label>
                    <textarea id="numbers" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2" placeholder="e.g. 0501234567, 0509876543"></textarea>
                    <p class="text-xs text-gray-500">Separate multiple numbers with commas.</p>
                </div>
            </div>

            <!-- Message Body -->
            <div class="space-y-4">
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700">Message Content</label>
                    <textarea id="message" rows="5" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2" placeholder="Type your message here..."></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="inline-flex items-center rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                        <svg class="mr-2 -ml-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Send Message
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- History Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Message History</h2>
            <table id="messagesTable" class="display w-full" style="width:100%">
                <thead>
                    <tr>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Message</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Recipient</th>
                        <th class="text-left py-3 px-4 text-sm font-semibold text-gray-700">Status</th>
                        <th class="text-right py-3 px-4 text-sm font-semibold text-gray-700">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <!-- Static Data -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 text-sm text-gray-900 font-medium">Appointment reminder for tomorrow</td>
                        <td class="py-3 px-4 text-sm text-gray-500">Ahmed Ali (0501234567)</td>
                        <td class="py-3 px-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Sent
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right text-sm text-gray-500">2024-01-11 10:30</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 text-sm text-gray-900 font-medium">Appointment reminder for tomorrow</td>
                        <td class="py-3 px-4 text-sm text-gray-500">Sara Mohamed (0509988776)</td>
                        <td class="py-3 px-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Failed
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right text-sm text-gray-500">2024-01-11 10:30</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 text-sm text-gray-900 font-medium">System maintenance update</td>
                        <td class="py-3 px-4 text-sm text-gray-500">Dr. Khaled (0551122334)</td>
                        <td class="py-3 px-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Sent
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right text-sm text-gray-500">2024-01-10 15:45</td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 text-sm text-gray-900 font-medium">Your glasses are ready</td>
                        <td class="py-3 px-4 text-sm text-gray-500">Visitor (0501234567)</td>
                        <td class="py-3 px-4 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Sent
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right text-sm text-gray-500">2024-01-09 11:20</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:navigated', function() {
        if ($.fn.DataTable.isDataTable('#messagesTable')) {
            $('#messagesTable').DataTable().destroy();
        }
        
        $('#messagesTable').DataTable({
            pageLength: 10,
            lengthChange: false,
            ordering: true,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'excelHtml5',
                text: '📥 Export Excel',
                className: 'bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 border-none'
            }],
            language: {
                search: "Search messages:",
                emptyTable: "No messages found",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });
    });
</script>
