<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Buat Broadcast Message Baru') }}
            </h2>
            <a href="{{ route('broadcasts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('broadcasts.store') }}" method="POST" id="broadcastForm">
                        @csrf
                        
                        <!-- Hidden inputs for selected students -->
                        <input type="hidden" name="selected_students" id="selectedStudentsInput" value="">
                        
                        <!-- Target Criteria -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Target Penerima</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Target Type -->
                                <div>
                                    <label for="target_type" class="block text-sm font-medium text-gray-700">Jenis Target</label>
                                    <select name="target_type" id="target_type" 
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="all" {{ old('target_type') === 'all' ? 'selected' : '' }}>Semua Mahasiswa</option>
                                        <option value="specific" {{ old('target_type') === 'specific' ? 'selected' : '' }}>Mahasiswa Tertentu</option>
                                    </select>
                                </div>

                                <!-- Selected Students (hidden by default) -->
                                <div id="selectedStudentsContainer" class="hidden">
                                    <label class="block text-sm font-medium text-gray-700">Mahasiswa Terpilih</label>
                                    <div id="selectedStudentsList" class="mt-1 p-3 border border-gray-300 rounded-md bg-gray-50 min-h-[100px]">
                                        <p class="text-sm text-gray-500">Belum ada mahasiswa dipilih</p>
                                </div>
                                    <button type="button" id="selectStudentsBtn" 
                                            class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Pilih Mahasiswa
                                    </button>
                                </div>
                            </div>

                            <!-- Recipient Preview -->
                            <div class="mt-4">
                                <button type="button" id="previewRecipients" 
                                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Preview Penerima
                                </button>
                                <div id="recipientPreview" class="mt-3 hidden">
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <h4 class="text-sm font-medium text-gray-900 mb-2">Preview Penerima</h4>
                                        <div id="recipientCount" class="text-sm text-gray-600"></div>
                                        <div id="recipientList" class="mt-2 text-sm text-gray-600"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Basic Information -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
                            
                            <div class="grid grid-cols-1 gap-6">
                                <!-- Title -->
                                <div>
                                    <label for="title" class="block text-sm font-medium text-gray-700">Judul Broadcast</label>
                                    <input type="text" name="title" id="title" 
                                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                           placeholder="Masukkan judul broadcast..." 
                                           value="{{ old('title') }}" required>
                                    @error('title')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Message -->
                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
                                    <textarea name="message" id="message" rows="6" 
                                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                                              placeholder="Masukkan pesan yang akan dikirim ke mahasiswa..." 
                                              required>{{ old('message') }}</textarea>
                                    @error('message')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-sm text-gray-500">Minimal 10 karakter</p>
                                </div>
                            </div>
                        </div>


                        <!-- Actions -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('broadcasts.index') }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Batal
                            </a>
                            
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                </svg>
                                Kirim Broadcast
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal untuk memilih mahasiswa -->
    <div id="selectStudentsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Pilih Mahasiswa</h3>
                    <button type="button" id="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Search Box -->
                <div class="mb-4">
                    <input type="text" id="studentSearch" 
                           placeholder="Cari mahasiswa berdasarkan nama..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <!-- Students List -->
                <div id="studentsList" class="max-h-96 overflow-y-auto border border-gray-200 rounded-md">
                    <div class="p-4 text-center text-gray-500">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto"></div>
                        <p class="mt-2">Memuat daftar mahasiswa...</p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end space-x-3 mt-4">
                    <button type="button" id="cancelSelect" 
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                        Batal
                    </button>
                    <button type="button" id="confirmSelect" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Konfirmasi Pilihan
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Content Loaded - JavaScript is running');
            const form = document.getElementById('broadcastForm');
            const previewBtn = document.getElementById('previewRecipients');
            const recipientPreview = document.getElementById('recipientPreview');
            const recipientCount = document.getElementById('recipientCount');
            const recipientList = document.getElementById('recipientList');
            
            // New elements for student selection
            const targetType = document.getElementById('target_type');
            const selectedStudentsContainer = document.getElementById('selectedStudentsContainer');
            const selectedStudentsList = document.getElementById('selectedStudentsList');
            const selectStudentsBtn = document.getElementById('selectStudentsBtn');
            const selectStudentsModal = document.getElementById('selectStudentsModal');
            const closeModal = document.getElementById('closeModal');
            const cancelSelect = document.getElementById('cancelSelect');
            const confirmSelect = document.getElementById('confirmSelect');
            const studentSearch = document.getElementById('studentSearch');
            const studentsList = document.getElementById('studentsList');
            const selectedStudentsInput = document.getElementById('selectedStudentsInput');
            
            // Store selected students
            let selectedStudents = [];
            let allStudents = [];
            
            console.log('DOM Elements found:');
            console.log('previewBtn:', previewBtn);
            console.log('recipientPreview:', recipientPreview);
            console.log('recipientCount:', recipientCount);
            console.log('recipientList:', recipientList);
            console.log('targetType:', targetType);
            console.log('selectedStudentsContainer:', selectedStudentsContainer);
            console.log('selectStudentsBtn:', selectStudentsBtn);
            console.log('selectStudentsModal:', selectStudentsModal);

            // Handle target type change
            targetType.addEventListener('change', function() {
                if (this.value === 'specific') {
                    selectedStudentsContainer.classList.remove('hidden');
                } else {
                    selectedStudentsContainer.classList.add('hidden');
                    selectedStudents = [];
                    updateSelectedStudentsList();
                }
            });

            // Handle select students button
            selectStudentsBtn.addEventListener('click', function() {
                console.log('Select students button clicked');
                loadStudents();
                selectStudentsModal.classList.remove('hidden');
            });

            // Handle modal close
            closeModal.addEventListener('click', function() {
                selectStudentsModal.classList.add('hidden');
            });

            cancelSelect.addEventListener('click', function() {
                selectStudentsModal.classList.add('hidden');
            });

            // Handle search functionality
            studentSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                filterStudents(searchTerm);
            });

            // Handle confirm selection
            confirmSelect.addEventListener('click', function() {
                updateSelectedStudentsList();
                selectStudentsModal.classList.add('hidden');
            });

            // Handle form submission
            form.addEventListener('submit', function() {
                // Update hidden input with selected students
                selectedStudentsInput.value = JSON.stringify(selectedStudents);
                console.log('Form submitting with selected students:', selectedStudents);
            });

            // Preview recipients functionality
            console.log('Setting up preview button event listener');
            console.log('Preview button element:', previewBtn);
            // Function to load students
            function loadStudents() {
                studentsList.innerHTML = '<div class="p-4 text-center text-gray-500"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500 mx-auto"></div><p class="mt-2">Memuat daftar mahasiswa...</p></div>';
                
                console.log('Loading students from:', '{{ route("broadcasts.get-students") }}');
                console.log('Full URL:', window.location.origin + '{{ route("broadcasts.get-students") }}');
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                console.log('CSRF Token:', csrfToken);
                
                fetch('{{ route("test.get-students") }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response ok:', response.ok);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Students data received:', data);
                    allStudents = data.students;
                    renderStudentsList(allStudents);
                })
                .catch(error => {
                    console.error('Error loading students:', error);
                    studentsList.innerHTML = '<div class="p-4 text-center text-red-500">Gagal memuat daftar mahasiswa: ' + error.message + '</div>';
                });
            }

            // Function to render students list
            function renderStudentsList(students) {
                if (students.length === 0) {
                    studentsList.innerHTML = '<div class="p-4 text-center text-gray-500">Tidak ada mahasiswa ditemukan</div>';
                    return;
                }

                let html = '';
                students.forEach(student => {
                    const isSelected = selectedStudents.some(s => s.id === student.id);
                    html += `
                        <div class="flex items-center justify-between p-3 border-b border-gray-200 hover:bg-gray-50">
                            <div class="flex items-center">
                                <input type="checkbox" 
                                       class="student-checkbox h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" 
                                       data-student='${JSON.stringify(student)}'
                                       ${isSelected ? 'checked' : ''}>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">${student.name}</div>
                                    <div class="text-sm text-gray-500">${student.phone || 'No phone'}</div>
                                </div>
                            </div>
                            <div class="text-xs text-gray-400">
                                ${student.program || 'No program'}
                            </div>
                        </div>
                    `;
                });
                studentsList.innerHTML = html;

                // Add event listeners to checkboxes
                studentsList.querySelectorAll('.student-checkbox').forEach(checkbox => {
                    checkbox.addEventListener('change', function() {
                        const student = JSON.parse(this.dataset.student);
                        if (this.checked) {
                            if (!selectedStudents.some(s => s.id === student.id)) {
                                selectedStudents.push(student);
                            }
                        } else {
                            selectedStudents = selectedStudents.filter(s => s.id !== student.id);
                        }
                    });
                });
            }

            // Function to filter students
            function filterStudents(searchTerm) {
                const filtered = allStudents.filter(student => 
                    student.name.toLowerCase().includes(searchTerm)
                );
                renderStudentsList(filtered);
            }

            // Function to update selected students list
            function updateSelectedStudentsList() {
                if (selectedStudents.length === 0) {
                    selectedStudentsList.innerHTML = '<p class="text-sm text-gray-500">Belum ada mahasiswa dipilih</p>';
                } else {
                    let html = '';
                    selectedStudents.forEach(student => {
                        html += `
                            <div class="flex items-center justify-between p-2 bg-white rounded border mb-2">
                                <div>
                                    <div class="text-sm font-medium">${student.name}</div>
                                    <div class="text-xs text-gray-500">${student.phone || 'No phone'}</div>
                                </div>
                                <button type="button" class="remove-student text-red-500 hover:text-red-700" data-id="${student.id}">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        `;
                    });
                    selectedStudentsList.innerHTML = html;

                    // Add event listeners to remove buttons
                    selectedStudentsList.querySelectorAll('.remove-student').forEach(button => {
                        button.addEventListener('click', function() {
                            const studentId = parseInt(this.dataset.id);
                            selectedStudents = selectedStudents.filter(s => s.id !== studentId);
                            updateSelectedStudentsList();
                        });
                    });
                }
            }

            previewBtn.addEventListener('click', function() {
                console.log('Preview button clicked');
                const formData = new FormData();
                const targetTypeValue = targetType.value;
                console.log('Target type:', targetTypeValue);
                
                if (targetTypeValue === 'all') {
                    formData.append('target_type', 'all');
                } else {
                    formData.append('target_type', 'specific');
                    formData.append('selected_students', JSON.stringify(selectedStudents));
                    console.log('Selected students for preview:', selectedStudents);
                    console.log('Selected students JSON:', JSON.stringify(selectedStudents));
                }

                console.log('Sending request to:', '{{ route("broadcasts.preview-recipients") }}');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                console.log('CSRF Token:', csrfToken);
                fetch('{{ route("broadcasts.preview-recipients") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Response data:', data);
                    console.log('Data success:', data.success);
                    console.log('Data count:', data.count);
                    console.log('Data recipients:', data.recipients);
                    if (data.success) {
                        recipientCount.textContent = `Total penerima: ${data.count} mahasiswa`;
                        
                        if (data.recipients.length > 0) {
                            let listHtml = '<div class="max-h-32 overflow-y-auto">';
                            data.recipients.forEach(recipient => {
                                listHtml += `<div class="flex justify-between items-center py-1">
                                    <span>${recipient.name}</span>
                                    <span class="text-xs text-gray-500">${recipient.phone ? recipient.phone.replace(/(\d{4})\d{4}(\d{4})/, '$1****$2') : 'No phone'}</span>
                                </div>`;
                            });
                            if (data.count > 10) {
                                listHtml += `<div class="text-xs text-gray-500 py-1">... dan ${data.count - 10} lainnya</div>`;
                            }
                            listHtml += '</div>';
                            recipientList.innerHTML = listHtml;
                        } else {
                            recipientList.innerHTML = '<div class="text-sm text-red-600">Tidak ada mahasiswa yang memenuhi kriteria</div>';
                        }
                        
                        recipientPreview.classList.remove('hidden');
                    } else {
                        recipientCount.textContent = 'Error loading preview';
                        recipientList.innerHTML = '<div class="text-red-500">Gagal memuat data penerima</div>';
                        recipientPreview.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    recipientCount.textContent = 'Error loading preview: ' + error.message;
                    recipientList.innerHTML = '<div class="text-red-500">Gagal memuat data penerima: ' + error.message + '</div>';
                    recipientPreview.classList.remove('hidden');
                });
            });



            // Form validation
            form.addEventListener('submit', function(e) {
                const title = document.getElementById('title').value.trim();
                const message = document.getElementById('message').value.trim();

                if (!title || !message) {
                    e.preventDefault();
                    alert('Judul dan pesan harus diisi');
                    return;
                }

                if (message.length < 10) {
                    e.preventDefault();
                    alert('Pesan minimal 10 karakter');
                    return;
                }

                // If scheduled but send immediately is checked, clear schedule
                if (sendImmediately.checked && scheduledAt.value) {
                    scheduledAt.value = '';
                }
            });
        });
    </script>
    @endpush
</x-app-layout>

