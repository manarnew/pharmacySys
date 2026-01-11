<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="p-8">
                <!-- Patient Info -->
                <div class="mb-10">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Patient Information</h2>
                        <div class="h-px flex-grow ml-4 bg-gradient-to-r from-blue-400 to-blue-100"></div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 hover:border-blue-200 transition">
                            <div class="flex items-center mb-3">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <span class="text-blue-600 font-semibold">👤</span>
                                </div>
                                <div>
                                    <span class="block text-sm font-semibold text-gray-700">Name</span>
                                    <span class="text-lg font-medium text-gray-900">Ahmed Mohamed Ali</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 hover:border-blue-200 transition">
                            <div class="flex items-center mb-3">
                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                    <span class="text-green-600 font-semibold">🎂</span>
                                </div>
                                <div>
                                    <span class="block text-sm font-semibold text-gray-700">Age</span>
                                    <span class="text-lg font-medium text-gray-900">45 years</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 hover:border-blue-200 transition">
                            <div class="flex items-center mb-3">
                                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center mr-3">
                                    <span class="text-purple-600 font-semibold">📞</span>
                                </div>
                                <div>
                                    <span class="block text-sm font-semibold text-gray-700">Contact</span>
                                    <span class="text-lg font-medium text-gray-900">+20 123 456 7890</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 p-5 rounded-lg border border-gray-100 hover:border-blue-200 transition">
                            <div class="flex items-center mb-3">
                                <div class="h-10 w-10 rounded-full bg-yellow-100 flex items-center justify-center mr-3">
                                    <span class="text-yellow-600 font-semibold">📅</span>
                                </div>
                                <div>
                                    <span class="block text-sm font-semibold text-gray-700">Last Visit</span>
                                    <span class="text-lg font-medium text-gray-900">2026-01-10</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Medical History -->
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-gray-900">Medical History</h2>
                        <div class="h-px flex-grow ml-4 bg-gradient-to-r from-green-400 to-green-100"></div>
                    </div>
                    
                    <div class="overflow-hidden rounded-xl border border-gray-200 shadow-sm">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th scope="col" class="px-8 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                        Date
                                    </th>
                                    <th scope="col" class="px-8 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                        Doctor
                                    </th>
                                    <th scope="col" class="px-8 py-4 text-left text-sm font-semibold text-gray-900 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-lg bg-blue-50 flex items-center justify-center mr-4">
                                                <span class="text-blue-600 font-bold">10</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">2026-01-10</div>
                                                <div class="text-xs text-gray-500">Today</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                                <span class="text-green-600 text-xs font-bold">SI</span>
                                            </div>
                                            <div class="text-sm font-medium text-gray-900">Dr. Sarah Ibrahim</div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center space-x-4">
                                            <a href="{{ route('admin.examinations.edit') }}" 
                                               class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                                                <span class="mr-2">🔍</span>
                                                View Examination
                                            </a>
                                            <a href="{{ route('admin.prescriptions.index') }}" 
                                               class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition font-medium">
                                                <span class="mr-2">📄</span>
                                                View Prescription
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 rounded-lg bg-gray-50 flex items-center justify-center mr-4">
                                                <span class="text-gray-600 font-bold">15</span>
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">2025-11-15</div>
                                                <div class="text-xs text-gray-500">2 months ago</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                                <span class="text-green-600 text-xs font-bold">SI</span>
                                            </div>
                                            <div class="text-sm font-medium text-gray-900">Dr. Sarah Ibrahim</div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-5 whitespace-nowrap">
                                        <div class="flex items-center space-x-4">
                                            <a href="{{ route('admin.examinations.edit') }}" 
                                               class="inline-flex items-center px-4 py-2 bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition font-medium">
                                                <span class="mr-2">🔍</span>
                                                View Examination
                                            </a>
                                            <a href="{{ route('admin.prescriptions.index') }}" 
                                               class="inline-flex items-center px-4 py-2 bg-green-50 text-green-700 rounded-lg hover:bg-green-100 transition font-medium">
                                                <span class="mr-2">📄</span>
                                                View Prescription
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>