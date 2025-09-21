<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Broadcast Message') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('broadcasts.show', $broadcast) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('broadcasts.update', $broadcast) }}" method="POST" id="broadcastForm">
                        @csrf
                        @method('PUT')
                        
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
                                           value="{{ old('title', $broadcast->title) }}" required>
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
                                              required>{{ old('message', $broadcast->message) }}</textarea>
                                    @error('message')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    <p class="mt-2 text-sm text-gray-500">Minimal 10 karakter</p>
                                </div>
                            </div>
                        </div>

                        <!-- Target Criteria -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Target Penerima</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Role -->
                                <div>
                                    <label for="target_criteria[role]" class="block text-sm font-medium text-gray-700">Role</label>
                                    <select name="target_criteria[role]" id="target_criteria[role]" 
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="all" {{ old('target_criteria.role', $broadcast->target_criteria['role'] ?? 'all') === 'all' ? 'selected' : '' }}>Semua Mahasiswa</option>
                                        <option value="student" {{ old('target_criteria.role', $broadcast->target_criteria['role'] ?? '') === 'student' ? 'selected' : '' }}>Mahasiswa Saja</option>
                                    </select>
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


                        <!-- Actions -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('broadcasts.show', $broadcast) }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Batal
                            </a>
                            
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Broadcast
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('broadcastForm');
            const previewBtn = document.getElementById('previewRecipients');
            const recipientPreview = document.getElementById('recipientPreview');
            const recipientCount = document.getElementById('recipientCount');
            const recipientList = document.getElementById('recipientList');

            // Preview recipients functionality
            previewBtn.addEventListener('click', function() {
                const formData = new FormData();
                formData.append('target_criteria[role]', document.getElementById('target_criteria[role]').value);

                fetch('{{ route("broadcasts.preview-recipients") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
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
