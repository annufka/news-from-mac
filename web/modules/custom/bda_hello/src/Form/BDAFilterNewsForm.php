<?php  

namespace Drupal\bda_hello\Form;

use Drupal\Core\Form\ConfigFormBase;  
use Drupal\Core\Form\FormStateInterface;  
  
class BDAFilterNewsForm extends ConfigFormBase {

    protected function getEditableConfigNames() {  
        return [  
          'bda_hello_news_filter.settings',  
        ];  
      }
      
      public function getFormId() {  
        return 'filter_news_form';  
      }
      
      public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config('bda_hello_news_filter.settings');  
      
        $form['filter_field'] = array(
            '#type' => 'radios',
            '#title' => $this->t('News filter:'),
            '#options' => array('created' => 'by create date', 'changed' => 'by change date'),
            '#default_value' => $config->get('news_filter'),
            '#required' => TRUE,
            );

        return parent::buildForm($form, $form_state);  
      }  

      public function submitForm(array &$form, FormStateInterface $form_state) {  
      
        $this->config('bda_hello_news_filter.settings')  
          ->set('news_filter', $form_state->getValue('filter_field'))  
          ->save(); 
          
        parent::submitForm($form, $form_state);
      }   
      
}  