<?php

namespace App\Observers;

use App\Models\ActivityLog;
use App\Models\User;

class UserObserver
{
    
    public function created(User $user)
    {
        $reason = session('reason', 'No reason provided'); // Ambil reason dari session

        ActivityLog::create([
            'action' => 'create',
            'model_type' => get_class($user),
            'model_id' => $user->id,
            'reason' => $reason,
            'changes' => null, // Tidak ada perubahan saat create
        ]);
        
        // Hapus reason setelah digunakan
        session()->forget('reason');
    }

    public function updated(User $user)
    {
        $reason = session('reason', 'No reason provided'); // Ambil reason dari session

        ActivityLog::create([
            'action' => 'update',
            'model_type' => get_class($user),
            'model_id' => $user->id,
            'reason' => $reason,
            'changes' => $user->getChanges(), // Menyimpan perubahan
        ]);
        
        // Hapus reason setelah digunakan
        session()->forget('reason');
    }

    public function deleted(User $user)
    {
        $reason = session('reason', 'No reason provided'); // Ambil reason dari session

        ActivityLog::create([
            'action' => 'delete',
            'model_type' => get_class($user),
            'model_id' => $user->id,
            'reason' => $reason, // Simpan alasan dari session
            'changes' => null,
        ]);

        session()->forget('reason'); // Hapus session setelah digunakan
    }


}
