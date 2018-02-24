<?php

class ControladorProduct extends Controlador { 

    function __construct(Modelo $modelo) {
        parent::__construct($modelo);
    }
    
    function block(){
        $status = Request::read('status');
        $pass = Request::read('pass');
        if($this->isLogged()){
            if ($status != null){
                if(Util::validarCodificacion($pass , $this->getUser()->getClave()) || $status == 'true'){
                    $this->isBlocked($status);
                }
                $this->getModel()->setDato('status', $this->isBlocked());
            }else{
                $this->getModel()->setDato('status', $this->isBlocked());
            }
        }else{
            $this->index();
        }
    }
    
    /**
    * El siguiente método recibe 4 arrays de datos, uno por cada campo de la tabla.
    * Recorre uno de ellos, uno que siempre vaya a estar rellenado (nombre) e inserta uno a uno.
    * 
    * Respecto a las imágenes; el id de cada producto se guarda en un array, se recorre cada archivo
    * subido que no haya dado error y como nombre se le asigna el id en la posición correspondiente.
    */
    function doInsertProducts(){
        if ($this->isLogged()){
            $idfamilies = Request::read('idfamily');
            $products = Request::read('product');
            $prices = Request::read('price');
            $descriptions = Request::read('description');
            $res = array();
            $r = "";
            $cpni = 0;
            foreach($products as $i => $product ) {
                $product = new Product(null, $idfamilies[$i], $products[$i], $prices[$i], $descriptions[$i]);
                $ok = $product->verify();
                if ($ok){
                    $res[$i] = $this->getModel()->insertProduct($product);
                }else{
                    $cpni++;
                }
            }
            $cins = 0;
            foreach ($_FILES["img"]["error"] as $key => $error) {
                $upl[$key] = false;
                if ($error == UPLOAD_ERR_OK && $res[$key] > 0) {
                    $name_tmp = $_FILES["img"]["tmp_name"][$key];
                    $name = $res[$key];
                    if(!move_uploaded_file($name_tmp, '../../img/product/'.$name)) {
                        $cins++;
                    }
                }
            }
            //echo Util::varDump($r);
            header('Location: product&op=Insert_products&res='.$cpni.'&img='.$cins);
            exit();
        }else{
            $this->index();
        }
    }
    
    
    // // Edición de producto pero sin usar, se hace con ajax.
    // function editProduct(){
    //     $id = Request::read('id');
    //     $manager = new ManagerProduct($this->getModel->getDataBase());
    //     $product = $manager->get($id);
    //     if ($this->isLogged()){
    //         $this->getModel()->setDato('archivo', '_edit_product.html');
    //         $this->getModel()->setDato('family', $product->getIdFamily());
    //     }else{
    //         $this->index();
    //     }
    // }
    
    /**
     * "Elimina" un producto.
     * Lo que en realidad ocurre es que el producto es marcado como nulo y así no se
     * mostrará. Es desterrado.
     */ 
    function deleteProduct(){
        if ($this->isLogged()){
            // No se puede eliminar un producto por las claves foraneas.
            $id = Request::read('id');
            $res = $this->getModel()->deleteProduct($id);
            // Borrar imagen
            if ($res > 0){
                $ruta_destino = "../../img/product/".$id;
                unlink($ruta_destino);
            }
        }else{
            $this->index();
        }
    }
    
    function getAllProducts(){
        $idfamily = Request::read('idfamily');
        $text = Request::read('text');
        $page = Request::read('page');
        $limit = Request::read('limit');
        if (!isset($limit)){ $limit = 9; }
        if ($this->isLogged()){
            $products = $this->getModel()->getAllProductsJson($idfamily, $text, $page, $limit);
            $this->getModel()->setDato('list', $products);
        }else{
            $this->index();
        }
    }
    
    /**
     * Obtiene los campos de un producto para poder editarlo.
     */
    function getDetailsProduct(){
        $id = Request::read('id');
        if ($this->isLogged()){
            $product = $this->getModel()->getProductJson($id);
            $this->getModel()->setDato('single', $product);
        }else{
            $this->index();
        }
    }
    
    
    /**
     * Carga la plantilla de insertar producto.
     */
    function insertProducts(){
        if($this->isLogged()) {
            $html = Util::includeTemplates('templates/product/_product_insert.html');
            $this->getModel()->setDato('archivo', $html);
            $families = $this->getModel()->getFamilyOptions();
            $this->getModel()->setDato('singleFamilyProduct', $families);
        }else{
            $this->index();
        }
    }
    
    /**
     * Carga la lista de productos y dibuja la lista de <li>.
     */
    function index() {
        $op = Request::read('op');
        $res = request::read('res');
        $img = request::read('img');
        $msg = "";
        if ($res > 0){
            $msg .= "Error adding the products. ";
        }
        if ($img > 0){
            $msg .= "Error uploading the images.";
        }
        $this->getModel()->setDato('mensaje', $msg);
        if($this->isLogged()) {
            $html = Util::includeTemplates('templates/product/_product_list.html');
            $this->getModel()->setDato('archivo', $html);
            // $products = $this->getModel()->getAllProducts();
            // $productList = $this->getModel()->listToLi($products);
            // $this->getModel()->setDato('productList', $productList);
            $families = $this->getModel()->getFamilyOptions();
            $this->getModel()->setDato('singleFamilyProduct', $families);
        } else {
            // $this->getModel()->setDato('archivo', Util::includeTemplates('_index_nologueado.html'));
            header('Location: index.php');
        }
    }
    
    function saveDetailsProduct(){
        $id = Request::read('id');
        $idfamily = Request::read('idfamily');
        $product = Request::read('product');
        $price = Request::read('price');
        $description = Request::read('description');
        $object = new Product($id, $idfamily, $product, $price, $description);
        if ($this->isLogged()){
            $this->getModel()->editProduct($object);
            
            // $subir = new FileUpload($image, $this->getUser()->getId(), '../../img/product/', 2*1024*1024, FileUpload::SOBREESCRIBIR);
            // $r = $subir->upload();
        }else{
            $this->index();
        }
    }
    
    function showImage(){
        $id = Request::read('id');
        header('Content-type: image/*');
        $file = '../../img/product/'.$id;
        if (!file_exists($file)){
            $file = '../../img/product/0';
        }
        readfile($file);
        exit();
    }
    
    function uploadImg(){
        $id = Request::read('id');
        $msgImage = "Error, the image couldn't be saved.";
        if (isset($_FILES["image"])){
            $file = $_FILES["image"];
            $nombre = $file["name"];
            $tipo = $file["type"];
            $ruta_provisional = $file["tmp_name"];
            $size = $file["size"];
            $carpeta = "../../img/product/";
            
            if ($tipo != 'image/jpg' && $tipo != 'image/jpeg' && $tipo != 'image/png' && $tipo != 'image/gif'){
                $msgImage = "Error, the file is not a image.";
            }
            if ($size > 2 * 1024 * 1024){
                $msgImage = "Error, the image is too large.";
            }
            if(!isset($msgImage)){
                if($this->isLogged()) {
                    $ruta_destino = "../../img/product/".$id; // Nombra la ruta de la imagen
                    $res = move_uploaded_file($ruta_provisional,$ruta_destino) ; // Sube la imagen
                    if ($res){
                        $msgImage = "Image saved.";
                    }
                }else{
                    $this->index();
                }
            }
        }
        $this->getModel()->setDato('msgimage', $msgImage);
    }
    
    function obtainProductWP(){
        $page = Request::read('p');
        $rows = $this->getModel()->getCount();
        if($page === null || $page === ''){
            $page = 1;
        }
        $pagination = new Pagination($rows , $page , 16);
        
        $a = $pagination->getOffset();
        $b = $pagination->getRpp();
        
        $res = $this->getModel()->getAllFromWP($a, $b);
        
        $pages = array(
            'first' => $pagination->getFirst(),
            'last' => $pagination->getLast(),
            'next' => $pagination->getNext(), 
            'previous' => $pagination->getPrevious(),
            'range' => $pagination->getRange(5)
        );
        $this->getModel()->setDato('data' , $res);
        $this->getModel()->setDato('paginacion' , $pages);
    }
}