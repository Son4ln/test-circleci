<?php

namespace App\Http\Controllers;

use App\Info;
use App\Repositories\NotificationRepository;
use Illuminate\Http\Request;
use Validator;
use Flash;
use Auth;

class NotificationController extends Controller
{
    /**
     * @var array
     */
    protected $types = [
        'room'    => 'App\Notifications\AlertRoomMessage',
        'message' => 'App\Notifications\AlertMessage'
    ];

    /**
     * @var NotificationRepository
     */
    protected $repository;

    /**
     * Create new controller instance
     */
    public function __construct(NotificationRepository $repository)
    {
        $this->repository = $repository;
        $this->middleware('auth');
    }

    /**
     * Get listing of notifications
     */
    public function index()
    {
        $this->authorize('index', Info::class);

        $creatorNotifications = $this->repository->getCreatorNotifications();
        $clientNotifications  = $this->repository->getClientNotifications();
        $memberNotifications  = $this->repository->getMemberNotifications();

        return view('notifications.index', compact(
            'creatorNotifications',
            'clientNotifications',
            'memberNotifications'
        ));
    }

    /**
     * Store notification
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        list($rules, $messages) = $this->getValidationRules();
        $this->validate($request, $rules, $messages);

        $this->authorize('create', Info::class);
        $input = $request->except('_method', '_token');
        $this->repository->create($input);

        Flash::success(__('flash_messages.notifications.store_success'));

        return redirect()->back();
    }

    /**
     * Delete notification
     *
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $info = Info::findOrFail($id);

        $this->authorize('delete', $info);

        $info->delete();
    }

    /**
     * Get broadcast notification
     */
    public function list(Request $request)
    {
        if (Auth::id() != $request->id) {
            abort(403);
        }
        $type = $request->type && isset($this->types[$request->type])
            ? $this->types[$request->type] : 'message';
        $notifications = Auth::user()->unreadNotifications()
            ->where('type', $type)
            ->get();

        Auth::user()->unreadNotifications()
            ->where('type', $type)
            ->update(['read_at' => \Carbon\Carbon::now()]);

        if ($request->type == 'message') {
            return view('notifications.partials.message_nof', compact('notifications'));
        }
        return view('notifications.partials.list', compact('notifications'));
    }

    /**
     * Group notifications
     */
    public function groupNotifications($notifications)
    {
        $results = [];
        foreach ($notifications as $notification) {
            if (isset($results[$notification->data['type']])) {
                // Increa notification count
                $results[$notification->data['type']] = $notification->data
                    + ['count' => $results[$notification->data['type']]['count'] + 1];
            } else {
                // Set notification count
                $results[$notification->data['type']] = $notification->data
                    + ['count' => 1];
            }
        }
        return $results;
    }

    /**
     * Mark all notifications as read
     */
    public function markAsReaded(Request $request)
    {
        Auth::user()->unreadNotifications()
            ->where('id', $request->id)
            ->update(['read_at' => \Carbon\Carbon::now()]);

        return response($request->id);
    }

    /**
     * Get notification validation rules
     */
    protected function getValidationRules()
    {
        $rules = [
            'title' => 'required|max:255',
            'message' => 'required|max:4000'
        ];

        $messages = [

        ];

        return [$rules, $messages];
    }
}
