<?php

namespace App\Http\Controllers\Permissions;

use App\Permission;
use App\User;
use Laravel\FlashMessage\Facades\Flash;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Mail;
use App\Mail\ChangeRole;

class UsersController extends Controller
{
    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * Display a listing of User.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', User::class);

        $users = User::orderByDesc('id')->paginate(20);

        return view('permissions.users.index', compact('users'));
    }

    /**
     * Show the form for editing User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with(['roles', 'permissions'])->findOrFail($id);

        $this->authorize('updateRoles', $user);

        $roles = Role::all()->pluck('name', 'name');
        $permissions = Permission::all()->pluck('name', 'name');

        return view('permissions.users.edit', compact('user', 'roles', 'permissions'));
    }

    /**
     * Update User in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        $this->authorize('updateRoles', $user);
        $this->validate($request, [
            'roles' => 'nullable|array',
            'permissions' => 'nullable|array',
        ]);

        $user->syncRoles($request->input('roles', []));
        $user->syncPermissions($request->input('permissions', []));

        Mail::to($user->email)->queue(new ChangeRole($user->name));

        Flash::success('Update permissions success');

        return redirect()->route('set-permissions.index');
    }
}
