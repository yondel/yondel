<?php

class AccountController extends Controller
{
    public function signupAction()
    {
        return $this->render(array(
            '_token' => $this->generateCsrfToken('account/signup'),
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
}
