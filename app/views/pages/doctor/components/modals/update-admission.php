<div id="updateStatusModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div id="updateStatusModalContent"
        class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Update Admission Status</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeStatusModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <form id="updateStatusForm">
            <div class="px-6 py-4">
                <div class="rounded-md border border-gray-200 p-3 bg-blue-50 mb-4">
                    <div class="flex items-start">
                        <i class="bx bx-info-circle text-blue-500 text-lg mr-2"></i>
                        <p class="text-sm text-blue-700">
                            Update the admission status and provide necessary details.
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <input type="hidden" name="admission_id" value="<?= $currentAdmission->id ?>">

                    <div class="mb-3">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none">
                            <option value="admitted" <?= $currentAdmission->status === 'admitted' ? 'selected' : '' ?>>
                                Admitted</option>
                            <option value="discharged" <?= $currentAdmission->status === 'discharged' ? 'selected' : '' ?>>
                                Discharged</option>
                            <option value="referred" <?= $currentAdmission->status === 'referred' ? 'selected' : '' ?>>
                                Referred</option>
                            <option value="transferred" <?= $currentAdmission->status === 'transferred' ? 'selected' : '' ?>>
                                Transferred</option>
                        </select>
                    </div>

                    <div id="dischargeDateContainer"
                        class="mb-3 <?= $currentAdmission->status === 'discharged' || $currentAdmission->status === 'referred' || $currentAdmission->status === 'transferred' ? '' : 'hidden' ?>">
                        <label id="dateLabel" for="discharge_date" class="block text-sm font-medium text-gray-700 mb-1">
                            <?php
                            $dateLabel = 'Date';
                            if ($currentAdmission->status === 'discharged') {
                                $dateLabel = 'Discharge Date';
                            } elseif ($currentAdmission->status === 'referred') {
                                $dateLabel = 'Referral Date';
                            } elseif ($currentAdmission->status === 'transferred') {
                                $dateLabel = 'Transfer Date';
                            }
                            echo $dateLabel;
                            ?>
                        </label>
                        <input type="date" id="discharge_date" name="discharge_date"
                            value="<?= $currentAdmission->discharge_date ? date('Y-m-d', strtotime($currentAdmission->discharge_date)) : date('Y-m-d') ?>"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none">
                    </div>

                    <div id="referralContainer" class="mb-3 hidden">
                        <label for="referred_to" class="block text-sm font-medium text-gray-700 mb-1">Referred To
                            (Doctor)</label>
                        <input type="text" id="referred_to" name="referred_to"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"
                            placeholder="Enter doctor's name">
                    </div>

                    <div id="transferContainer" class="mb-3 hidden">
                        <label for="transferred_to" class="block text-sm font-medium text-gray-700 mb-1">Transferred To
                            (Hospital)</label>
                        <input type="text" id="transferred_to" name="transferred_to"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"
                            placeholder="Enter hospital name">
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                        <textarea id="remarks" name="remarks" rows="3"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"></textarea>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 border-t border-gray-200 bg-gray-50 px-6 py-3">
                    <button type="button" id="cancelStatusBtn"
                        class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                        Cancel
                    </button>
                    <button type="submit" id="saveStatusBtn"
                        class="rounded-md bg-success px-4 py-2 text-sm font-medium text-white hover:bg-success-dark focus:outline-none">
                        Save Changes
                    </button>
                </div>
        </form>
    </div>
</div>