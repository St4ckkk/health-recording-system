<div id="addStaffModal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300">
    <div class="w-full max-w-md transform rounded-lg bg-white shadow-xl transition-all duration-300 scale-95 opacity-0"
        id="addStaffModalContent">
        <!-- Modal Header -->
        <div class="flex items-center justify-between border-b border-gray-200 px-6 py-3">
            <h3 class="text-lg font-medium text-gray-900">Add New Staff Member</h3>
            <button type="button" class="text-gray-400 hover:text-gray-500 focus:outline-none" id="closeAddStaffModal">
                <i class="bx bx-x text-2xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="px-6 py-3 max-h-[60vh] overflow-y-auto">
            <form id="addStaffForm" class="space-y-3">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" id="firstName" name="firstName" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" id="lastName" name="lastName" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" id="phone" name="phone"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="roleId" class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select id="roleId" name="roleId" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select Role</option>
                        <?php foreach ($roles as $role): ?>
                            <option value="<?= $role->id ?>"><?= htmlspecialchars($role->role_name) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label for="profilePicture" class="block text-sm font-medium text-gray-700 mb-1">Profile
                        Picture</label>
                    <div class="flex items-center space-x-3">
                        <div
                            class="relative w-24 h-24 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center overflow-hidden">
                            <img id="profilePreview" src="<?= BASE_URL ?>/img/default-avatar.png" alt="Profile Preview"
                                class="w-full h-full object-cover hidden">
                            <div id="uploadPlaceholder" class="text-center">
                                <i class='bx bx-image-add text-3xl text-gray-400'></i>
                                <p class="text-xs text-gray-500">Upload Image</p>
                            </div>
                        </div>
                        <div class="flex-1">
                            <input type="file" id="profilePicture" name="profilePicture" accept="image/*"
                                class="hidden">
                            <button type="button" id="selectImageBtn"
                                class="px-3 py-2 bg-gray-100 border border-gray-300 rounded-md text-sm text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mb-1 w-full">
                                Select Image
                            </button>
                            <p class="text-xs text-gray-500">JPG, PNG or GIF (Max. 2MB)</p>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Modal Footer -->
        <div class="border-t border-gray-200 px-6 py-3 flex justify-end space-x-3">
            <button type="button" id="cancelAddStaffBtn"
                class="px-4 py-2 admin-secondary rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Cancel
            </button>
            <button type="submit" form="addStaffForm"
                class="px-4 py-2 admin-primary rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Add Staff
            </button>
        </div>
    </div>
</div>