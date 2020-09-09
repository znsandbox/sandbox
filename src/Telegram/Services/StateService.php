<?php

namespace ZnSandbox\Telegram\Services;

class StateService
{

    private $session;
    private $userId;
    private $state;

    public function __construct(SessionService $sessionService, UserService $userService)
    {
        $this->session = $sessionService;
        $this->userId = $userService->getCurrentUser()->getId();
        $this->state = $this->get();
    }

    public function set(string $value) {
        $this->session->set('state', $value);
    }

    public function get() {
        return $this->session->get('state');
    }

    public function reset() {
        $this->session->remove('state');
        $this->session->remove('state_data_' . $this->stateName());
    }

    public function getData() {
        return $this->session->get('state_data_' . $this->stateName());
    }

    public function setData($data) {
        $this->session->set('state_data_' . $this->stateName(), $data);
    }

    private function stateName() {
        return $this->userId . '_' . $this->state;
    }
}
