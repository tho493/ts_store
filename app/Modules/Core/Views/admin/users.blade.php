@extends('core::admin.layout')

@section('page_title', 'Quản lý tài khoản')

@section('admin_content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h3 class="text-lg font-bold text-[#111111] font-outfit uppercase">Danh sách tài khoản</h3>
        <p class="text-xs text-[#666666] mt-1">Quản lý trạng thái, vai trò và thông tin người dùng</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="bg-[#111111] hover:bg-[#2E9F5B] text-white text-xs font-semibold uppercase tracking-wider px-4 py-2.5 rounded transition-colors cursor-pointer">
        + Thêm tài khoản mới
    </a>
</div>

<div class="bg-white border border-[#ECECEC] rounded-lg shadow-sm">
    <!-- Header & Search -->
    <div class="p-6 border-b border-[#ECECEC] flex flex-wrap items-center justify-between gap-4">
        <form action="{{ route('admin.users') }}" method="GET" class="flex gap-2 w-full max-w-sm">
            <input type="text" name="search" value="{{ $search }}" placeholder="Tìm tên, email hoặc vai trò..." class="flex-1 bg-[#F7F7F7] border border-[#ECECEC] rounded px-3 py-1.5 text-xs text-[#111111] focus:outline-none focus:border-[#2E9F5B]">
            <button type="submit" class="bg-[#111111] hover:bg-[#2E9F5B] text-white text-xs font-semibold px-4 py-1.5 rounded transition-colors cursor-pointer">
                Tìm
            </button>
            @if(!empty($search))
                <a href="{{ route('admin.users') }}" class="border border-[#ECECEC] hover:bg-[#F7F7F7] text-[#666666] text-xs font-semibold px-3 py-1.5 rounded flex items-center justify-center">
                    Xóa
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs border-collapse">
            <thead>
                <tr class="bg-[#F7F7F7] text-[#666666] font-semibold border-b border-[#ECECEC] uppercase tracking-wider">
                    <th class="p-4 w-12">ID</th>
                    <th class="p-4">Tài khoản</th>
                    <th class="p-4">Email</th>
                    <th class="p-4 w-32 text-center">Vai trò</th>
                    <th class="p-4 w-32 text-center">Trạng thái</th>
                    <th class="p-4 w-40">Ngày tham gia</th>
                    <th class="p-4 w-40 text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#ECECEC]">
                @forelse($users as $user)
                    <tr class="hover:bg-[#F7F7F7]/50 transition">
                        <td class="p-4 text-[#666666] font-mono">#{{ $user->id }}</td>
                        <td class="p-4 font-semibold text-[#111111]">{{ $user->name }}</td>
                        <td class="p-4 text-[#666666]">{{ $user->email }}</td>
                        <td class="p-4 text-center">
                            @if($user->role === 'admin')
                                <span class="bg-[#F0FDF4] text-[#2E9F5B] border border-[#D1FAE5] px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                                    Admin
                                </span>
                            @else
                                <span class="bg-gray-100 text-gray-700 border border-gray-200 px-2 py-0.5 rounded text-[10px] font-semibold uppercase tracking-wider">
                                    Khách hàng
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-center">
                            @if($user->status === 'active')
                                <span class="bg-emerald-50 text-emerald-700 border border-emerald-200 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                                    Hoạt động
                                </span>
                            @else
                                <span class="bg-red-50 text-red-700 border border-red-200 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                                    Bị khóa
                                </span>
                            @endif
                        </td>
                        <td class="p-4 text-[#666666]">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        <td class="p-4 text-right flex justify-end gap-3 items-center">
                            @if($user->id !== Auth::id())
                                <!-- Toggle status -->
                                <form action="{{ route('admin.users.toggle_status', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-xs font-semibold cursor-pointer {{ $user->status === 'active' ? 'text-amber-600 hover:text-amber-800' : 'text-emerald-600 hover:text-emerald-800' }}">
                                        {{ $user->status === 'active' ? 'Khóa' : 'Mở khóa' }}
                                    </button>
                                </form>

                                <!-- Edit link -->
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                    Sửa
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa tài khoản này? Thao tác này không thể hoàn tác.')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold cursor-pointer">
                                        Xóa
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                    Sửa thông tin
                                </a>
                                <span class="text-[#CCCCCC] cursor-not-allowed font-medium">Bản thân</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-[#666666]">
                            Không tìm thấy tài khoản nào phù hợp.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div class="p-6 border-t border-[#ECECEC]">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection
