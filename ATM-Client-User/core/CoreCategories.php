<?php
    ob_start();
    session_start();
    require_once('../../config/db.php');
    $object = new Database();
    $object->connect();
    class Categories extends Database
    {
        public $category;
        public $categoryID;

        function NewCategory($category)
        {
            try
            {
                $sql = "INSERT INTO atm_categories(category,created_by,date_created) VALUES(?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $category);
                $stmt->bindvalue(2, $_SESSION['person']);
                $stmt->bindvalue(3, date('Y-m-d H:i:s'));
                if($stmt->execute())
                {
                    echo "Success";
                }
                else
                {
                    echo "Failed";
                }
            }
            catch(PDOException $e)
            {
                echo 'Error';
            }
        }

        function DeleteCategory($categoryID)
        {
            try
            {
                $sql = "DELETE FROM atm_categories WHERE category_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $categoryID);
                if($stmt->execute())
                {
                    echo "Success";
                }
                else
                {
                    echo "Failed";
                }
            }
            catch(PDOException $e)
            {
                echo 'Error';
            }
        }
    }

    $catig = new Categories();

    if(isset($_POST['categ']))
    {
        $category = $_POST['categ'];
        $catig -> NewCategory($category);
    }

    if(isset($_POST['deleteCate']))
    {
        $catez = $_POST['deleteCate'];
        list($catez, $enc_iv) = explode("::", $catez);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($catez, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $categoryID = $token;
        $catig -> DeleteCategory($categoryID);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

    class SubCategory extends Database
    {
        public $category;
        public $sub_categoryID;
        public $sub_category;

        function NewSubCategory($category,$sub_category)
        {
            try
            {
                $sql = "INSERT INTO atm_sub_categories(category_id_fk,sub_category,created_by,date_created) VALUES(?,?,?,?);";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $category);
                $stmt->bindvalue(2, $sub_category);
                $stmt->bindvalue(3, $_SESSION['person']);
                $stmt->bindvalue(4, date('Y-m-d H:i:s'));
                if($stmt->execute())
                {
                    echo "Success";
                }
                else
                {
                    echo "Failed";
                }
            }
            catch(PDOException $e)
            {
                echo 'Error';
            }
        }

        function DeleteSUBCategory($sub_categoryID)
        {
            try
            {
                $sql = "DELETE FROM atm_sub_categories WHERE sub_category_id = ?;";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindvalue(1, $sub_categoryID);
                if($stmt->execute())
                {
                    echo "Success";
                }
                else
                {
                    echo "Failed";
                }
            }
            catch(PDOException $e)
            {
                echo 'Error';
            }
        }
    }

    $subcate = new SubCategory();

    if(isset($_POST['catego']))
    {
        $catez = $_POST['catego'];
        list($catez, $enc_iv) = explode("::", $catez);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($catez, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $category = $token;
        $sub_category = $_POST['subcateg'];
        $subcate -> NewSubCategory($category,$sub_category);
    }

    if(isset($_POST['deleteSubCate']))
    {
        $catez = $_POST['deleteSubCate'];
        list($catez, $enc_iv) = explode("::", $catez);  
        $cipher_method = 'aes-128-ctr';
        $enc_key = openssl_digest(php_uname(), 'SHA256', TRUE);
        $token = openssl_decrypt($catez, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
        $sub_categoryID = $token;
        $subcate -> DeleteSUBCategory($sub_categoryID);
        unset($token, $cipher_method, $enc_key, $enc_iv);
    }

?>