<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
  public function beforeFilter(\Cake\Event\EventInterface $event)
  {
    parent::beforeFilter($event);
    // 認証を必要としないログインアクションを構成し、
    // 無限リダイレクトループの問題を防ぎます
    $this->Authentication->addUnauthenticatedActions(['login', 'add']);
  }

  /**
   * Index method
   *
   * @return \Cake\Http\Response|null|void Renders view
   */
  public function index()
  {
    $users = $this->paginate($this->Users);

    $this->set(compact('users'));
  }

  /**
   * View method
   *
   * @param string|null $id User id.
   * @return \Cake\Http\Response|null|void Renders view
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function view($id = null)
  {
    $user = $this->Users->get($id, [
      'contain' => [],
    ]);
    $this->isCurrent_user($user);

    $this->set(compact('user'));
  }

  /**
   * Add method
   *
   * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
   */
  public function add()
  {
    $user = $this->Users->newEmptyEntity();
    if ($this->request->is('post')) {
      $user = $this->Users->patchEntity($user, $this->request->getData());
      if ($this->Users->save($user)) {
        $this->Flash->success(__('The user has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The user could not be saved. Please, try again.'));
    }
    $this->set(compact('user'));
  }

  /**
   * Edit method
   *
   * @param string|null $id User id.
   * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function edit($id = null)
  {
    $user = $this->Users->get($id, [
      'contain' => [],
    ]);
    $this->isCurrent_user($user);
    if ($this->request->is(['patch', 'post', 'put'])) {
      $user = $this->Users->patchEntity($user, $this->request->getData());
      if ($this->Users->save($user)) {
        $this->Flash->success(__('The user has been saved.'));

        return $this->redirect(['action' => 'index']);
      }
      $this->Flash->error(__('The user could not be saved. Please, try again.'));
    }
    $this->set(compact('user'));
  }

  /**
   * Delete method
   *
   * @param string|null $id User id.
   * @return \Cake\Http\Response|null|void Redirects to index.
   * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
   */
  public function delete($id = null)
  {
    $this->request->allowMethod(['post', 'delete']);
    $user = $this->Users->get($id);
    $session = $this->request->getSession();
    $current_user = $session->read('Auth.id');
    if ($user->id != $current_user) {
      $this->Flash->error(__('This page forbiden'));
      return $this->redirect(['action' => 'index']);
    }
    if ($this->Users->delete($user)) {
      $this->Flash->success(__('The user has been deleted.'));
      return $this->redirect(['action' => 'logout']);
    } else {
      $this->Flash->error(__('The user could not be deleted. Please, try again.'));
    }

    return $this->redirect(['action' => 'index']);
  }

  public function login($id = null)
  {
    $this->request->allowMethod(['get', 'post']);
    $result = $this->Authentication->getResult();
    // POST, GET を問わず、ユーザーがログインしている場合はリダイレクトします
    if ($result->isValid()) {
      // redirect to /articles after login success
      $redirect = $this->request->getQuery('redirect', [
        'controller' => 'Posts',
        'action' => 'index',
      ]);

      return $this->redirect($redirect);
    }
    // ユーザーが submit 後、認証失敗した場合は、エラーを表示します
    if ($this->request->is('post') && !$result->isValid()) {
      $this->Flash->error(__('Invalid username or password'));
    }
  }

  public function logout()
  {
    $result = $this->Authentication->getResult();
    // POST, GET を問わず、ユーザーがログインしている場合はリダイレクトします
    if ($result->isValid()) {
      $this->Authentication->logout();
      return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
  }

  protected function isCurrent_user($user)
  {
    $session = $this->request->getSession();
    $current_user = $session->read('Auth.id');
    if ($user->id != $current_user) {
      $this->Flash->error(__('This page forbiden'));
      return $this->redirect(['action' => 'index']);
    }
  }
}
