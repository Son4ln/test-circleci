<?php

namespace App\Http\Controllers\Permissions;

use App\Role;
use App\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Role::class);

        $roles = Role::orderBy('id')->paginate(20);

        return view('permissions.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating new Role.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Role::class);

        $role = new Role();
        $permissions = Permission::get()->pluck('name', 'name');
        $isDefaultRole = false;

        return view('permissions.roles.form', compact('role', 'permissions', 'isDefaultRole'));
    }

    /**
     * Store a newly created Role in storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Role::class);

        list($rules, $messages) = $this->getValidationRules();
        $this->validate($request, $rules, $messages);

        $role = Role::create($request->except('permissions'));
        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index');
    }


    /**
     * Show the form for editing Role.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $this->authorize('update', $role);
        $permissions = Permission::get()->pluck('name', 'name');
        $isDefaultRole = Role::isDefaultRole($role);

        return view('permissions.roles.form', compact('role', 'permissions', 'isDefaultRole'));
    }

    /**
     * Update Role in storage.
     *
     * @param  Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $this->authorize('update', $role);

        list($rules, $messages) = $this->getValidationRules();

        // Disable edit name of default role
        $isDefaultRole = Role::isDefaultRole($role);
        if ($isDefaultRole) {
            unset($rules['name']);
        }

        $this->validate($request, $rules, $messages);

        // Disable edit name of default role
        if (!$isDefaultRole) {
            $role->update([
                'name' => $request->input('name'),
            ]);
        }

        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        return redirect()->route('roles.index');
    }


    /**
     * Remove Role from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', Role::class);

        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('roles.index');
    }

    /**
     * Get permission validation
     */
    public function getValidationRules()
    {
        $rules = [
            'name' => 'required|min:2|max:100',
            //'description' => 'nullable|string',
            'permissions' => 'nullable|array',
        ];

        $messages = [

        ];

        return [$rules, $messages];
    }
}
