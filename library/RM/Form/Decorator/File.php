<?php

namespace RM\Form\Decorator;

/**
 * Description of File Decorator
 *
 * @author Csabi
 */
class File extends \Zend_Form_Decorator_File
{

    public function render($content)
    {

        $element = $this->getElement();
        if (!$element instanceof Zend_Form_Element) {
            return $content;
        }

        $view = $element->getView();
        if (!$view instanceof Zend_View_Interface) {
            return $content;
        }

        $name = $element->getName();
        $attribs = $this->getAttribs();
        if (!array_key_exists('id', $attribs)) {
            $attribs['id'] = $name;
        }

        $separator = $this->getSeparator();
        $placement = $this->getPlacement();
        $markup = array();
        $size = $element->getMaxFileSize();

        if ($size > 0) {

            $element->setMaxFileSize(0);
            $markup[] = $view->formHidden('MAX_FILE_SIZE', $size);
        }

        if (Zend_File_Transfer_Adapter_Http::isApcAvailable()) {

            $apcAttribs = array('id' => 'progress_key');
            $markup[] = $view->formHidden('APC_UPLOAD_PROGRESS', uniqid(), $apcAttribs);
        } else if (Zend_File_Transfer_Adapter_Http::isUploadProgressAvailable()) {

            $uploadIdAttribs = array('id' => 'progress_key');
            $markup[] = $view->formHidden('UPLOAD_IDENTIFIER', uniqid(), $uploadIdAttribs);
        }

        /*

          if ($element->isArray()) {

          $name .= "[]";
          $count = $element->getMultiFile();

          for ($i = 0; $i < $count; ++$i) {

          $htmlAttribs = $attribs;
          $htmlAttribs['id'] .= '-' . $i;
          $markup[] = $view->formFile($name, $htmlAttribs);

          }

          }

          else {$markup[] = $view->formFile($name, $attribs);}

         */

        $markup = implode($separator, $markup);

        switch ($placement) {

            case self::PREPEND: return $markup . $separator . $content;
            case self::APPEND:
            default: return $content . $separator . $markup;
        }
    }

}
