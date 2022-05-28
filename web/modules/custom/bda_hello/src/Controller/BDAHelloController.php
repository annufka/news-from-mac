<?php

namespace Drupal\bda_hello\Controller;

class BDAHelloController {
  public function hello() {
    //     $output = node_load_multiple();
    //     $output = node_view_multiple($output);
    //     return array(
    //         '#markup' => render($output),
    //     );
    return array(
      '#markup' => 'Welcome to our Website.'
    );
  }

  public function get_last_news() {
      $nodeStorage = \Drupal::entityTypeManager()->getStorage('node');
      // $storage = \Drupal::entityTypeManager()->getStorage('node'); 

      $ids = $nodeStorage->getQuery()
      ->condition('status', 1)
      ->condition('type', 'news') // type = bundle id (machine name)
      ->sort('created', 'DESC') // sorted by time of creation
      // ->sort('nid', 'DESC')
      // ->pager(1) // limit 15 items
      ->range(0,1)
      ->execute();
      // print_r($ids);
      // $news = $nodeStorage->loadMultiple($ids);

      $entity_type = 'node';
      $view_mode = 'teaser';  
      $builder = \Drupal::entityTypeManager()->getViewBuilder($entity_type);
      $storage = \Drupal::entityTypeManager()->getStorage($entity_type);
      $node = $storage->load(reset($ids));
      $build = $builder->view($node, $view_mode);
      // $output = render($build); 
      return $build;
      // return array(
      //     '#markup' => $build
      // ); 
  }

  public function get_news_category($category_id) {
    
    // $taxonomy = \Drupal::entityTypeManager()->getStorage('taxonomy_term_data');
    // $category = $taxonomy->getQuery()
    // ->condition('tid', $category_id)
    // ->execute();
    // print_r($category);
    $nodeStorage = \Drupal::entityTypeManager()->getStorage('node');
    
    $ids = $nodeStorage->getQuery()
    ->condition('status', 1)
    ->condition('type', 'news')
    ->condition('field_news_category.entity:taxonomy_term.tid', $category_id)
    ->execute();
    
    $entity_type = 'node';
    $view_mode = 'full';  
    $builder = \Drupal::entityTypeManager()->getViewBuilder($entity_type);
    $storage = \Drupal::entityTypeManager()->getStorage($entity_type);
    $node = $storage->loadMultiple($ids);
    $build = $builder->viewMultiple($node, $view_mode);
    return $build;

  }

  public function filter_news() {
    $config = \Drupal::config('bda_hello_news_filter.settings');
    $filter = $config->get('news_filter');

    $nodeStorage = \Drupal::entityTypeManager()->getStorage('node');
    
    $ids = $nodeStorage->getQuery()
    ->condition('status', 1)
    ->condition('type', 'news')
    ->sort($filter, 'DESC')
    ->execute();
    
    $entity_type = 'node';
    $view_mode = 'full';  
    $builder = \Drupal::entityTypeManager()->getViewBuilder($entity_type);
    $storage = \Drupal::entityTypeManager()->getStorage($entity_type);
    $node = $storage->loadMultiple($ids);
    $build = $builder->viewMultiple($node, $view_mode);
    return $build;
  }

}