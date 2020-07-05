<?php

declare(strict_types=1);

use Migrations\AbstractMigration;

class CreatePosts extends AbstractMigration
{
  /**
   * Change Method.
   *
   * More information on this method is available here:
   * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
   * @return void
   */
  public function change()
  {
    $table = $this->table('posts');
    $table
      ->addColumn('title', 'string', [
        'limit' => 50,
        'null' => false,
      ])
      ->addColumn('description', 'text', [
        'limit' => 100,
        'null' => false,
      ])
      ->addColumn('body', 'text', [
        'limit' => 255,
        'null' => false,
      ])
      ->addColumn('created', 'datetime')
      ->addColumn('modified', 'datetime')
      ->create();
  }
}
