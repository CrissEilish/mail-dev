@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-8">Admin Dashboard</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-card p-6 rounded-lg shadow">
                <h3 class="text-gray-400 text-sm uppercase">Pending Requests</h3>
                <p class="text-3xl font-bold mt-2" id="pending-count">Loading...</p>
            </div>
            <div class="bg-card p-6 rounded-lg shadow">
                <h3 class="text-gray-400 text-sm uppercase">Active Mailboxes</h3>
                <p class="text-3xl font-bold mt-2">--</p>
            </div>
            <div class="bg-card p-6 rounded-lg shadow">
                <h3 class="text-gray-400 text-sm uppercase">System Status</h3>
                <p class="text-3xl font-bold mt-2 text-green-500">Online</p>
            </div>
        </div>

        <div class="bg-card p-6 rounded-lg shadow">
            <h2 class="text-xl font-bold mb-4">Mailbox Requests</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr>
                            <th class="p-3 border-b border-gray-700">User</th>
                            <th class="p-3 border-b border-gray-700">Requested Email</th>
                            <th class="p-3 border-b border-gray-700">Status</th>
                            <th class="p-3 border-b border-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="requests-table-body">
                        <!-- Populated via JS for demo purposes since we don't have full DB connection in this env -->
                        <tr>
                            <td class="p-3 border-b border-gray-800" colspan="4">Loading requests...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Simple fetch to our API
        fetch('/api/admin/requests', {
            headers: {
                'Accept': 'application/json',
                // 'Authorization': 'Bearer ...' // In real app, handle token or session auth
            }
        })
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.json();
            })
            .then(data => {
                const tbody = document.getElementById('requests-table-body');
                document.getElementById('pending-count').innerText = data.length;

                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="4" class="p-3 text-center text-gray-500">No pending requests</td></tr>';
                    return;
                }

                tbody.innerHTML = data.map(req => `
                <tr>
                    <td class="p-3 border-b border-gray-800">${req.user ? req.user.name : 'Unknown'}</td>
                    <td class="p-3 border-b border-gray-800">${req.requested_username}@${req.domain}</td>
                    <td class="p-3 border-b border-gray-800"><span class="px-2 py-1 rounded bg-yellow-600 text-xs">${req.status}</span></td>
                    <td class="p-3 border-b border-gray-800">
                        <button onclick="approveRequest(${req.id})" class="text-green-400 hover:text-green-300 mr-2">Approve</button>
                        <button onclick="rejectRequest(${req.id})" class="text-red-400 hover:text-red-300">Reject</button>
                    </td>
                </tr>
            `).join('');
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('requests-table-body').innerHTML = '<tr><td colspan="4" class="p-3 text-center text-red-500">Error loading requests (API might not be reachable)</td></tr>';
                document.getElementById('pending-count').innerText = 'Err';
            });

        function approveRequest(id) {
            if (!confirm('Approve this mailbox?')) return;
            fetch(`/api/admin/requests/${id}/approve`, { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
                .then(r => r.json())
                .then(d => { alert(d.message || 'Done'); location.reload(); });
        }
    </script>
@endsection