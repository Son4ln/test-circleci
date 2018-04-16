<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CreativeRoom;
use App\User;
use DB;
class MessagePaginationController extends Controller
{
    /**
     * Create constroller instance
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Paginate messages
     */
    public function messages(Request $request)
    {
        $room = Creativeroom::findOrFail($request->input('room_id'));
        $this->authorize('show', $room);

        $messages = \App\CreativeroomMessage::join('users','users.id','creativeroom_messages.user_id')
                    ->select(DB::raw('creativeroom_messages.id, creativeroom_messages.files, creativeroom_messages.message, creativeroom_messages.created_at, creativeroom_messages.user_id, users.name as user_name, users.photo as user_photo'))
                        ->where([
                        ['creativeroom_messages.kind', CreativeRoom::NORMAL_MESSAGE_TYPE],
                        ['creativeroom_messages.creativeroom_id', $room->id ]
                    ])
                    ->whereNotNull('creativeroom_messages.creativeroom_id')
                    ->where('creativeroom_messages.id', '<', $request->input('last_id'))
                    ->where('creativeroom_messages.kind', $request->input('kind'))
                    ->latest('creativeroom_messages.created_at')->take(10)->get()->reverse();

        if ($request->input('kind') == 1) {
            return view('creative-rooms.partials.message_list', compact('messages'));
        }

        return view('widget.messages.crluo_messages', compact('messages'));
    }

    /**
     * Get paginate messages
     */
    public function crluoMessages(Request $request)
    {
        $room = Creativeroom::findOrFail($request->input('room_id'));
        $this->authorize('show', $room);
        $inputs = $request->all();

        $admins = User::role('admin')->pluck('id');

        $model = $room->messages()->where('kind', $inputs['kind'])
            ->where(function ($query) use ($inputs) {
                $query->where('recipient_id', $inputs['recipient_id'])
                    ->orWhere('user_id', $inputs['recipient_id'])
                    ->orWhere('is_public', 1);
            })->latest()->take(15);

        if ($request->input('last_id') == 0) {
            $messages = $model->get()->reverse();
        } else {
            $messages = $model->where('id', '<', $inputs['last_id'])
                ->get()->reverse();
        }

        return view('widget.messages.crluo_messages', compact('messages'));
    }
}
