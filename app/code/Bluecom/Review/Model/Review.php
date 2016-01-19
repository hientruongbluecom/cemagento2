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
        $validator = new Regex(array('pattern' => '/^[a-zA-Z0-9]*[^_]*$/'));
        if($validator->isValid($this->getNickname())) {
            $errors[] = __('Your nickname should not contain dashes. Please try again');
        }
        if(!empty($errors)) {
            return $errors;
        }
        return parent::validate();
    }
}