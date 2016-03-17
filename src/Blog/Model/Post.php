<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/16/14
 * Time: 11:36 AM
 */

namespace Blog\Model;

use Framework\Model\ActiveRecord;
use Framework\Validation\Filter\Length;
use Framework\Validation\Filter\NotBlank;

class Post extends ActiveRecord
{
    /**
     * @var
     */
    public $title;

    /**
     * @var
     */
    public $content;

    /**
     * @var
     */
    public $date;

    /**
     * @var
     */
    public $id;

    /**
     * Return current table name
     *
     * @return string
     */
    public static function getTable()
    {
        return 'posts';
    }

    /**
     * Return array of validation classes
     *
     * @return array
     */
    public function getRules()
    {
        return array(
            'title'   => array(
                new NotBlank(),
                new Length(4, 100)
            ),
            'content' => array(new NotBlank())
        );
    }
}