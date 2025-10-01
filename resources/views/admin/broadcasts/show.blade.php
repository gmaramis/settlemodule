<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Broadcast Message') }}
            </h2>
            <div class="flex space-x-2">
                @if($broadcast->canBeEdited())
                    <a href="{{ route('broadcasts.edit', $broadcast) }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </a>
                @endif
                <a href="{{ route('broadcasts.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Status Banner -->
            @if($broadcast->status === 'sent')
                <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">Broadcast Berhasil Dikirim</h3>
                            <div class="mt-2 text-sm text-green-700">
                                <p>{{ $broadcast->delivery_status }}</p>
                                @if($broadcast->sent_at)
                                    <p class="mt-1">Dikirim pada: {{ $broadcast->sent_at->format('d/m/Y H:i:s') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($broadcast->status === 'sending')
                <div class="mb-6 bg-blue-50 border border-blue-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="animate-spin h-5 w-5 text-blue-400" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Broadcast Sedang Dikirim</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Pesan sedang diproses dan dikirim ke mahasiswa...</p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($broadcast->status === 'failed')
                <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Broadcast Gagal Dikirim</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <p>Terjadi kesalahan saat mengirim broadcast. Silakan coba lagi atau hubungi administrator.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Broadcast Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Title and Status -->
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $broadcast->title }}</h1>
                        <div class="mt-2 flex items-center space-x-4">
                            @php
                                $statusClasses = match($broadcast->status) {
                                    'draft' => 'bg-gray-100 text-gray-800',
                                    'sending' => 'bg-blue-100 text-blue-800',
                                    'sent' => 'bg-green-100 text-green-800',
                                    'failed' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusClasses }}">
                                {{ ucfirst($broadcast->status) }}
                            </span>
                            
                            <span class="text-sm text-gray-500">
                                Dibuat oleh {{ $broadcast->creator->name }} pada {{ $broadcast->created_at->format('d/m/Y H:i') }}
                            </span>
                        </div>
                    </div>

                    <!-- Message Content -->
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Isi Pesan</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="whitespace-pre-wrap text-gray-800">{{ $broadcast->message }}</div>
                        </div>
                    </div>

                    <!-- Target Criteria -->
                    @if($broadcast->target_criteria)
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Target Penerima</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Jenis Target</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            @if(isset($broadcast->target_criteria['target_type']))
                                                @if($broadcast->target_criteria['target_type'] === 'all')
                                                    Semua Mahasiswa
                                                @elseif($broadcast->target_criteria['target_type'] === 'specific')
                                                    Mahasiswa Tertentu
                                                @else
                                                    {{ $broadcast->target_criteria['target_type'] }}
                                                @endif
                                            @else
                                                Semua Mahasiswa
                                            @endif
                                        </dd>
                                    </div>
                                    @if(isset($broadcast->target_criteria['target_type']) && $broadcast->target_criteria['target_type'] === 'specific' && isset($broadcast->target_criteria['selected_students']))
                                        <div class="md:col-span-2">
                                            <dt class="text-sm font-medium text-gray-500">Mahasiswa Terpilih</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                @if(count($broadcast->target_criteria['selected_students']) > 0)
                                                    <div class="space-y-2">
                                                        <p class="font-medium">{{ count($broadcast->target_criteria['selected_students']) }} mahasiswa terpilih:</p>
                                                        <ul class="space-y-1">
                                                            @foreach($broadcast->target_criteria['selected_students'] as $student)
                                                                <li class="flex items-center justify-between bg-gray-100 rounded-lg p-3">
                                                                    <div>
                                                                        <div class="font-medium text-gray-900">{{ $student['name'] }}</div>
                                                                        <div class="text-sm text-gray-500">
                                                                            {{ $student['program'] }}
                                                                            @if($student['institution'])
                                                                                • {{ $student['institution'] }}
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-sm text-gray-500">
                                                                        {{ $student['phone'] }}
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <span class="text-red-600">Tidak ada mahasiswa dipilih</span>
                                                @endif
                                            </dd>
                                        </div>
                                    @endif
                                </dl>
                            </div>
                        </div>
                    @endif

                    <!-- Delivery Statistics -->
                    @if($broadcast->status === 'sent')
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Statistik Pengiriman</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="bg-green-50 rounded-lg p-4">
                                    <div class="text-2xl font-bold text-green-600">{{ $broadcast->sent_count }}</div>
                                    <div class="text-sm text-green-800">Berhasil Dikirim</div>
                                </div>
                                <div class="bg-red-50 rounded-lg p-4">
                                    <div class="text-2xl font-bold text-red-600">{{ $broadcast->failed_count }}</div>
                                    <div class="text-sm text-red-800">Gagal Dikirim</div>
                                </div>
                                <div class="bg-blue-50 rounded-lg p-4">
                                    <div class="text-2xl font-bold text-blue-600">{{ $broadcast->total_recipients }}</div>
                                    <div class="text-sm text-blue-800">Total Penerima</div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Actions -->
                    <div class="border-t pt-6">
                        <div class="flex flex-wrap gap-3">
                            @if($broadcast->canBeSent())
                                <form action="{{ route('broadcasts.send', $broadcast) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                            onclick="return confirm('Kirim broadcast sekarang?')">
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                        Kirim Sekarang
                                    </button>
                                </form>
                            @endif

                            @if($broadcast->canBeSent())
                                <!-- Test Broadcast Modal Trigger -->
                                <button type="button" 
                                        class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                        onclick="openTestModal()">
                                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Test Broadcast
                                </button>
                            @endif


                            @if($broadcast->canBeDeleted())
                                <form action="{{ route('broadcasts.destroy', $broadcast) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 border border-red-300 shadow-sm text-sm font-medium rounded-md text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                            onclick="return confirm('Hapus broadcast ini? Tindakan ini tidak dapat dibatalkan.')">
                                        <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Test Broadcast Modal -->
    <div id="testModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Test Broadcast</h3>
                <form action="{{ route('broadcasts.test', $broadcast) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="test_phone" class="block text-sm font-medium text-gray-700">Nomor Telepon Test</label>
                        <input type="text" name="test_phone" id="test_phone" 
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                               placeholder="6281234567890" 
                               pattern="^62\d{9,13}$"
                               required>
                        <p class="mt-1 text-sm text-gray-500">Format: 6281234567890 (nomor Indonesia)</p>
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" 
                                class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50"
                                onclick="closeTestModal()">
                            Batal
                        </button>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                            Kirim Test
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function openTestModal() {
            document.getElementById('testModal').classList.remove('hidden');
        }

        function closeTestModal() {
            document.getElementById('testModal').classList.add('hidden');
            document.getElementById('test_phone').value = '';
        }

        // Close modal when clicking outside
        document.getElementById('testModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeTestModal();
            }
        });
    </script>
    @endpush
</x-app-layout>
