<?php namespace  Palmabit\Library\Api\Controllers;

use Illuminate\Pagination\Paginator;
use Palmabit\Library\Api\Parsers\ApiParser;
use Palmabit\Library\Api\Transformers\ApiTransformer;

class ApiBaseController extends ApiController
{

	protected $parser;
	protected $transformer;

	public function __construct()
	{
		$this->parser = new ApiParser();
		$this->transformer = new ApiTransformer();
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return $this->respondForbidden();
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return $this->respondForbidden();
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		return $this->respondForbidden();
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function show($id)
	{
		return $this->respondForbidden();
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function edit($id)
	{
		return $this->respondForbidden();
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function update($id)
	{
		return $this->respondForbidden();
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return Response
	 */
	public function destroy($id)
	{
		return $this->respondForbidden();
	}

	/**
	 * Display a listing of the resource and transform data.
	 *
	 * @param $items
	 * @return Response
	 */
	protected function indexCollection($items)
	{
		return $this->respond($this->transformer->transformCollection($this->parser->parseCollection($items)));
	}

	/**
	 * Display a listing of the resource and transform data with pagination
	 *
	 * .
	 * @param Paginator $paginator
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function indexCollectionWithPagination(Paginator $paginator)
	{
		return $this->respondWithPagination($paginator, $this->transformer->transformCollection($this->parser->parseCollection($paginator->getItems())));
	}

	/**
	 * Display the specified resource and transform data.
	 *
	 * @param $item
	 * @return Response
	 */
	protected function showItem($item)
	{
		return $this->respond($this->transformer->transform($this->parser->parse($item)));
	}
} 