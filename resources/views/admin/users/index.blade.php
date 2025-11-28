<!DOCTYPE html>
<!-- resources/views/admin/users/index.blade.php -->
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление пользователями - ЛАБУБУ.МАРКЕТ</title>
    <style>
        .container { max-width: 1200px; margin: 0 auto; padding: 2rem; }
        .user-card { background: white; border: 1px solid #e5e7eb; border-radius: 8px; padding: 1.5rem; margin-bottom: 1rem; }
        .role-admin { background: #4f46e5; color: white; }
        .role-seller { background: #059669; color: white; }
        .role-user { background: #6b7280; color: white; }
        .badge { padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.875rem; }
        .alert { padding: 1rem; margin-bottom: 1rem; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .nav { display: flex; gap: 1rem; margin-bottom: 2rem; }
        .nav a { padding: 0.5rem 1rem; background: #f3f4f6; border-radius: 4px; text-decoration: none; color: #374151; }
        .nav a.active { background: #4f46e5; color: white; }
        .btn-danger { background: #ef4444; color: white; border: none; padding: 0.5rem 1rem; border-radius: 4px; cursor: pointer; }
        .btn-danger:hover { background: #dc2626; }
        .current-user { background: #fef3c7; border-color: #f59e0b; }
        select, button { padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 4px; }
        button { background: #4f46e5; color: white; cursor: pointer; }
        button:disabled { background: #9ca3af; cursor: not-allowed; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Управление пользователями</h1>

        <div class="nav">
            <a href="{{ route('admin.orders.index') }}">Заказы</a>
            <a href="{{ route('admin.users.index') }}" class="active">Пользователи</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @foreach($users as $user)
            <div class="user-card {{ $user->id === auth()->id() ? 'current-user' : '' }}">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                    <div>
                        <h3>{{ $user->name }}</h3>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Зарегистрирован:</strong> {{ $user->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <span class="badge role-{{ $user->role }}">
                        @if($user->role === 'admin')
                            Администратор
                        @elseif($user->role === 'seller')
                            Продавец
                        @else
                            Пользователь
                        @endif
                    </span>
                </div>

                <div style="display: flex; gap: 1rem; align-items: center;">
                    <form action="{{ route('admin.users.update-role', $user) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="role" {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Пользователь</option>
                            <option value="seller" {{ $user->role == 'seller' ? 'selected' : '' }}>Продавец</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Администратор</option>
                        </select>
                        <button type="submit" {{ $user->id === auth()->id() ? 'disabled' : '' }}>Изменить роль</button>
                    </form>

                    @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?')">Удалить</button>
                        </form>
                    @else
                        <span style="color: #6b7280;">(Это вы)</span>
                    @endif
                </div>
            </div>
        @endforeach

        @if($users->isEmpty())
            <p>Пользователей нет.</p>
        @endif
    </div>
</body>
</html>