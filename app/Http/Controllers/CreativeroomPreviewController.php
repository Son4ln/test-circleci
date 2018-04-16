<?php

namespace App\Http\Controllers;

use Auth;
use App\CreativeRoom;
use App\CreativeroomUser;
use Illuminate\Http\Request;
use App\Mail\RoomHasMessage;
use App\CreativeroomMessage;
use App\Events\MessageReceived;
use App\Notifications\AlertRoomMessage;
use App\Repositories\CreativeroomPreviewRepository;

class CreativeroomPreviewController extends Controller
{
	/**
	* @var string
	*/
	protected $repository;

	/**
	* Create a new controller instance.
	*
	* @param CreativeRoomRepositoryInterface $repository
	*/
	public function __construct(CreativeroomPreviewRepository $repository)
	{
		$this->repository = $repository;
		$this->middleware('auth');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$preview = $this->repository->create([
			'file_id'         => $request->input('file_id'),
			'user_id'         => Auth::user()->id,
			'creativeroom_id' => $request->input('creativeroom_id'),
			'title'           => $request->input('attr'),
			'start'           => $request->input('attr')['data-begin'],
			'kind'            => $request->input('kind')? 2 : 1
		]);

		$message = $this->createMessage($request->input('creativeroom_id'), $request->input('file_id'));

		return view('creative-rooms.partials.message-item', compact('message'));
	}

	/**
	 * Create messages
	 */
	private function createMessage($id, $fileId)
	{
		$room = CreativeRoom::findOrFail($id);
		$this->authorize('show', $room);

		$dataTime = isset( $_POST['attr']['data-begin'] ) && !empty( $_POST['attr']['data-begin'] ) ? 'data-time="'.(int)$_POST['attr']['data-begin'].'" ' : '';
		$message = 'タスクが作成されました<span style="margin-left:10px">:</span><span style="margin-left:5px">'.$_POST['attr']['text'].'</span><br><button class="tab-toggle" data-file="'.$fileId.'" '.$dataTime.'style="margin-top:5px;" data-target="#preview">Preview Room へ移動</button>';

		$message = CreativeroomMessage::create([
			'creativeroom_id' => $id,
			'kind' => 1,
			'user_id' => auth()->id(),
			'message' => $message
		]);

		$users = CreativeroomUser::with(['user' => function($query) {
			$query->select('id', 'email');
		}])->where('creativeroom_id', $room->id)->get();

		broadcast(new MessageReceived($message))->toOthers();
		foreach ($users as $roomUser) {
			$user = $roomUser->user;
			// if ($user->email == $request->user()->email) {
			//     continue;
			// }
			// Mail::to($user->email)->queue(new RoomHasMessage($room, $roomUser->role));
			$user->notify(new AlertRoomMessage($room, $message->kind));
		}

		return $message;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$preview = $this->repository->findOrFail($id);
		$preview->delete();

		return;
	}
}
