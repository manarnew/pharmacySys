<div>
    <div class="flex justify-center">
            <div class="w-full max-w-4xl bg-white rounded-lg shadow-lg p-6">
                <hr class="border-4 border-black mb-4">
                <p class="text-lg mb-4"><span class="font-bold">Name:</span> Ahmed Mohamed Ali</p>
                <hr class="border-2 border-black mb-4">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <span class="font-bold">Age:</span> 45 years
                    </div>
                    <div>
                        <span class="font-bold">Date:</span> January 10, 2026
                    </div>
                     <div>
                        <span class="font-bold">Phone:</span> +20 123 456 7890
                    </div>
                </div>
                
                <hr class="border-3 border-black mb-6">
                
                <form wire:submit.prevent="save">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold mb-4">
                            <label class="block mb-2" for="history">History:</label>
                            <input 
                                id="history" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                type="text" 
                                placeholder="Patient history"
                            >
                        </h2>
                    </div>
                    
                    <hr class="border-4 border-black mb-6">
                    
                    <!-- Old RX Table -->
                    <div class="overflow-x-auto mb-6">
                        <table class="w-full border-collapse border border-gray-400">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th class="border border-gray-400 px-4 py-2">Old RX</th>
                                    <th class="border border-gray-400 px-4 py-2">Sphere</th>
                                    <th class="border border-gray-400 px-4 py-2">CYL</th>
                                    <th class="border border-gray-400 px-4 py-2">AXIS</th>
                                    <th class="border border-gray-400 px-4 py-2">ADD</th>
                                    <th class="border border-gray-400 px-4 py-2">VA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-gray-200">
                                    <td class="border border-gray-400 px-4 py-2 font-bold">OD</td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="PL">PL</option>
                                            <option value="+0.25">+0.25</option>
                                            <option value="+0.50">+0.50</option>
                                            <option value="+0.75">+0.75</option>
                                            <option value="+1.00">+1.00</option>
                                            <option value="+1.25">+1.25</option>
                                            <option value="+1.50">+1.50</option>
                                            <option value="-0.25">-0.25</option>
                                            <option value="-0.50">-0.50</option>
                                            <option value="-1.00">-1.00</option>
                                            <option value="-1.50">-1.50</option>
                                            <option value="-2.00">-2.00</option>
                                        </select>
                                        <input type="text" placeholder="Sphere" class="w-full mt-2 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="-0.25">-0.25</option>
                                            <option value="-0.50">-0.50</option>
                                            <option value="-0.75">-0.75</option>
                                            <option value="-1.00">-1.00</option>
                                            <option value="-1.25">-1.25</option>
                                            <option value="-1.50">-1.50</option>
                                            <option value="-2.00">-2.00</option>
                                        </select>
                                        <input type="text" placeholder="CYL" class="w-full mt-2 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="45">45</option>
                                            <option value="90">90</option>
                                            <option value="135">135</option>
                                            <option value="180">180</option>
                                        </select>
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="PL">PL</option>
                                            <option value="+0.25">+0.25</option>
                                            <option value="+0.50">+0.50</option>
                                            <option value="+1.00">+1.00</option>
                                            <option value="+1.50">+1.50</option>
                                            <option value="+2.00">+2.00</option>
                                        </select>
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="6/60">6/60</option>
                                            <option value="6/36">6/36</option>
                                            <option value="6/24">6/24</option>
                                            <option value="6/18">6/18</option>
                                            <option value="6/12">6/12</option>
                                            <option value="6/9">6/9</option>
                                            <option value="6/6">6/6</option>
                                            <option value="20/20">20/20</option>
                                            <option value="CF">CF</option>
                                            <option value="HM">HM</option>
                                            <option value="LP">LP</option>
                                            <option value="NLP">NLP</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="bg-gray-200">
                                    <td class="border border-gray-400 px-4 py-2 font-bold">OS</td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="PL">PL</option>
                                            <option value="+0.25">+0.25</option>
                                            <option value="+0.50">+0.50</option>
                                            <option value="+0.75">+0.75</option>
                                            <option value="+1.00">+1.00</option>
                                            <option value="+1.25">+1.25</option>
                                            <option value="+1.50">+1.50</option>
                                            <option value="-0.25">-0.25</option>
                                            <option value="-0.50">-0.50</option>
                                            <option value="-1.00">-1.00</option>
                                            <option value="-1.50">-1.50</option>
                                            <option value="-2.00">-2.00</option>
                                        </select>
                                        <input type="text" placeholder="Sphere" class="w-full mt-2 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="-0.25">-0.25</option>
                                            <option value="-0.50">-0.50</option>
                                            <option value="-0.75">-0.75</option>
                                            <option value="-1.00">-1.00</option>
                                            <option value="-1.25">-1.25</option>
                                            <option value="-1.50">-1.50</option>
                                            <option value="-2.00">-2.00</option>
                                        </select>
                                        <input type="text" placeholder="CYL" class="w-full mt-2 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="45">45</option>
                                            <option value="90">90</option>
                                            <option value="135">135</option>
                                            <option value="180">180</option>
                                        </select>
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="PL">PL</option>
                                            <option value="+0.25">+0.25</option>
                                            <option value="+0.50">+0.50</option>
                                            <option value="+1.00">+1.00</option>
                                            <option value="+1.50">+1.50</option>
                                            <option value="+2.00">+2.00</option>
                                        </select>
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="6/60">6/60</option>
                                            <option value="6/36">6/36</option>
                                            <option value="6/24">6/24</option>
                                            <option value="6/18">6/18</option>
                                            <option value="6/12">6/12</option>
                                            <option value="6/9">6/9</option>
                                            <option value="6/6">6/6</option>
                                            <option value="20/20">20/20</option>
                                            <option value="CF">CF</option>
                                            <option value="HM">HM</option>
                                            <option value="LP">LP</option>
                                            <option value="NLP">NLP</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Subjective ref Table -->
                    <div class="overflow-x-auto mb-6">
                        <table class="w-full border-collapse border border-gray-400">
                            <thead class="bg-gray-300">
                                <tr>
                                    <th class="border border-gray-400 px-4 py-2">Subjective ref</th>
                                    <th class="border border-gray-400 px-4 py-2">Sphere</th>
                                    <th class="border border-gray-400 px-4 py-2">CYL</th>
                                    <th class="border border-gray-400 px-4 py-2">AXIS</th>
                                    <th class="border border-gray-400 px-4 py-2">ADD</th>
                                    <th class="border border-gray-400 px-4 py-2">VA</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-gray-200">
                                    <td class="border border-gray-400 px-4 py-2 font-bold">OD</td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="PL">PL</option>
                                            <option value="+0.25">+0.25</option>
                                            <option value="+0.50">+0.50</option>
                                            <option value="+0.75">+0.75</option>
                                            <option value="+1.00">+1.00</option>
                                            <option value="+1.25">+1.25</option>
                                            <option value="+1.50">+1.50</option>
                                            <option value="-0.25">-0.25</option>
                                            <option value="-0.50">-0.50</option>
                                            <option value="-1.00">-1.00</option>
                                            <option value="-1.50">-1.50</option>
                                            <option value="-2.00">-2.00</option>
                                        </select>
                                        <input type="text" placeholder="Sphere" class="w-full mt-2 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="-0.25">-0.25</option>
                                            <option value="-0.50">-0.50</option>
                                            <option value="-0.75">-0.75</option>
                                            <option value="-1.00">-1.00</option>
                                            <option value="-1.25">-1.25</option>
                                            <option value="-1.50">-1.50</option>
                                            <option value="-2.00">-2.00</option>
                                        </select>
                                        <input type="text" placeholder="CYL" class="w-full mt-2 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="45">45</option>
                                            <option value="90">90</option>
                                            <option value="135">135</option>
                                            <option value="180">180</option>
                                        </select>
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="PL">PL</option>
                                            <option value="+0.25">+0.25</option>
                                            <option value="+0.50">+0.50</option>
                                            <option value="+1.00">+1.00</option>
                                            <option value="+1.50">+1.50</option>
                                            <option value="+2.00">+2.00</option>
                                        </select>
                                        <input type="text" placeholder="ADD" class="w-full mt-2 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="6/60">6/60</option>
                                            <option value="6/36">6/36</option>
                                            <option value="6/24">6/24</option>
                                            <option value="6/18">6/18</option>
                                            <option value="6/12">6/12</option>
                                            <option value="6/9">6/9</option>
                                            <option value="6/6">6/6</option>
                                            <option value="20/20">20/20</option>
                                            <option value="CF">CF</option>
                                            <option value="HM">HM</option>
                                            <option value="LP">LP</option>
                                            <option value="NLP">NLP</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="bg-gray-200">
                                    <td class="border border-gray-400 px-4 py-2 font-bold">OS</td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="PL">PL</option>
                                            <option value="+0.25">+0.25</option>
                                            <option value="+0.50">+0.50</option>
                                            <option value="+0.75">+0.75</option>
                                            <option value="+1.00">+1.00</option>
                                            <option value="+1.25">+1.25</option>
                                            <option value="+1.50">+1.50</option>
                                            <option value="-0.25">-0.25</option>
                                            <option value="-0.50">-0.50</option>
                                            <option value="-1.00">-1.00</option>
                                            <option value="-1.50">-1.50</option>
                                            <option value="-2.00">-2.00</option>
                                        </select>
                                        <input type="text" placeholder="Sphere" class="w-full mt-2 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="-0.25">-0.25</option>
                                            <option value="-0.50">-0.50</option>
                                            <option value="-0.75">-0.75</option>
                                            <option value="-1.00">-1.00</option>
                                            <option value="-1.25">-1.25</option>
                                            <option value="-1.50">-1.50</option>
                                            <option value="-2.00">-2.00</option>
                                        </select>
                                        <input type="text" placeholder="CYL" class="w-full mt-2 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="5">5</option>
                                            <option value="10">10</option>
                                            <option value="15">15</option>
                                            <option value="45">45</option>
                                            <option value="90">90</option>
                                            <option value="135">135</option>
                                            <option value="180">180</option>
                                        </select>
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="PL">PL</option>
                                            <option value="+0.25">+0.25</option>
                                            <option value="+0.50">+0.50</option>
                                            <option value="+1.00">+1.00</option>
                                            <option value="+1.50">+1.50</option>
                                            <option value="+2.00">+2.00</option>
                                        </select>
                                        <input type="text" placeholder="ADD" class="w-full mt-2 px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </td>
                                    <td class="border border-gray-400 px-4 py-2">
                                        <select class="w-full px-2 py-1 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">select</option>
                                            <option value="6/60">6/60</option>
                                            <option value="6/36">6/36</option>
                                            <option value="6/24">6/24</option>
                                            <option value="6/18">6/18</option>
                                            <option value="6/12">6/12</option>
                                            <option value="6/9">6/9</option>
                                            <option value="6/6">6/6</option>
                                            <option value="20/20">20/20</option>
                                            <option value="CF">CF</option>
                                            <option value="HM">HM</option>
                                            <option value="LP">LP</option>
                                            <option value="NLP">NLP</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <hr class="border-4 border-black mb-4">
                    <p class="mb-6"><span class="font-bold">Specialist:</span> Dr. Sarah Ibrahim</p>
                    
                    <div class="text-center">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition duration-200">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
</div>