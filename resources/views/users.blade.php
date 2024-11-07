<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 formcss">
                        <h1>Create User</h1>
                        <form id="user-form" onsubmit="submitForm(event)">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"   >
                                <div id="name-error" class="text-danger"></div>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" >
                                <div id="email-error" class="text-danger"></div>
                            </div>

                            <label for="phone" class="form-label">Phone</label>
                            <div class="input-group mb-3">
                            
                                <span class="input-group-text" id="inputGroup-sizing-default">+91</span>
                                <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" id="phone" name="phone" placeholder="Phone (e.g., 91XXXXXXXXXX)" maxlength="10" >
                                
                            </div>
                            <div id="phone-error" class="text-danger"></div>
                            <!-- Description -->
                            <div class="mb-3">
                                <label for="discription" class="form-label">Discription</label>
                                <textarea class="form-control" id="discription" name="discription" rows="4"></textarea>
                                <div id="discription-error" class="text-danger"></div>
                            </div>

                            <!-- Role -->
                            <div class="mb-3">
                                <label for="role_id" class="form-label">Role</label>
                                <select class="form-select" id="role_id" name="role_id" >
                                    <option value="">Select Role</option>
                                    <option value="2">User</option>
                                </select>
                                <div id="role-error" class="text-danger"></div>
                            </div>

                            <!-- Profile Image -->
                            <div class="mb-3">
                                <label for="profile_image" class="form-label">Profile Image</label>
                                <input type="file" class="form-control" id="profile_image" name="profile_image" >
                                <div id="profile-image-error" class="text-danger"></div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Create User</button>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <h3 class="mt-5">Users List</h3>
                    <table class="table table-bordered table-striped mt-3">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Discription</th>
                                <th>Role</th>
                                <th>Profile Image</th>
                            </tr>
                        </thead>
                        <tbody id="user-table-body">
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? 'N/A' }}</td>
                                    <td>{{ $user->discription ?? 'N/A' }}</td>
                                    <td>{{ $user->role->name }}</td>
                                    <td>
                                        <img src="{{ $user->profile_image_url }}" alt="Profile Image" width="50" height="50">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // Form submission
            document.getElementById('user-form').addEventListener('submit', submitForm);
        });


        function validateForm(event) {
            let isValid = true;

            // Get form fields
            const name = document.getElementById('name');
            const email = document.getElementById('email');
            const phone = document.getElementById('phone');
            const discription = document.getElementById('discription');
            const role = document.getElementById('role_id');
            const profileImage = document.getElementById('profile_image');
            let phoneValue = phone.value.trim();

            // Clear previous error messages
            document.querySelectorAll('.text-danger').forEach(function(element) {
                element.innerHTML = '';
            });

            // Name validation
            if (name.value.trim() === '') {
                isValid = false;
                document.getElementById('name-error').innerHTML = 'Name is required.';
            }

            // Email validation
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (email.value.trim() === '') {
                isValid = false;
                document.getElementById('email-error').innerHTML = 'Email is required.';
            } else if (!emailPattern.test(email.value)) {
                isValid = false;
                document.getElementById('email-error').innerHTML = 'Please enter a valid email address.';
            }

            if (phoneValue === '') {
                isValid = false;
                document.getElementById('phone-error').innerHTML = 'Phone number is required.';
            } else if (!/^\d{10}$/.test(phoneValue)) {
                // The phone number must be exactly 10 digits and numeric
                isValid = false;
                document.getElementById('phone-error').innerHTML = 'Phone number must be exactly 10 digits and numeric.';
            }

            // Role validation
            if (role.value === '') {
                isValid = false;
                document.getElementById('role-error').innerHTML = 'Role is required.';
            }

            // Profile image validation (optional, must be image file if uploaded)
            if (profileImage.files.length === 0) {
                isValid = false;
                document.getElementById('profile-image-error').innerHTML = 'Profile image is required.';
            } else {
                // If a file is selected, check the file type
                const file = profileImage.files[0];
                const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];

                if (!validImageTypes.includes(file.type)) {
                    isValid = false;
                    document.getElementById('profile-image-error').innerHTML = 'Profile image must be a JPEG, PNG, or GIF file.';
                }
            }

            if (!isValid) {
                event.preventDefault();
                return false;
            }

            return true;
        }

        async function submitForm(event) {
            event.preventDefault();  // Prevent regular form submission

            if (!validateForm(event)) {
                return;
            }

            const formData = new FormData();
            formData.append('name', document.getElementById('name').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('phone', document.getElementById('phone').value);
            formData.append('discription', document.getElementById('discription').value);
            formData.append('role_id', document.getElementById('role_id').value);
            formData.append('profile_image', document.getElementById('profile_image').files[0]);

            try {
                const response = await fetch('/api/create-user', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const result = await response.json();

                if (response.ok) {
                    alert('User created successfully!');
                    document.getElementById('user-form').reset();
                    addUserToTable(result.user);
                } else {
                    alert('Error: ' + result.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('There was an error with the form submission.');
            }
        }

        function addUserToTable(user) {
            const tableBody = document.getElementById('user-table-body');
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${user.phone || 'N/A'}</td>
                <td>${user.discription || 'N/A'}</td>
                <td>${user.role.name}</td>
                <td>
                    <img src="/storage/${user.profile_image}" alt="Profile Image" width="50" height="50">
                </td>
            `;
            tableBody.appendChild(row);
        }
    </script>

</x-app-layout>
