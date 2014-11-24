<?php

class AccountController extends Controller
{
    public function signupAction()
    {
        return $this->render(array(
            'mailaddress' => '',
            'password'  => '',
            '_token'    => $this->generateCsrfToken('account/signup'),
        ));
    }

    public function registerAction()
    {
        if (! $this->request->isPost()) {
            $this->forward404();
        }

        $token = $this->request->getPost('_token');
        if (! $this->checkCsrfToken('account/signup', $token)) {
            return $this->redirect('/account/signup');
        }

        $mailaddress = $this->request->getPost('mailaddress');
        $password = $this->request->getPost('password');

        $errors = array();

        if (! strlen($mailaddress)) {
            $errors[] = 'メールアドレスを入力してください';
        } else if (! $this->db_manager->get('User')->isUniqueUserName($mailaddress)) {
            $errors[] = 'メールアドレスは既に使用されています';
        }

        if (! strlen($password)) {
            $errors[] = 'パスワードを入力してください';
        } else if (4 > strlen($password) || strlen($password) > 30) {
            $errors[] = 'パスワードは4文字以上、30文字以内で入力してください';
        }

        if (count($errors) === 0) {
            $this->db_manager->get('User')->insert($mailaddress, $password);
            $this->session->setAuthenticated(true);

            $user = $this->db_manager->get('User')->fetchByUserName($mailaddress);
            $this->session->set('user', $user);

            return $this->redirect('/');
        }

        return $this->render(array(
            'mailaddress' => $mailaddress,
            'password'    => $password,
            'errors'      => $errors,
            '_token'      => $this->generateCsrfToken('account/signup'),
        ), 'signup');
    }

    public function indexAction()
    {
        $user = $this->session->get('user');

        return $this->render(array('user' => $user));
    }

    public function signinAction()
    {
        if ($this->session->isAuthenticated()) {
            return $this->redirect('/account');
        }

        return $this->render(array(
            'mailaddress' => '',
            'password' => '',
            '_token' => $this->generateCsrfToken('account/signin'),
        ));
    }

    public function authenticateAction()
    {
        if ($this->session->isAuthenticated()) {
            return $this->redirect('/account');
        }

        if (! $this->request->isPost()) {
            $this->forward404();
        }

        $token = $this->request->getPost('_token');
        if (! $this->checkCsrfToken('account/signin', $token)) {
            return $this->redirect('/account/signin');
        }

        $mailaddress = $this->request->getPost('mailaddress');
        $password = $this->request->getPost('password');

        $errors = array();

        if (! strlen($mailaddress)) {
            $errors[] = 'ユーザIDを入力してください';
        }

        if (! strlen($password)) {
            $errors[] = 'パスワードを入力してください';
        }

        if (count($errors) === 0) {
            $user_repository = $this->db_manager->get('User');
            $user = $user_repository->fetchByUserName($mailaddress);

            if (! $user || ($user['password'] !== $user_repository->hashPassword($password))) {
                $errors[] = 'ユーザIDかパスワードが不正です';
            } else {
                $this->session->setAuthenticated(true);
                $this->session->set('user', $user);

                return $this->redirect('/');
            }
        }

        return $this->render(array(
            'mailaddress' => $mailaddress,
            'password'    => $password,
            'errors'      => $errors,
            '_token'      => $this->generateCsrfToken('account/signin'),
        ), 'signin');
    }

    public function signoutAction()
    {
        $this->session->clear();
        $this->session->setAuthenticated(false);

        return $this->redirect('/account/signin');
    }
}
