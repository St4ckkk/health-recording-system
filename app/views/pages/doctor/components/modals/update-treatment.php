<div id="updateTreatmentModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div id="updateTreatmentModalContent"
        class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0">
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-4">
            <h3 class="text-lg font-medium text-gray-900">Update Treatment</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeTreatmentModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <form id="updateTreatmentForm">
            <div class="px-6 py-4">
                <div class="rounded-md border border-gray-200 p-3 bg-blue-50 mb-4">
                    <div class="flex items-start">
                        <i class="bx bx-info-circle text-blue-500 text-lg mr-2"></i>
                        <p class="text-sm text-blue-700">
                            Update the treatment details and status.
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <input type="hidden" name="treatment_id" value="<?= $currentTreatment->id ?>">

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-3">
                            <label for="treatment_type" class="block text-sm font-medium text-gray-700 mb-1">Treatment
                                Type</label>
                            <select id="treatment_type" name="treatment_type"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none">
                                <option value="Intensive Phase" <?= $currentTreatment->treatment_type === 'Intensive Phase' ? 'selected' : '' ?>>Intensive Phase</option>
                                <option value="Continuation Phase" <?= $currentTreatment->treatment_type === 'Continuation Phase' ? 'selected' : '' ?>>Continuation Phase</option>
                                <option value="Other" <?= $currentTreatment->treatment_type === 'Other' ? 'selected' : '' ?>>Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="outcome" class="block text-sm font-medium text-gray-700 mb-1">Treatment
                                Outcome</label>
                            <select id="outcome" name="outcome"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none">
                                <option value="ongoing" <?= $currentTreatment->outcome === 'ongoing' ? 'selected' : '' ?>>
                                    Ongoing</option>
                                <option value="cured" <?= $currentTreatment->outcome === 'cured' ? 'selected' : '' ?>>Cured
                                </option>
                                <option value="completed" <?= $currentTreatment->outcome === 'completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="failed" <?= $currentTreatment->outcome === 'failed' ? 'selected' : '' ?>>
                                    Failed</option>
                                <option value="lost to follow-up" <?= $currentTreatment->outcome === 'lost to follow-up' ? 'selected' : '' ?>>Lost to Follow-up</option>
                                <option value="died" <?= $currentTreatment->outcome === 'died' ? 'selected' : '' ?>>Died
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="mb-3">
                            <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start
                                Date</label>
                            <input type="date" id="start_date" name="start_date"
                                value="<?= htmlspecialchars($currentTreatment->start_date) ?>"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none">
                        </div>

                        <div class="mb-3">
                            <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                            <input type="date" id="end_date" name="end_date"
                                value="<?= htmlspecialchars($currentTreatment->end_date) ?>"
                                class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="regimen_summary" class="block text-sm font-medium text-gray-700 mb-1">Regimen
                            Summary</label>
                        <textarea id="regimen_summary" name="regimen_summary" rows="3"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"><?= htmlspecialchars($currentTreatment->regimen_summary) ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none">
                            <option value="active" <?= $currentTreatment->status === 'active' ? 'selected' : '' ?>>Active
                            </option>
                            <option value="completed" <?= $currentTreatment->status === 'completed' ? 'selected' : '' ?>>
                                Completed</option>
                            <option value="discontinued" <?= $currentTreatment->status === 'discontinued' ? 'selected' : '' ?>>Discontinued</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="adherence_status" class="block text-sm font-medium text-gray-700 mb-1">Adherence
                            Status</label>
                        <select id="adherence_status" name="adherence_status"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none">
                            <option value="good" <?= $currentTreatment->adherence_status === 'good' ? 'selected' : '' ?>>
                                Good</option>
                            <option value="irregular" <?= $currentTreatment->adherence_status === 'irregular' ? 'selected' : '' ?>>Irregular</option>
                            <option value="poor" <?= $currentTreatment->adherence_status === 'poor' ? 'selected' : '' ?>>
                                Poor</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="follow_up_notes" class="block text-sm font-medium text-gray-700 mb-1">Follow-up
                            Notes</label>
                        <textarea id="follow_up_notes" name="follow_up_notes" rows="3"
                            class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none"><?= htmlspecialchars($currentTreatment->follow_up_notes) ?></textarea>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 px-6 py-4">
                <div class="flex justify-end gap-3">
                    <button type="button" id="cancelTreatmentBtn"
                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-500">
                        Cancel
                    </button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                        Update Treatment
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>