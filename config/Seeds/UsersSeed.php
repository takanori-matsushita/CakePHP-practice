<?php

declare(strict_types=1);

use Migrations\AbstractSeed;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
{
  /**
   * Run Method.
   *
   * Write your database seeder using this method.
   *
   * More information on writing seeds is available here:
   * https://book.cakephp.org/phinx/0/en/seeding.html
   *
   * @return void
   */
  public function run()
  {
    for ($i = 1; $i <= 5; $i++) {
      $data[] =
        [
          'name' => 'user' . $i,
          'email' => 'mail-' . $i . '@mail.com',
          'password' => $this->_setPassword('password'),
          'created' => '2020-07-05 00:00:00',
          'modified' => '2020-07-05 00:00:00',
        ];
    }
    $table = $this->table('users');
    $table->insert($data)->save();
  }

  protected function _setPassword(string $password): ?string
  {
    if (strlen($password) > 0) {
      return (new DefaultPasswordHasher())->hash($password);
    }
  }
}
