<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $activeUsers = User::where('is_banned', false)->latest()->get();
        $bannedUsers = User::where('is_banned', true)->latest()->get();

        return view('admin.users.index', compact('activeUsers', 'bannedUsers'));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
                         ->with('success', 'Пользователь успешно удалён');
    }

    public function ban(User $user)
    {
        $user->update(['is_banned' => true]);
        return redirect()->route('admin.users.index')
                         ->with('success', 'Пользователь заблокирован');
    }

    public function unban(User $user)
    {
        $user->update(['is_banned' => false]);
        return redirect()->route('admin.users.index')
                         ->with('success', 'Пользователь разблокирован');
    }
}