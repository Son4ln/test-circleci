<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\DocumentRepository;
use Storage;

class DocumentController extends Controller
{
    /**
     * @var int
     */
    protected $pages = 10;

    /**
     * @var DocumentRepository
     */
    protected $repository;

    /**
     * Create new Controller instance
     */
    public function __construct(DocumentRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get documents list with filters
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        $filters = $request->except('_token');

        $documents = $this->repository->getDocumentsByFilters($filters)
            ->paginate($this->pages);

        return view('widget.dashboards.admin.documents_list', compact('documents'));
    }

    /**
     * Store resoure
     *
     * @param Illuminate\Http\Request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storePathPrefix = 'documents';

        list($rules, $messages) = $this->getValidationRules();

        $this->validate($request, $rules, $messages);

        $input = $request->except('_token', 'uploadfile');

        //TODO Get file info
        $input['mime'] = $request->file('uploadfile')
            ->getClientOriginalExtension();
        $input['name'] = $request->file('uploadfile')
            ->getClientOriginalName();
        $input['originalfilename'] = $request->file('uploadfile')
            ->getClientOriginalName();
        $input['filesize'] = $request->file('uploadfile')->getClientSize();
        $input['filename'] = $request->file('uploadfile')
            ->storePubliclyAs($storePathPrefix, $input['originalfilename'], 's3');

        $this->repository->create($input);

        return redirect()->back();
    }

    /**
     * Delete resourc
     *
     * @param int $id
     * @return Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = $this->repository->findOrFail($id);

        Storage::disk('s3')->delete($document->filename);
        $document->delete();

        return redirect('/');
    }

    /**
     * Get rules and validation messages
     *
     * @return array
     */
    public function getValidationRules()
    {
        $rules = [
            'genre'      => 'required',
            'title'      => 'required|max:200',
            'uploadfile' => 'required',
            'price'      => 'numeric|max:850000',
            'days'       => 'numeric|max:25'
        ];

        $messages = [

        ];

        return [$rules, $messages];
    }
}
