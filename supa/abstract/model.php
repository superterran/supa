<?php

abstract class supa_model extends supa_object {

    protected $data = array();

    abstract public function getCollection();

    abstract public function getData();

    abstract public function addData($data);

}