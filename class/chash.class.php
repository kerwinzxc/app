<?php

// A simple consistent hashing implementation.
class chash
{
  // the number of virtual nodes
  private $virt_nodes_num = 64;

  private $hasher;

  // current target counter
  private $cur_target_count = 0;

  // map of positions (hash outputs) to targets
  // array { position => target, ... }
  private $pos_to_target = array();

  // map of targets to lists of positions that target is hashed to.
  // array { target => [ position, position, ... ], ... }
  private $target_to_pos = array();

  private $pos_to_target_sorted = false;

  private function sort_pos_targets()
  {
    if (!$this->pos_to_target_sorted) {
      ksort($this->pos_to_target, SORT_REGULAR);
      $this->pos_to_target_sorted = true;
    }
  }

  public function __construct($targets = array())
  {
    if (!empty($targets)) {
      $this->add_targets($targets);
    }
  }
  public function add_target($target)
  {
    if (isset($this->target_to_pos[$target])) {
      return false;
    }
    $this->target_to_pos[$target] = array();
    for ($i = 0; $i < $this->virt_nodes_num; $i++) {
      $position = crc32($target . $i);
      $this->pos_to_target[$position] = $target; // for lookup
      $this->target_to_pos[$target][] = $position; // target remove
    }
    $this->pos_to_target_sorted = false;
    $this->cur_target_count++;
    return true;
  }
  public function add_targets($targets)
  {
    foreach ($targets as $target) {
      $this->add_target($target);
    }
    return true;
  }
  public function rm_target($target)
  {
    if (!isset($this->target_to_pos[$target])) {
      return false;
    }
    foreach ($this->target_to_pos[$target] as $position) {
      unset($this->pos_to_target[$position]);
    }
    unset($this->target_to_pos[$target]);
    $this->cur_target_count--;
    return true;
  }

  public function get($resource)
  {
    if (empty($this->pos_to_target)) {
      return false;
    }
    if ($this->cur_target_count == 1) {
      $ret = array_values($this->pos_to_target);
      return empty($ret) ? false : $ret[0];
    }

    $resource_pos = crc32($resource);
    $this->sort_pos_targets();

    // search values above the resource_pos
    foreach ($this->pos_to_target as $key => $value) {
      if ($key > $resource_pos) {
        return $value;
      }
    }

    // get the first
    $ret = array_slice($this->pos_to_target, 0, 1, false);
    return empty($ret) ? false : $ret[0];
  }
};
