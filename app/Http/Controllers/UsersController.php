<?php

namespace App\Http\Controllers;

use App\Events\UserWantBecomeCreator;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\FlashMessage\Facades\Flash;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use App\Repositories\UserRepository;
use Mail;
use App\Mail\UpgradeCreator;
use App\Events\EmailShouldBeSent;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManagerStatic as Image;
use Hash;
use Auth;

class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $repository;

    protected $allowUpgradeRoles = [
        'client',
        'creator',
    ];

    /**
     * Constructor
     */
    public function __construct(UserRepository $repository)
    {
        $this->middleware('auth');
        $this->repository = $repository;
        Validator::extend('old_password', function ($attribute, $value, $parameters) {
            return Hash::check($value, Auth::user()->password);
        });
    }

    /**
     * @param Request $request
     * @param string $role
     * @return \Illuminate\Http\Response
     */
    public function upgradeAccount(Request $request, $role)
    {
        abort_unless(in_array($role, $this->allowUpgradeRoles), 404);

        /** @var User $user */
        $user = $request->user();
        if ($user->hasRole($role)) {
            return redirect($request->session()->get('callback_url', '/'));
        }

        return view("users.upgrade.{$role}", compact('user'));
    }

    /**
     * @param Request $request
     * @param string $tab
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request, $tab = 'basic')
    {
        return view('users.edit', [
            'user' => $request->user(),
            'tab' => $tab,
        ]);
    }

    /**
     * Save action
     *
     * @param Request $request
     * @param string $tab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tab = 'basic')
    {
        
        // validate rules
        $rules = $this->getValidateRules($tab);
        /** @var User $user */
        $user = $request->user();
        if ($request->has('homepage') && $request->homepage == 'http://') {
            unset($rules['homepage']);
        }
        if (strpos($request->headers->get('referer'), 'profile')) {
            if($user->isCreator()){
                unset($rules['agreement'], $rules['nda']);
            }
        }

        // validate data
        $this->validate($request, $rules);

        if ($tab == 'account') {
            $user->update(['password' => bcrypt($request->input('password'))]);
            Flash::success(__('flash_messages.users.change_password_success'))->important();
            return redirect()->back();
        }

        $data = $request->only(array_keys($rules));

        // Process save user photo
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->storePublicly('avatars', 's3');
            $data['photo_thumbnail'] = $this->storeS3Publicly('avatars/thumbnails', $request->file('photo'));
            if ($user->photo) {
                Storage::disk('s3')->delete($user->photo);
            }
            if ($user->photo_thumbnail) {
                Storage::disk('s3')->delete($user->photo_thumbnail);
            }
        } else {
            unset($data['photo']);
        }

        // Process save user background
        if ($request->hasFile('background')) {
            $data['background'] = $request->file('background')->storePublicly('background', 's3');
            $data['background_thumbnail'] = $this->storeS3Publicly('background/thumbnails', $request->file('background'), 400);
            if ($user->background) {
                Storage::disk('s3')->delete($user->background);
            }
            if ($user->background_thumbnail) {
                Storage::disk('s3')->delete($user->background_thumbnail);
            }
        } else {
            unset($data['background']);
        }

        // TODO: confirm with customer: Is this code required ?
        if ($tab == 'creator') {
            $data += [
                'impossible' => 1,
                'searched' => 1,
            ];
            $skills = $data['skills'];
            unset($data['skills']);
        }

        if (isset($data['agreement'])) unset($data['agreement']);
        if (isset($data['nda'])) unset($data['nda']);
        $user->fill($data);
        $user->saveOrFail();
        if ($tab == 'creator' && $skills) {
            $user->userSkills()->where('id', $user->id)->delete();
            foreach ($skills as $skill) {
                $user->userSkills()->create([
                    'kind' => $skill
                ]);
            }
        }

        // Process upgrade account
        if (in_array($tab, $this->allowUpgradeRoles) && !$user->hasRole($tab)) {
            $result = $this->processUpgradeAccount($user, $tab);
            if ($result) {
                return $result;
            }
        }


        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        Flash::success(__('flash_messages.users.update_success'))->important();

        return redirect()->back();
    }

    public function storeS3Publicly($path, $photo, $width = 100)
    {
        $fileName = $path . '/' . auth()->id() . '_' . $photo->getClientOriginalName();
        $photoThumbnail = Image::make($photo)->resize($width, null, function($constraint) {
            $constraint->aspectRatio();
        })->stream();
        Storage::disk('s3')
            ->put($fileName, $photoThumbnail->__toString(), 'public');

        return $fileName;
    }

    /**
     * Process Upgrade Account
     *
     * @param User $user
     * @param string $role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|null
     */
    protected function processUpgradeAccount(User $user, $role)
    {
        $user->assignRole($role);

        // Required Admin approved
        if ($role == 'creator') {
            $user->update(['is_creator' => 1]);
            event(new EmailShouldBeSent(new UpgradeCreator($user->name)));
            // Send email for Admin
            event(new UserWantBecomeCreator($user));

            return view('users.upgrade.pending');
        }

        if ($role == 'client') {
            Flash::success(__('users.upgrade.register_client_success'))->important();
            return redirect()->to('/');
        }
    }

    /**
     * @param string $group
     * @return array
     */
    protected function getValidateRules($group = 'basic')
    {
        switch (strtolower($group)) {
            case 'account':
                return [
                    'old_password' => 'old_password|min:6',
                    'password'     => 'required|confirmed|min:8|new_rule_password:users',

                ];
            case 'bank':
                return [
                    'bank'         => 'nullable|max:30',
                    'branch'       => 'nullable|max:30',
                    'account_kind' => '',
                    'account_no'   => 'nullable|max:8',
                    'holder'       => 'nullable|max:255',
                    'holder_ruby'  => 'nullable|max:255'
                ];
            case 'client':
                return [
                    'name' => 'required|max:255',
                    'ruby' => 'required|max:255',
                    'tel' => 'required|numeric|digits_between:10,12',
                    'zip' => 'required|numeric|digits:7',
                    'address' => 'required|max:255',
                    'homepage' => 'required|max:255',
                    'company' => 'max:255',
                    'department' => 'max:255',
                ];
            case 'creator':
                return [
                    'name'       => 'required|max:255',
                    'ruby'       => 'required|max:255',
                    'tel'        => 'required|numeric|digits_between:10,12',
                    //'zip'      => 'required|numeric|digits:7',
                    //'address'  => 'required|max:255',
                    //'birth'    => 'required|date_format:Y/m/d',
                    'team'       => 'max:255',
                    'career'     => 'required:max:32000',
                    'record'     => 'required:max:32000',
                    'motive'     => 'max:255',
                    'knew_sales' => 'max:200',
                    'knew_other' => 'max:200',
                    'knew'       => '',
                    'base'       => '',
                    'sex'        => '',
                    'group'      => '',
                    'agreement'  => 'required|accepted',
                    'nda'        => 'required|accepted',
                    'skills'     => 'required',
                    'birth'      => 'required|date'
                ];
            case 'basic':
            default:
                // default $tab = basic
                return [
                    'name' => 'required|max:255',
                    'ruby' => 'required|max:255',
                    'tel' => 'required|numeric|digits_between:10,12',
                    'zip' => 'required|numeric|digits:7',
                    'address' => 'required|max:255',
                    //'birth' => 'required|date_format:Y/m/d',
                    'company' => 'nullable|max:255',
                    'department' => 'nullable|max:255',
                    'searched' => 'nullable',
                    'nickname' => 'nullable|max:20',
                    'catchphrase' => 'nullable',
                    'photo' => 'nullable',
                    'background' => 'nullable',
                    'homepage' => 'nullable|url',
                ];
        }
    }

    /**
     * Get users list
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $usersPerPage = 10;

        $filters = $request->except('_token');

        $users = $this->repository->getAllUsers($filters)->paginate($usersPerPage);

        return view('admin.partials.users_list', compact('users'));
    }

    /**
     * Show user details
     *
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->repository->findOrFail($id);

        return view('users.show', compact('user'));
    }

    /**
     * Change user email
     *
     * @param Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function changeEmail(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'old_email'          => 'email|in:' . $user->email,
            'email'              => 'email|confirmed|unique:users,email,' . $user->id,
            'email_confirmation' => 'email'
        ], [
            'old_email.in' => 'メールが正しくありません'
        ]);

        $user->fill(['email' => $request->input('email')]);
        $user->save();

        Mail::to($request->input('email'))
            ->queue(new \App\Mail\EmailChanged($user->name));
        Flash::success(__('flash_messages.users.change_email_success'))->important();

        return redirect()->back();
    }
}
