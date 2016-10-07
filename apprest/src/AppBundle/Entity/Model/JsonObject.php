<?php

namespace AppBundle\Entity\Model;

abstract class JsonObject {

    public function isNotificable(){
       return in_array('provideNotification',get_class_methods($this));
    }
    
    protected function setIdentifier($id) {
        $this->id = $id;
        return $this;
    }
    
    public function toArray($container) {
        $serializer = $container->get('jms_serializer');
        return json_decode($serializer->serialize($this, 'json'));
    }

    public function toObject($array, $container) {
        $json = json_encode($array);
        $serializer = $container->get('jms_serializer');
        return $serializer->deserialize($json, get_class($this), 'json');
    }
    /*
    public function populate($array, $container) {
        return $this->toObject($array, $container);
    }
    
    
    public function toArray() {
        return $this->processArray(get_object_vars($this));
    }
   
    private function processArray($array) {
        foreach($array as $key => $value) {
            if (is_object($value)) {
                if($value instanceof \Doctrine\ODM\MongoDB\PersistentCollection){
                    $array[$key] = $this->processArray($value->toArray());
                }else if($value instanceof JsonObject){
                    $array[$key] = $value->toArray();
                }else if($value instanceof \DateTime){
                    $array[$key] = $value->getTimestamp();
                }else{
                    if(method_exists($value, '__toString')){
                        $array[$key] = $value->__toString();
                    }
                }
            }
            if (is_array($value)) {
                $array[$key] = $this->processArray($value);
            }
        }
        // If the property isn't an object or array, leave it untouched
        return $array;
    }
   */
    public function __toString() {
        return json_encode($this->toArray());
    }

    public function populate(array $array, $em) {
        $attrsValues = get_object_vars($this);
        $attrs = array_keys($attrsValues);
        $attrsLower = array();
        foreach ($attrs as $key => $attr) {
            $attrsLower[] = strtolower($attr);
        }

        foreach ($array as $key => $value) {
            if($key == 'id'){
                $this->setIdentifier($value);
            }else
            if((in_array($key, $attrs) || in_array($key, $attrsLower)) && $value != null){
                $setMethod = 'set'.$key;
                $addMethods = 'add'.substr($key, 0, -1);
                $addMethodies = 'add'.substr($key, 0, -3).'y';
                $listMethods = get_class_methods($this);
                $listMethodes = array();
                foreach ($listMethods as $key => $method) {
                    $listMethodes[$key] = strtolower($method);
                }
                if($i = $this->in_array($addMethodies, $listMethodes)){
                    $this->populateAttrib($value, $listMethods[$i], $em, true);
                }elseif($i = $this->in_array($addMethods, $listMethodes)){
                    $this->populateAttrib($value, $listMethods[$i], $em, true);
                }else{
                    if($i = $this->in_array($setMethod, $listMethodes)){
                        $this->populateAttrib($value, $listMethods[$i], $em);
                    }
                }
            }
        }
    }

    private function in_array($needle, $haystack) {
        foreach ($haystack as $key => $value) {
            if($value == $needle){
                return $key;
            }
        }

        return false;
    }

    protected function populateAttrib($value, $method, $em, $isAdd = false) {

        $r = new \ReflectionMethod($this, $method);
        $params = $r->getParameters();
        foreach ($params as $k => $param) {
            $objName = $param->getClass();
            $typeName = $this->getTypeParam($param);
            if(is_null($objName) || in_array($typeName,array('int','integer','string','null','float','double','bool','boolean','long'))){
                if($method == 'setId'){
                    if(empty($this->getId())){
                        $this->setIdentifier($value);
                    }
                }else{
                    $this->$method($value);
                }
            }else{
                $objShortName = $objName->getShortName();
                $objName = $objName->getName();
                $obj = new $objName;
                if($obj instanceof JsonObject){
                    if(is_array($value)){
                        if($isAdd){
                            foreach ($value as $j => $v) {
                                if(array_key_exists('id', $v) && !empty($v['id'])){
                                    //throw new \Exception("Exception test for $objShortName with id ".$value['id'], 1);
                                    
                                    $obj = $em->getRepository("AppBundle:".$objShortName)->findOneById($v['id']);
                                    $obj->populate($v, $em);
                                }else{
                                    $obj->populate($v, $em);
                                }
                                $this->$method($obj);
                            }
                        }else{
                            if(array_key_exists('id', $value) && !empty($value['id'])){
                                //throw new \Exception("Exception test for $objShortName with id ".$value['id'], 1);
                                
                                $obj = $em->getRepository("AppBundle:".$objShortName)->findOneById($value['id']);
                                if(!is_null($obj))
                                    $obj->populate($value, $em);
                            }else{
                                $obj->populate($value, $em);
                            }
                            $this->$method($obj);
                        }
                    }
                }
            }
        }
    }

    protected function getTypeParam($refParam) {

        $export = \ReflectionParameter::export(
        array(
            $refParam->getDeclaringClass()->name, 
            $refParam->getDeclaringFunction()->name
        ), 
        $refParam->name, 
        true
        );

        $type = preg_replace('/.*?(\w+)\s+\$'.$refParam->name.'.*-/', '\\1', $export);
        return $type;
    }
    
}