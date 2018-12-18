<?php

namespace App\Http\Controllers\Api;

use App\Services\SessionService;
use Illuminate\Http\Request;

/**
 * Class SessionController
 * @package App\Http\Controllers\Api
 */
class SessionController extends ApiController
{
    /**
     * @var SessionService
     */
    private $sessionService;

    /**
     * SessionController constructor.
     * @param SessionService $sessionService
     */
    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    /**
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->responseWithData($this->sessionService->all());
    }

    /**
     * Store Session
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        $session = $this->sessionService->store($request->only('code', 'description', 'from', 'to', 'is_active'));

        return $this->responseSuccessCreate($session);
    }

    /**
     * Update session
     *
     * @param Request $request
     * @param         $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function changeState(Request $request, $id)
    {
        $this->sessionService->changeState($request->only('is_active'), $id);

        return $this->responseSuccessUpdate();
    }
}
