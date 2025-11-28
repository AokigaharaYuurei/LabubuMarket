<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        // Проверка прав администратора
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Доступ запрещен');
        }

        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Update the user role.
     */
    public function updateRole(Request $request, User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Дoступ запрещен');
        }

        // Нельзя изменять свою собственную роль
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Вы не можете изменить свою собственную роль');
        }

        $request->validate([
            'role' => ['required', Rule::in(['admin', 'seller', 'user'])]
        ]);

        $user->update([
            'role' => $request->role
        ]);

        return redirect()->back()->with('success', 'Роль пользователя обновлена');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Дoступ запрещен');
        }

        // Нельзя удалить самого себя
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Вы не можете удалить свой собственный аккаунт');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Пользователь удален');
    }
}