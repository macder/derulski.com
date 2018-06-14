<?php

$filter = new Twig_SimpleFilter('esc_attr', function ($string) {
  return $string;
});
