<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ← добавить

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
        // Запрет на удаление самого себя
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Вы не можете удалить свою собственную учётную запись.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')
                         ->with('success', 'Пользователь успешно удалён');
    }

    public function ban(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Вы не можете заблокировать самого себя.');
        }

        $user->update(['is_banned' => true]);
        return redirect()->route('admin.users.index')
                         ->with('success', 'Пользователь заблокирован');
    }

    public function unban(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('admin.users.index')
                             ->with('error', 'Нельзя разблокировать самого себя (вы и так активны).');
        }

        $user->update(['is_banned' => false]);
        return redirect()->route('admin.users.index')
                         ->with('success', 'Пользователь разблокирован');
    }
}