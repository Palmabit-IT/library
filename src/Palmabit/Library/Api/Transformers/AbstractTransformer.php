<?php  namespace  Palmabit\Library\Api\Transformers;

abstract class AbstractTransformer {

  /**
   * Transform a collection of items
   *
   * @param array $items
   * @return array
   */
  public function transformCollection(array $items) {
    return array_map([$this, 'transform'], $items);
  }

  public function trasformItemCollection($items)
  {
    $result = [];
    foreach ($items as $index => $item) {
      $result[$index] = $this->transform($item);
    }

    return $result;

  }

  /**
   * Transform a single item
   *
   * @param $item
   * @return mixed
   */
  public abstract function transform($item);
} 