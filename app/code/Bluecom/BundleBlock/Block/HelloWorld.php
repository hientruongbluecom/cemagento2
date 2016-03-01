<?php
namespace Bluecom\BundleBlock\Block;

class HelloWorld extends \Magento\Framework\View\Element\AbstractBlock
{
    protected function _toHtml()
    {
        return '<div style="color: red;">Hello World! ^^</div>';
    }
}
