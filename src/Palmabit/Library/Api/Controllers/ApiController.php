<?php namespace  Palmabit\Library\Api\Controllers;

use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller
{

	protected $statusCode = 200;

	/**
	 * @return mixed
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}

	/**
	 * @param mixed $statusCode
	 * @return $this
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	public function respondBadRequest($message = 'Bad request')
	{
		return $this->setStatusCode(400)->respondWithError($message);
	}

	public function respondUnauthorized($message = 'Unauthorized')
	{
		return $this->setStatusCode(401)->respondWithError($message);
	}

	public function respondForbidden($message = 'Forbidden')
	{
		return $this->setStatusCode(403)->respondWithError($message);
	}

	public function respondNotFound($message = 'Not Found')
	{
		return $this->setStatusCode(404)->respondWithError($message);
	}

	public function respondInternalError($message = 'Internal error')
	{
		return $this->setStatusCode(500)->respondWithError($message);
	}

	public function respondWithError($message)
	{
		return $this->respond([
			'error' => [
				'message'     => $message,
				'status_code' => $this->getStatusCode()
			]
		]);
	}

	public function respond($data, $headers = [])
	{
		return Response::json($data, $this->getStatusCode(), $headers);
	}

	public function respondWithPagination(Paginator $paginator, $data)
	{
		return $this->respond(array_merge(['data'=>$data], [
			'paginator' => [
				'total_count'  => $paginator->getTotal(),
				'total_pages'  => ceil($paginator->getTotal() / $paginator->getPerPage()),
				'current_page' => $paginator->getCurrentPage(),
				'limit'        => $paginator->getPerPage()
			]
		]));
	}
}