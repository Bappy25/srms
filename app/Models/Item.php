<?php

namespace App\Models; 

use App\Models\Model;

class Item extends Model{

    /* Declaring all variables */

    private $id;
    private $name;
    private $price;

    /* Setter getter for all variables */

      // ID setter getter
    function setId($id){
        $this->id = intval($id);
    }
    function getId(){
        return $this->id;
    }

    	// item name Setter Getter
    function setName($name){
        if(is_numeric($name) && $name != 0){
            if(strlen($name) == 1){
                $name = "0".$name;
            }
            elseif(strlen($name) > 2) {
                $name = ltrim($name, '0');
                if(strlen($name) == 1){
                    $name = "0".$name;
                }
            }
        }
        $this->name = ucwords(strtolower($name));   
    }	    
    function getName(){
        return $this->name;
    }

        // Price name Setter Getter
    function setPrice($price){
        $this->price = intval($price); 
    }       
    function getPrice(){
        return $this->price;
    }

    /* All functions */

      // Setting all the data
    public function setData($data = ''){
		if (isset($data['id'])){
			$this->setId($data['id']);
		}
		if (isset($data['name'])){
			$this->setName($data['name']);
		}
        if (isset($data['price'])){
            $this->setPrice($data['price']);
        }
      	return $this;
    }

    	// Validating necesarry data 
	public function validateData()
	{
		$errors = array();

		if(empty($this->getName())){
		  $errors['name'] = "Name can not be empty!";
		}
        else{
            $item = $this->db->table('items')->where('name', '=', $this->getName())->and('id', '!=', $this->getId())->read();
            if($item){
                $errors['name'] = "This item already exists in the database!";
            }
        }

        if(empty($this->getPrice())){
          $errors['price'] = "Price can not be empty!";
        }

		setErrors($errors);   

		return $this;
	}

		// Function for showing items
    public function getItems() {   
	    $items = $this->db->table('items')->limit(15)->read();
        $pagination = $this->db->pagination();
        return array('items' => $items, 'pagination' => $pagination);
    }

    	// Function for showing item
    public function getItem() {   
	    $item = $this->db->table('items')->where('id', '=', $this->getId())->read();
	    return $item[0];
    }

    	// Function for storing item
    public function storeItem() {   
        if(empty(getErrors())){
            $store = $this->db->table('items')->data(['name' => $this->getName(), 'price' => $this->getPrice()])->create();
            return $store;
        }       
    }

    	// Function for Editing item
    public function updateItem() {
        if(empty(getErrors())){
            $update = $this->db->table('items')->set(['name' => $this->getName(), 'price' => $this->getPrice()])->where('id', '=', $this->getId())->update();
            return $update;
        }
    }

    	// Function for deleting item
    public function deleteItem() {  
        $delete = $this->db->table('items')->where('id', '=', $this->getId())->delete();
        return $delete; 
    }

	

}