<!-- components/tab/immunizations.php -->
<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-medium">Immunization Records</h3>
    <?php 
        $text = "Add Immunization";
        $icon = "bx-injection";
        $data_modal = "add-immunization-modal";
        include(__DIR__ . '/../common/action-button.php'); 
    ?>
</div>
<div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Immunization</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Administrator</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lot Number</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Next Due</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Influenza (Flu) Vaccine</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2022-10-15</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Memorial Hospital</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">FL2022-456</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2023-10</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Pneumococcal Vaccine (PPSV23)</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2021-05-20</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Dr. Sarah Johnson</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">PN2021-789</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">N/A</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">Tetanus, Diphtheria, Pertussis (Tdap)</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2018-03-12</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Urgent Care Clinic</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">TD2018-123</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2028-03</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">COVID-19 Vaccine (Pfizer)</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2021-04-05</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Community Vaccination Center</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">PF2021-456</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">N/A</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">COVID-19 Vaccine (Pfizer) - Dose 2</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2021-04-26</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Community Vaccination Center</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">PF2021-789</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">N/A</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">COVID-19 Booster (Pfizer)</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">2021-11-15</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">Memorial Hospital</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">PF2021-987</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">N/A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>