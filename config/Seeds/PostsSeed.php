<?php

declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Posts seed.
 */
class PostsSeed extends AbstractSeed
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
    $data = [
      [
        'title' => '最初の投稿',
        'description' => '最初の投稿の説明を記述する',
        'body' => '最初の投稿の内容を記述する',
        'user_id' => '1',
        'created' => '2020-07-05 12:00:00',
        'modified' => '2020-07-05 12:00:00'
      ],
      [
        'title' => '2番目の投稿',
        'description' => '2番目の投稿の説明を記述する',
        'body' => '2番目の投稿の内容を記述する',
        'user_id' => '2',
        'created' => '2020-07-05 13:00:00',
        'modified' => '2020-07-05 13:00:00'
      ],
      [
        'title' => '3番目の投稿',
        'description' => '3番目の投稿の説明を記述する',
        'body' => '3番目の投稿の内容を記述する',
        'user_id' => '3',
        'created' => '2020-07-05 14:00:00',
        'modified' => '2020-07-05 14:00:00'
      ],
      [
        'title' => '4番目の投稿',
        'description' => '4番目の投稿の説明を記述する',
        'body' => '4番目の投稿の内容を記述する',
        'user_id' => '4',
        'created' => '2020-07-05 15:00:00',
        'modified' => '2020-07-05 15:00:00'
      ],
      [
        'title' => '5番目の投稿',
        'description' => '5番目の投稿の説明を記述する',
        'body' => '5番目の投稿の内容を記述する',
        'user_id' => '5',
        'created' => '2020-07-05 16:00:00',
        'modified' => '2020-07-05 16:00:00'
      ],
    ];

    $table = $this->table('posts');
    $table->insert($data)->save();
  }
}
