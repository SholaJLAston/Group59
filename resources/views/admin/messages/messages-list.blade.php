@extends('layouts.admin')

@section('title', 'Customer Messages')
@section('page-title', 'Customer Messages')

@section('content')
<div style="background:#fff;border:1px solid #ddd;padding:16px;">
    @if(session('status'))
        <div style="margin-bottom:10px;color:#166534;">{{ session('status') }}</div>
    @endif

    <form method="GET" action="{{ route('admin.messages.index') }}" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;">
        <input name="q" value="{{ request('q') }}" placeholder="Search name, email, subject, message" style="padding:8px 10px;border:1px solid #ccc;min-width:280px;">
        <select name="status" style="padding:8px 10px;border:1px solid #ccc;">
            <option value="">All statuses</option>
            <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
            <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
            <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>Resolved</option>
        </select>
        <button type="submit" style="border:none;background:#111;color:#fff;padding:8px 12px;">Filter</button>
    </form>

    <div style="overflow:auto;">
        <table style="width:100%;border-collapse:collapse;min-width:960px;">
            <thead>
                <tr>
                    <th style="padding:10px;border-bottom:1px solid #ddd;text-align:left;">Name</th>
                    <th style="padding:10px;border-bottom:1px solid #ddd;text-align:left;">Email</th>
                    <th style="padding:10px;border-bottom:1px solid #ddd;text-align:left;">Subject</th>
                    <th style="padding:10px;border-bottom:1px solid #ddd;text-align:left;">Message</th>
                    <th style="padding:10px;border-bottom:1px solid #ddd;text-align:left;">Created</th>
                    <th style="padding:10px;border-bottom:1px solid #ddd;text-align:left;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($messages as $message)
                    <tr>
                        <td style="padding:10px;border-bottom:1px solid #eee;">{{ $message->name }}</td>
                        <td style="padding:10px;border-bottom:1px solid #eee;">{{ $message->email }}</td>
                        <td style="padding:10px;border-bottom:1px solid #eee;">{{ $message->subject }}</td>
                        <td style="padding:10px;border-bottom:1px solid #eee;max-width:420px;">{{ $message->message }}</td>
                        <td style="padding:10px;border-bottom:1px solid #eee;white-space:nowrap;">{{ $message->created_at->format('d M Y H:i') }}</td>
                        <td style="padding:10px;border-bottom:1px solid #eee;">
                            <form method="POST" action="{{ route('admin.messages.status', $message) }}" style="display:flex;gap:8px;">
                                @csrf
                                @method('PATCH')
                                <select name="status" style="padding:6px 8px;border:1px solid #ccc;">
                                    <option value="new" {{ $message->status === 'new' ? 'selected' : '' }}>New</option>
                                    <option value="in_progress" {{ $message->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="resolved" {{ $message->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                </select>
                                <button type="submit" style="border:none;background:#d88411;color:#fff;padding:6px 10px;">Save</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="padding:10px;">No customer messages found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:12px;">{{ $messages->links() }}</div>
</div>
@endsection


