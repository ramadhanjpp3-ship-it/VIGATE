<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccessLog;

class LogController extends Controller
{
    public function index()
    {
        $search = request('q');

        $logs = AccessLog::with('user','gate')
            ->when($search, function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('nfc_uid', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        })->orWhereHas('gate', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(20);

        return view('admin.logs.index', compact('logs'));
    }

    public function destroyMultiple(Request $request)
    {
        if ($request->has('delete_all')) {
            AccessLog::query()->delete();
            return back()->with('success', 'Semua access log berhasil dihapus.');
        }

        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return back()->with('info', 'Tidak ada log yang dipilih.');
        }

        AccessLog::whereIn('id', $ids)->delete();
        return back()->with('success', 'Log terpilih berhasil dihapus.');
    }

    public function show($id)
    {
        $log = AccessLog::findOrFail($id);
        return view('admin.logs.detail', compact('log'));
    }
}
