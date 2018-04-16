<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use App\Permission;
use Illuminate\Http\Request;
use Laravel\FlashMessage\Facades\Flash;

class PermissionsController extends Controller
{
    /**
     * PermissionsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of Permission.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', Permission::class);

        $permissions = Permission::with('roles')->orderBy('id')->paginate(20);

        return view('permissions.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for editing Permission.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        $this->authorize('update', $permission);

        return view('permissions.permissions.edit', compact('permission'));
    }

    /**
     * Update Permission.
     *
     * @param  Request $request
     * @param int      $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $this->authorize('update', $permission);

        list($rules, $messages) = $this->getValidationRules();

        // Disable edit name of default permission
        if (Permission::isDefaultPermission($permission)) {
            unset($rules['name']);
        }

        $this->validate($request, $rules, $messages);

        $permission->fill($request->only(array_keys($rules)));

        if ($permission->save()) {
            Flash::success('Save success')->important();

            return redirect()->route('permissions.index');
        }

        Flash::error('Save error')->important();

        return redirect()->back()->withInput();
    }

    /**
     * Get permission validation
     */
    protected function getValidationRules()
    {
        $rules = [
            'name' => 'required|min:2|max:100',
            'description' => 'nullable|string',
        ];

        $messages = [];

        return [$rules, $messages];
    }
}
