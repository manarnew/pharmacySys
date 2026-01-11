<div x-data="{ showModal: false }">
    <!-- Page Header -->
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Patients</h1>
            <p class="text-gray-600">Manage your patients list</p>
        </div>
        <button @click="showModal = true" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Add Patient
        </button>
    </div>

    <!-- Patients Datatable -->
    <div class="bg-white rounded-lg shadow p-4">
        <table id="patientsTable" class="display w-full">
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Contact</th>
                    <th>Last Visit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Sample static data -->
                <tr>
                    <td>Ahmed Ali</td>
                    <td>ahmed@email.com</td>
                    <td>2024-12-20</td>
                    <td>
                        <a href="{{ route('admin.patients.show') }}" class="text-blue-600 hover:underline">View</a>
                        <a href="{{ route('admin.examinations.index') }}" class="ml-2 text-green-600 hover:underline">Examination</a>
                    </td>
                </tr>
                <tr>
                    <td>Sara Mohamed</td>
                    <td>01012345678</td>
                    <td>2025-01-05</td>
                    <td>
                        <a href="{{ route('admin.patients.show') }}" class="text-blue-600 hover:underline">View</a>
                        <a href="{{ route('admin.examinations.index') }}" class="ml-2 text-green-600 hover:underline">Examination</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div x-show="showModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Add New Patient
                            </h3>
                            <div class="mt-2 text-sm text-gray-500">
                                <p>Fill in the details for the new patient.</p>
                                <!-- Form Fields Placeholder -->
                                <div class="mt-4 grid grid-cols-1 gap-y-4">
                                    <div>
                                        <label for="patient_name" class="block text-sm font-medium text-gray-700">Patient Name</label>
                                        <input type="text" name="patient_name" id="patient_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                    </div>
                                    <div>
                                        <label for="contact" class="block text-sm font-medium text-gray-700">Contact</label>
                                        <input type="text" name="contact" id="contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                    </div>
                                    <div>
                                        <label for="last_visit" class="block text-sm font-medium text-gray-700">Last Visit</label>
                                        <input type="date" name="last_visit" id="last_visit" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm border p-2">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button @click="showModal = false" type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Save
                    </button>
                    <button @click="showModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#patientsTable').DataTable({
            pageLength: 10,
            lengthChange: false,
            ordering: true,
            dom: 'Bfrtip', // IMPORTANT
            buttons: [{
                extend: 'excelHtml5',
                text: '📥 Export Excel',
                className: 'bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700'
            }],
            language: {
                search: "Search patients:",
                emptyTable: "No patients found"
            }
        });
    });
</script>
