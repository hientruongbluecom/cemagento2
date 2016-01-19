<?php
namespace Bluecom\Review\Model;

class Review extends \Magento\Review\Model\Review
{
    /**
     * Validate nickname of customer
     *
     * @return array|bool|\string[]
     */
    public function validate()
    {

        $errors = [];

        if (\Zend_Validate::is($this->getNickname(), 'Regex', array('pattern' => '/-/'))) {
            $errors[] = __('Reivew Error! Nickname should not contain dashes. Please try again!');
        }

        if (!empty($errors)) {
            return $errors;
        }

        return parent::validate();
    }
}