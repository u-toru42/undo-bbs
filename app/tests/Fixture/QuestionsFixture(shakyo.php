<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * QuestionsFixture
 */
class QuestionsFixture extends TestFixture
{
  /**
   * テーブルのフィールド情報
   * 
   * @var array
   */
  //@codingStandardsIgnoreStart
  public $fields = [
    'id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
    'user_id' => ['type' => 'integer', 'length' => 10, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
    'body' => ['type' => 'string', 'length' => 255, 'null'=> false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
    'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
    'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
    '_constraints' => [
      'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
    ],
    '_options' => [
      'engine' => 'InnoDB',
      'collation' => 'utf8mb4_genral_ci'
    ],
  ];
  // @codingStandardsIgnoreEnd

  /**
   * @inheritdoc
   */
  public function init()
  {
    $this->records = [
      [
        'id' => 1,
        'user_id' => 1,
        'body' => '',
        'created' => '',
        'modified' => '',
      ],
      [
        'id' => 2,
        'user_id' => 2,
        'body' => '',
        'created' => '',
        'modified' => '',
      ],
    ];
    parent::init();
  }






















}