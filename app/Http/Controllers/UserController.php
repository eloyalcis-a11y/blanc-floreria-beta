<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * Alta y baja de cuentas del personal. El registro público está deshabilitado
 * (ver routes/auth.php): las cuentas sólo se crean desde aquí, y sólo un admin.
 */
class UserController extends Controller
{
    /** Roles que entiende la app; el menú lateral se arma con estos valores. */
    public const ROLES = [
        'admin' => 'Administrador',
        'ventas' => 'Ventas',
        'operacion' => 'Operación',
        'cliente' => 'Cliente',
    ];

    private function soloAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->role === 'admin', 403);
    }

    public function index()
    {
        $this->soloAdmin();

        return view('users.index', [
            'users' => User::orderBy('username')->get(),
            'roles' => self::ROLES,
        ]);
    }

    public function create()
    {
        $this->soloAdmin();

        return view('users.create', ['roles' => self::ROLES]);
    }

    public function store(Request $request)
    {
        $this->soloAdmin();

        $datos = $request->validate($this->reglas(), $this->mensajes());

        $datos['password'] = Hash::make($datos['password']);

        User::create($datos);

        return redirect()->route('users.index')->with('success', 'Usuario creado.');
    }

    public function edit(User $user)
    {
        $this->soloAdmin();

        return view('users.edit', ['user' => $user, 'roles' => self::ROLES]);
    }

    public function update(Request $request, User $user)
    {
        $this->soloAdmin();

        $datos = $request->validate($this->reglas($user), $this->mensajes());

        // La contraseña sólo se toca si se escribió una nueva.
        if (empty($datos['password'])) {
            unset($datos['password']);
        } else {
            $datos['password'] = Hash::make($datos['password']);
        }

        // Un admin no puede quitarse a sí mismo el rol y quedarse sin acceso.
        if ($user->id === auth()->id() && $datos['role'] !== 'admin') {
            return back()->withInput()->withErrors([
                'role' => 'No puedes quitarte a ti mismo el rol de administrador.',
            ]);
        }

        $user->update($datos);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado.');
    }

    public function destroy(User $user)
    {
        $this->soloAdmin();

        if ($user->id === auth()->id()) {
            return back()->withErrors(['user' => 'No puedes eliminar tu propia cuenta.']);
        }

        if ($user->role === 'admin' && User::where('role', 'admin')->count() <= 1) {
            return back()->withErrors(['user' => 'Debe quedar al menos un administrador.']);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado.');
    }

    /** @param User|null $user Se pasa al editar, para excluirlo de los unique. */
    private function reglas(?User $user = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required', 'string', 'max:50', 'alpha_dash',
                Rule::unique('users', 'username')->ignore($user?->id),
            ],
            'email' => [
                'nullable', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user?->id),
            ],
            'role' => ['required', Rule::in(array_keys(self::ROLES))],
            // Al crear es obligatoria; al editar, opcional (vacío = no cambiar).
            'password' => [$user ? 'nullable' : 'required', 'confirmed', Password::min(8)],
        ];
    }

    private function mensajes(): array
    {
        return [
            'username.alpha_dash' => 'El usuario sólo puede tener letras, números, guiones y guiones bajos.',
            'username.unique' => 'Ese nombre de usuario ya está ocupado.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ];
    }
}
