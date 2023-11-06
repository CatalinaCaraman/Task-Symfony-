<?php  
 
namespace  App\Service; 
 
interface EntityServiceInterface{ 
 
public function getAll():array; 
public function getOne(int $id); 
 
}