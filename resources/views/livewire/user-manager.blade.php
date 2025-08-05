<div class="container-fluid mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-teal text-white d-flex align-items-center gap-1">
                    <i class="bi bi-plus-lg"></i> Add User
                </button>
                <button class="btn btn-danger d-flex align-items-center gap-1">
                    <i class="bi bi-trash"></i> Bulk delete
                </button>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-danger btn-sm" title="Export PDF">
                    <i class="bi bi-file-earmark-pdf"></i>
                </button>
                <button class="btn btn-warning btn-sm" title="Export Excel">
                    <i class="bi bi-file-earmark-spreadsheet"></i>
                </button>
                <button class="btn btn-primary btn-sm" title="Print">
                    <i class="bi bi-printer"></i>
                </button>
                <button class="btn btn-purple btn-sm" title="View">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="mb-3 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <label for="perPage" class="mb-0">Records per page</label>
                    <select id="perPage" wire:model="perPage" class="form-select form-select-sm w-auto">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <label for="search" class="mb-0">Search</label>
                    <input id="search" type="text" wire:model.debounce.300ms="search" class="form-control form-control-sm" placeholder="Search...">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle table-striped table-bordered text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th><input type="checkbox"></th>
                            <th>User</th>
                            <th>Contact</th>
                            <th>Login Info</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td><input type="checkbox"></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff" alt="Avatar" class="rounded-circle" width="40" height="40">
                                    <div>
                                        <a href="#" class="fw-bold text-primary">{{ $user->name }}</a><br>
                                        <small class="text-muted">Username: {{ Str::slug($user->name, '_') }}</small><br>
                                        <span class="badge bg-secondary text-lowercase">Role: {{ strtolower($user->role) }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div><i class="bi bi-envelope me-1"></i>{{ $user->email }}</div>
                                <div><i class="bi bi-telephone me-1"></i>{{ $user->phone ?? 'N/A' }}</div>
                            </td>
                            <td>
                                <div>Last Login Date : {{ $user->last_login_at ?? '' }}</div>
                                <div>Last Login IP : {{ $user->last_login_ip ?? '' }}</div>
                            </td>
                            <td><span class="badge bg-success">Active</span></td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-primary me-1" wire:click="edit({{ $user->id }})" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger me-1" wire:click="delete({{ $user->id }})" title="Delete">
                                    <i class="bi bi-x"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if ($users->isEmpty())
                    <div class="text-center text-muted my-4">No users found.</div>
                @endif
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
