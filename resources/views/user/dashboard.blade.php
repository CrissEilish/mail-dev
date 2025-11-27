@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">My Mailboxes</h1>
            <button onclick="document.getElementById('request-modal').classList.remove('hidden')"
                class="btn-primary font-bold py-2 px-4 rounded">
                Request New Mailbox
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="mailboxes-grid">
            <!-- Populated via JS -->
            <div class="bg-card p-6 rounded-lg shadow animate-pulse">
                <div class="h-4 bg-gray-700 rounded w-3/4 mb-4"></div>
                <div class="h-4 bg-gray-700 rounded w-1/2"></div>
            </div>
        </div>
    </div>

    <!-- Request Modal -->
    <div id="request-modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-card p-8 rounded-lg shadow-lg w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">Request Mailbox</h2>
            <form id="request-form">
                <div class="mb-4">
                    <label class="block text-gray-400 text-sm font-bold mb-2">Username</label>
                    <div class="flex">
                        <input type="text" name="requested_username"
                            class="w-full px-3 py-2 text-gray-900 rounded-l focus:outline-none" placeholder="john.doe"
                            required>
                        <span class="bg-gray-700 text-white px-3 py-2 rounded-r flex items-center">@example.com</span>
                    </div>
                    <input type="hidden" name="domain" value="example.com">
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="document.getElementById('request-modal').classList.add('hidden')"
                        class="mr-2 text-gray-400 hover:text-white">Cancel</button>
                    <button type="submit" class="btn-primary font-bold py-2 px-4 rounded">Submit</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        fetch('/api/mailboxes')
            .then(r => r.json())
            .then(data => {
                const grid = document.getElementById('mailboxes-grid');
                if (data.length === 0) {
                    grid.innerHTML = '<p class="text-gray-500 col-span-3 text-center">No mailboxes found.</p>';
                    return;
                }
                grid.innerHTML = data.map(box => `
                    <div class="bg-card p-6 rounded-lg shadow border border-gray-700">
                        <h3 class="text-xl font-bold text-white mb-2">${box.email}</h3>
                        <p class="text-gray-400 text-sm mb-4">Status: <span class="text-green-400">${box.status}</span></p>
                        <div class="bg-gray-900 p-3 rounded text-xs font-mono mb-4">
                            Host: mail.example.com<br>
                            User: ${box.email}<br>
                            Pass: **********
                        </div>
                        <button onclick="alert('Password: ' + '${box.password_encrypted}'.substring(0,8) + '... (Decryption handled by API)')" class="text-blue-400 text-sm hover:underline">Show Credentials</button>
                        <a href="#" class="float-right text-purple-400 text-sm hover:underline">Open Webmail</a>
                    </div>
                `).join('');
            });

        document.getElementById('request-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch('/api/request-mailbox', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(Object.fromEntries(formData))
            })
                .then(r => r.json())
                .then(d => {
                    alert('Request submitted!');
                    document.getElementById('request-modal').classList.add('hidden');
                });
        });
    </script>
@endsection