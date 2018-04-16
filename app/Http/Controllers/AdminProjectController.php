<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use Flash;
use Carbon\Carbon;
use Storage;

class AdminProjectController extends Controller
{
    /**
     * ProjectsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    /**
     * 仕事を依頼
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('admin.projects.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = Project::findOrFail($id);

        return view('admin.projects.edit', compact('project'));
    }

    /**
     * 仕事を依頼
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = $this->getValidateRules('create');
        $this->validate($request, $rules);

        // Check unset duedate
        $data = $request->only(array_keys($rules));
        if (!empty($data['is_duedate_undecided'])) {
            unset($data['duedate_at']);
        } else {
            $data['duedate_at'] = Carbon::parse($data['duedate_at']);
        };
        unset($data['is_duedate_undecided']);

        if (!empty($data['is_price_undecided'])) {
            unset($data['price_min'], $data['price_max']);
        } else {
            unset($data['is_price_undecided']);
        }

        // Check empty place_pref
        $data['is_place_pref_undecided'] = empty($data['place_pref']) ? 1 : 0;

        $data['attachments'] = $this->uploadAttachments($request->file('attachments'));
        unset($data['image']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->image->storePublicly('project-images/'.auth()->id(), 's3');
        }

        $project = new Project($data);
        $project->user_id = $request->user()->id;

        if ($project->saveOrFail()) {
            Flash::success(__('flash_messages.admin_projects.store_success'))->important();

            return redirect()->route('project-states.index', ['status' => $project->status]);
        }

        Flash::error(__('flash_messages.admin_projects.store_error'));

        return redirect()->back()->withInput();
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
        $project = Project::findOrFail($id);

        $rules = $this->getValidateRules();
        $this->validate($request, $rules);

        // Check unset duedate
        $data = $request->only(array_keys($rules));
        if (!empty($data['is_duedate_undecided'])) {
            $data['duedate_at'] = null;
        } else {
            $data['duedate_at'] = Carbon::parse($data['duedate_at']);
        }
        unset($data['is_duedate_undecided']);

        if (!empty($data['is_price_undecided'])) {
            unset($data['price_min'], $data['price_max']);
        } else {
            unset($data['is_price_undecided']);
        }

        unset($data['image']);
        if ($request->hasFile('image')) {
            $data['image'] = $request->image->storePublicly('project-images/'.auth()->id(), 's3');
            Storage::disk('s3')->delete($project->image);
        }

        // Check empty place_pref
        $data['is_place_pref_undecided'] = empty($data['place_pref']) ? 1 : 0;

        $data['attachments'] = $this->uploadAttachments($request->file('attachments'));
        if (empty($data['attachments'])) {
            unset($data['attachments']);
        }

        $project->fill($data);

        if ($project->saveOrFail()) {
            Flash::success(__('flash_messages.admin_projects.update_success'))->important();

            return redirect()->back();
        }

        Flash::error(__('flash_messages.admin_projects.update_error'));

        return redirect()->back()->withInput();
    }

    /**
     * @param string $action
     * @return array
     */
    protected function getValidateRules($action = 'create')
    {
        return [
            'is_prime'             => 'required|in:0,1',
            'real_or_anime'        => 'required|array',
            'type_of_movie'        => 'required|array',
            'is_certcreator'       => 'required|in:0,1',
            'price_min'            => 'numeric',
            'price_max'            => 'numeric',
            'is_price_undecided'   => 'nullable|numeric',
            'part_of_work'         => 'required|array',
            'client_arrange'       => 'array',
            'client_arrange_text'  => 'nullable|max:4000',
            'place_pref'           => 'nullable|max:4000',
            'point'                => 'string|required|max:4000',
            'describe'             => 'string|max:4000',
            'title'                => 'required|string|max:255',
            'duedate_at'           => 'nullable|date',
            'is_duedate_undecided' => 'nullable|numeric',
            'status'               => 'numeric'
        ];
    }

    /**
     * Upload project attachments
     *
     * @param Uploads $files
     * @return array
     */
    public function uploadAttachments($files)
    {
        $paths = [];
        if ($files) {
            foreach ($files as $file) {
                if (!$file) {
                    continue;
                }
                $fileName = $file->getClientOriginalName();
                $path = $file->storePubliclyAs('attachments/'.auth()->id(), $fileName, 's3');
                $paths[] = [
                    'name' => $fileName,
                    'path' => $path
                ];
            }
        }

        return $paths;
    }
}
