<?php

/**
 * Description of Form
 *
 * @author User
 */
class RM_Form extends Zend_Form
{

    public function __construct($options = null)
    {
        parent::__construct($options);
    }

    protected function getElementDecorators()
    {
        return array(
            'ViewHelper',
            array('Description', array('escape' => false, 'tag' => false)),
            array('Errors', array('class' => 'help-inline')),
            array(array('data' => 'HtmlTag'),
                array('tag' => 'div', 'class' => 'controls')),
            array('Label', array('class' => 'control-label')),
            array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'control-group'))
        );
    }

    protected function getRadioDecorators()
    {
        return array(
            'ViewHelper',
            'Errors',
            array(array('data' => 'HtmlTag'),
                array('tag' => 'div', 'class' => 'controls')),
            array('Label', array('class' => 'control-label')),
            array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => array('control-group')))
        );
    }

    protected function getCheckboxDecorators()
    {
        return array(
            'ViewHelper',
            'Errors',
            array(array('data' => 'HtmlTag'),
                array('tag' => 'div', 'class' => 'controls')),
            array('Label', array('class' => 'control-label')),
            array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => array('control-group')))
        );
    }

    protected function getFormDecorators($span, $offset)
    {
        return array(
            'FormElements',
            array('HtmlTag', array('tag' => 'fieldset')),
            array('Form', array('class' => array('form-horizontal', 'well', $span, $offset)))
        );
    }

    protected function getDisplayGroupDecorators()
    {
        return array(
            'FormElements',
            array('HtmlTag', array('tag' => 'div', 'class' => 'form-actions'))
        );
    }

    protected function getFileDecorators()
    {
        return array(
            'File',
            array('Description', array('escape' => false, 'tag' => false)),
            array('Errors', array('class' => 'help-inline')),
            array(array('data' => 'HtmlTag'),
                array('tag' => 'div', 'class' => 'controls')),
            array('Label', array('class' => 'control-label')),
            array(array('row' => 'HtmlTag'), array('tag' => 'div', 'class' => 'control-group'))
        );
    }

    protected function _getMultiOptions($fieldName)
    {
        $em = Zend_Registry::get('em');
        $list = $this->_getList($em, $fieldName);
        $listItems = $em->getRepository('RM\Entity\ListItems')->getListItemsByListId($list->getId());
        $options = array();
        foreach ($listItems as $listItem) {
            $options[$listItem['itemId']] = $listItem['name'];
        }
        return $options;
    }

    protected function _getDefaultValue($fieldName)
    {
        $em = Zend_Registry::get('em');
        $list = $this->_getList($em, $fieldName);
        $defaultListItem = $em->getRepository('RM\Entity\ListItems')->getDefaultListItem($list->getId());
        return $defaultListItem->getItemId();
    }

    protected function _getList($em, $fieldName)
    {
        return $em->getRepository('RM\Entity\Lists')->getListByShortName($fieldName);
    }

    protected function getEmailElementSettings()
    {
        return array(
            'label' => 'Email:',
            'maxlength' => 100,
            'validators' => array(
                array('StringLength', true, array('min' => 0, 'max' => 100)),
                new RM_Validate_EmailAddress()),
            'class' => 'span3',
            'required' => true
        );
    }

}
