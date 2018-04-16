<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Flash;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    /**
     * Create controller instance
     */
    public function __construct()
    {
        $this->middleware(['role:admin', 'auth']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all()->pluck('name', 'name');

        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $rules = $this->getStoreRules();
        // validate data
        $this->validate($request, $rules);

        $data = $request->except('_token', 'skills', 'roles', 'password_confirmation');

        if ($data['created_at']) {
            $data['created_at'] = str_replace('/', '-', $data['created_at']) . ' ' . date('H:i:s');
        } elseif ($data['created_at'] == '') {
        } else {
            unset($data['created_at']);
        }

        if ($data['activated_at']) {
            $data['activated_at'] = str_replace('/', '-', $data['activated_at']) . ' ' . date('H:i:s');
        } else {
            unset($data['activated_at']);
        }

        $data['password'] = bcrypt($data['password']);
        $data['enabled']  = $request->enabled;
        // Process save user photo
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->storePublicly('avatars', 's3');
        } else {
            unset($data['photo']);
        }

        // Process save user background
        if ($request->hasFile('background')) {
            $data['background'] = $request->file('background')->storePublicly('background', 's3');
        } else {
            unset($data['background']);
        }

        $user = User::firstOrNew(['email' => $data['email']]);
        $user->fill($data);
        $user->saveOrFail();
        if ($request->has('skills')) {
            $data += [
                'impossible' => 1,
                'searched' => 1,
            ];
            $skills = $request->input('skills') ?? [];
            foreach ($skills as $skill) {
                $user->userSkills()->create([
                    'kind' => $skill
                ]);
            }
        }

        if ($request->roles) {
            $user->assignRole($request->roles);
        }

        Flash::success(__('flash_messages.user_management.store_success'))->important();

        return redirect()->route('admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = $id ?? Auth::id();

        $user = User::findOrFail($id);
        $skills = $user->userSkills->pluck('kind')->all() ?? [];
        $roles = Role::all()->pluck('name', 'name');

        return view('admin.users.show', compact('user', 'skills', 'roles'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /** @var User $user */
        $user = User::findOrFail($id);

        // validate rules
        $rules = $this->getValidateRules($user);
        // validate data
        $this->validate($request, $rules);

        $data = $request->except('_token', 'skills', 'password_confirmation', 'roles');
        $createdDate = $user->created_at ? $user->created_at->format('Y/m/d') : '';
        if ($data['created_at'] && $data['created_at'] != $createdDate) {
            $data['created_at'] = str_replace('/', '-', $data['created_at']) . ' ' . date('H:i:s');
        } elseif ($data['created_at'] == '') {
        } else {
            unset($data['created_at']);
        }
        $activatedDate = $user->activated_at ? $user->activated_at->format('Y/m/d') : '';
        if ($data['activated_at'] && $data['activated_at'] != $activatedDate) {
            $data['activated_at'] = str_replace('/', '-', $data['activated_at']) . ' ' . date('H:i:s');
        } elseif ($data['activated_at'] == '') {
        } else {
            unset($data['activated_at']);
        }

        if ($request->has('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }
        // Process save user photo
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->storePublicly('avatars', 's3');
            if ($user->photo) {
                Storage::disk('s3')->delete($user->photo);
            }
        } else {
            unset($data['photo']);
        }

        // Process save user background
        if ($request->hasFile('background')) {
            $data['background'] = $request->file('background')->storePublicly('background', 's3');
            if ($user->background) {
                Storage::disk('s3')->delete($user->background);
            }
        } else {
            unset($data['background']);
        }

        // TODO: confirm with customer: Is this code required ?
        if ($user->isCreator()) {
            $data += [
                'impossible' => 1,
                'searched' => 1,
            ];
        }

        if (isset($data['agreement'])) unset($data['agreement']);
        $user->fill($data);
        $user->saveOrFail();
        $roles = $request->roles ?? [];
        $user->syncRoles($roles);
        if ($request->has('skills')) {
            $user->userSkills()->delete();
            foreach ($request->input('skills') as $skill) {
                $user->userSkills()->create([
                    'kind' => $skill
                ]);
            }
        }

        Flash::success(__('flash_messages.user_management.update_success'))->important();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get store validate rules
     */
    public function getStoreRules()
    {
        return [
            'email'       => 'required|email|activated_user_unique:users',
            'name'        => 'required|max:255',
            'password'    => 'required|min:6|max:255|confirmed|new_rule_password:users'
        ];
    }

    /**
     * @return array
     */
    protected function getValidateRules($user)
    {
        return [
            'email' => 'required|email|unique:users,email,'.$user->id,
            'name'  => 'required|max:255',
            'password' => 'nullable|confirmed|new_rule_password:users'
        ];
    }
}
