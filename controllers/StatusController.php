<?php

class StatusController extends Controller
{
    public function indexAction()
    {
        $user = $this->session->get('user');
        $statuses = $this->db_manager->get('Status')->fetchAllPersonArchivesByUserId($user['id']);

        return $this->render(array(
            'statuses' => $statuses,
        ));
    }

    public function userAction($params)
    {
        $user = $this->db_manager->get('User')->fetchByUserName($params['mailaddress']);
        if (! $user) {
            $this->forward404();
        }

        $statuses = $this->db_manager->get('Status')->fetchAllByUserId($user['id']);

        return $this->render(array(
            'user'     => $user,
            'statuses' => $statuses,
        ));
    }

    public function showAction($params)
    {
        $status = $this->db_manager->get('Status')->fetchByIdAndUserName($params['id'], $params['mailaddress']);

        if (! $status) {
            $this->forward404();
        }

        return $this->render(array('status' => $status));
    }
}
