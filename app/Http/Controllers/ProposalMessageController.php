<?php

namespace App\Http\Controllers;

use App\Repositories\MessageBoxRepository;
use App\User;
use App\Proposal;

use Illuminate\Http\Request;

class ProposalMessageController extends Controller
{
    /**
     * @var MessageBoxRepository
     */
     protected $repository;

     /**
      * Create a new controller instance.
      *
      * @param MessageBoxRepository $repository
      */
      public function __construct(MessageBoxRepository $repository)
      {
          $this->repository = $repository;

          $this->middleware('auth');
      }

      /**
       * Show form for create message
       */
      public function create(Request $request)
      {
          $user = User::findOrFail($request->input('user_id'));
          $proposal_id = $request->input('proposal_id');

          return view('proposals.messages.create', compact('user', 'proposal_id'));
      }

      /**
       * Show form for create message
       */
      public function store(Request $request)
      {
          $input = $request->except('proposal_id', '_token');
          $this->repository->create($input);
          Proposal::where('id', $request->input('proposal_id'))->update([
              'kind' => 1
          ]);
          return;
      }
}
